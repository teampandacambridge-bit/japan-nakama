import { __ } from '@wordpress/i18n';
import {
	useBlockProps,
	InspectorControls,
	RichText,
} from '@wordpress/block-editor';

import {
	PanelBody,
	SelectControl,
	CheckboxControl,
	TextControl,
} from '@wordpress/components';

import { useSelect } from '@wordpress/data';
import { useMemo } from '@wordpress/element';
import './editor.scss';

export default function Edit({ attributes, setAttributes }) {
	const {
		heading,
		subHeading,
		selectedCategory = '',
		selectedTags = [],
		selectedPosts = [],
	} = attributes;

	/* ----------------------------------------------------------
	 * 0. NORMALIZE SELECTED POSTS (convert strings → numbers)
	 * ---------------------------------------------------------- */
	const normalizedSelectedPosts = useMemo(() => {
		return selectedPosts.map((id) => Number(id));
	}, [selectedPosts]);

	/* ----------------------------------------------------------
	 * 1. LOAD ALL CATEGORIES
	 * ---------------------------------------------------------- */
	const allCategories = useSelect(
		(select) =>
			select('core').getEntityRecords('taxonomy', 'category', {
				per_page: -1,
			}),
		[]
	);

	const categoryOptions =
		allCategories?.map((cat) => ({
			label: cat.name,
			value: String(cat.id),
		})) || [];

	const categoryId = parseInt(selectedCategory, 10) || 0;

	/* ----------------------------------------------------------
	 * 2. LOAD POSTS IN SELECTED CATEGORY (for tag discovery)
	 * ---------------------------------------------------------- */
	const categoryPosts = useSelect(
		(select) => {
			if (!categoryId) return [];

			return select('core').getEntityRecords('postType', 'post', {
				per_page: -1,
				categories: categoryId,
			});
		},
		[categoryId]
	);

	/* ----------------------------------------------------------
	 * 3. TAG IDS USED IN CATEGORY
	 * ---------------------------------------------------------- */
	const tagIDsFromCategory = useMemo(() => {
		if (!Array.isArray(categoryPosts)) return [];
		const ids = new Set();

		categoryPosts.forEach((post) => {
			if (Array.isArray(post.tags)) {
				post.tags.forEach((id) => ids.add(id));
			}
		});

		return Array.from(ids);
	}, [categoryPosts]);

	/* ----------------------------------------------------------
	 * 4. LOAD TAG OBJECTS
	 * ---------------------------------------------------------- */
	const filteredTags = useSelect(
		(select) => {
			if (!tagIDsFromCategory.length) return [];
			return select('core').getEntityRecords('taxonomy', 'post_tag', {
				include: tagIDsFromCategory.join(','),
				per_page: -1,
			});
		},
		[tagIDsFromCategory]
	);

	/* ----------------------------------------------------------
	 * 5. HANDLE TAG SELECTION
	 * ---------------------------------------------------------- */
	const toggleTagSelection = (tagId) => {
		const id = Number(tagId);

		const updated = selectedTags.includes(id)
			? selectedTags.filter((i) => i !== id)
			: [...selectedTags, id];

		setAttributes({ selectedTags: updated });
	};

	/* ----------------------------------------------------------
	 * 6. LOAD POSTS FILTERED BY CATEGORY + TAGS
	 * ---------------------------------------------------------- */
	const posts = useSelect(
		(select) => {
			if (!categoryId) return [];

			const query = {
				per_page: -1,
				categories: categoryId,
			};

			if (selectedTags.length > 0) {
				query.tags = selectedTags.join(',');
			}

			return select('core').getEntityRecords('postType', 'post', query);
		},
		[categoryId, selectedTags]
	);

	/* ----------------------------------------------------------
	 * 7. LOAD SELECTED POSTS DIRECTLY (ensures preview works)
	 * ---------------------------------------------------------- */
	const selectedPostObjects = useSelect(
		(select) => {
			if (!normalizedSelectedPosts.length) return [];
			return select('core').getEntityRecords('postType', 'post', {
				include: normalizedSelectedPosts.join(','),
				per_page: -1,
			});
		},
		[normalizedSelectedPosts]
	);

	/* ----------------------------------------------------------
	 * 8. BUILD LOOKUP TABLE FOR PREVIEW
	 * ---------------------------------------------------------- */
	const postLookup = useMemo(() => {
		if (!Array.isArray(selectedPostObjects)) return {};
		const lookup = {};
		selectedPostObjects.forEach((p) => {
			lookup[p.id] = p;
		});
		return lookup;
	}, [selectedPostObjects]);

	/* ----------------------------------------------------------
	 * 9. HANDLE POST SELECTION
	 * ---------------------------------------------------------- */
	const togglePostSelection = (postId) => {
		const id = Number(postId);

		const updated = normalizedSelectedPosts.includes(id)
			? normalizedSelectedPosts.filter((i) => i !== id)
			: [...normalizedSelectedPosts, id];

		setAttributes({ selectedPosts: updated });
	};

	/* ---------------------------------------------------------- */

	return (
		<>
			<InspectorControls>

				{/* CATEGORY SELECTOR */}
				<PanelBody title={__('Select Category', 'card-slider-six')} initialOpen={true}>
					<SelectControl
						label={__('Category', 'card-slider-six')}
						value={selectedCategory}
						options={[
							{ label: __('Select a category', 'card-slider-six'), value: '' },
							...categoryOptions,
						]}
						onChange={(value) =>
							setAttributes({
								selectedCategory: value,
								selectedTags: [],
								selectedPosts: [],
							})
						}
					/>
				</PanelBody>

				{/* TAG FILTER PANEL */}
				<PanelBody title={__('Filter by Tags', 'card-slider-six')} initialOpen={false}>
					{!categoryId && <p>{__('Select a category first.', 'card-slider-six')}</p>}

					{categoryId && Array.isArray(filteredTags) && filteredTags.length === 0 && (
						<p>{__('No tags found for this category.', 'card-slider-six')}</p>
					)}

					{Array.isArray(filteredTags) &&
						filteredTags.map((tag) => (
							<CheckboxControl
								key={tag.id}
								label={tag.name}
								checked={selectedTags.includes(tag.id)}
								onChange={() => toggleTagSelection(tag.id)}
							/>
						))}
				</PanelBody>

				{/* POST SELECTOR */}
				<PanelBody title={__('Select Posts for Slider', 'card-slider-six')} initialOpen={false}>
					{!categoryId && <p>{__('Select a category first.', 'card-slider-six')}</p>}

					{Array.isArray(posts) &&
						posts.map((post) => (
							<CheckboxControl
								key={post.id}
								label={post.title.rendered}
								checked={normalizedSelectedPosts.includes(post.id)}
								onChange={() => togglePostSelection(post.id)}
							/>
						))}
				</PanelBody>

				{/* HEADINGS */}
				<PanelBody title={__('Headings', 'card-slider-six')} initialOpen={false}>
					<TextControl
						label={__('Heading', 'card-slider-six')}
						value={heading}
						onChange={(value) => setAttributes({ heading: value })}
					/>

					<TextControl
						label={__('Sub Heading', 'card-slider-six')}
						value={subHeading}
						onChange={(value) => setAttributes({ subHeading: value })}
					/>
				</PanelBody>

			</InspectorControls>

			{/* EDITOR PREVIEW */}
			<section {...useBlockProps()}>
				<RichText
					tagName="h2"
					value={heading}
					onChange={(value) => setAttributes({ heading: value })}
				/>

				<RichText
					tagName="p"
					value={subHeading}
					onChange={(value) => setAttributes({ subHeading: value })}
				/>

				<ul>
					{normalizedSelectedPosts.length > 0 ? (
						normalizedSelectedPosts.map((id) => {
							const postObj = postLookup[id];

							return (
								<li key={id}>
									{postObj ? (
										<strong>{postObj.title.rendered}</strong>
									) : (
										`Post #${id}`
									)}
								</li>
							);
						})
					) : (
						<li>{__('No posts selected.', 'card-slider-six')}</li>
					)}
				</ul>
			</section>
		</>
	);
}

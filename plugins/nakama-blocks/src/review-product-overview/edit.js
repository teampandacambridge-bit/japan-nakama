import { __ } from '@wordpress/i18n';
import {
	useBlockProps,
	RichText,
	InspectorControls
} from '@wordpress/block-editor';
import {
	Button,
	TextControl,
	PanelBody,
	PanelRow,
	RangeControl
} from '@wordpress/components';
import './editor.scss';

export default function Edit({ attributes, setAttributes }) {
	const {
		heading,
		manufacturer,
		price,
		rating,
		items = [],
		bulletHeading,
		bullets = [],
		consHeading,
		cons = [],
		cta = {},
	} = attributes;

	/* ---------- Helpers for item list ---------- */
	const updateItem = (value, index, field) => {
		const newItems = [...items];
		newItems[index][field] = value;
		setAttributes({ items: newItems });
	};

	const addItem = () => {
		setAttributes({
			items: [...items, { heading: '', description: '' }]
		});
	};

	const removeItem = (index) => {
		const newItems = [...items];
		newItems.splice(index, 1);
		setAttributes({ items: newItems });
	};

	/* ---------- Helpers for bullets (Pros / Cons) ---------- */
	const updateBullet = (listKey, index, newText) => {
		const updatedList = attributes[listKey].map((b, i) =>
			i === index ? newText : b
		);
		setAttributes({ [listKey]: updatedList });
	};

	const addBullet = (listKey) => {
		setAttributes({ [listKey]: [...attributes[listKey], ''] });
	};

	const removeBullet = (listKey, index) => {
		setAttributes({
			[listKey]: attributes[listKey].filter((_, i) => i !== index)
		});
	};

	/* ---------- Rating Stars Renderer ---------- */
	const renderStars = (count) => {
		const stars = [];
		for (let i = 0; i < count; i++) {
			stars.push('⭐');
		}
		return stars.join(' ');
	};

	/* ---------- JSX ---------- */
	return (
		<>
			<section {...useBlockProps()}>
				{/* Editable Title */}
				<RichText
					tagName="h2"
					value={heading}
					onChange={(value) => setAttributes({ heading: value })}
					placeholder={__('Product Review Title…', 'product-review')}
					className="product-review__title"
				/>

				{/* Manufacturer + Price */}
				<div className="product-review__meta">
					{manufacturer && (
						<p>
							<strong>{__('Manufacturer:', 'product-review')}</strong>{' '}
							{manufacturer}
						</p>
					)}
					{price && (
						<p>
							<strong>{__('Price:', 'product-review')}</strong>{' '}
							{price}
						</p>
					)}
					{rating && (
						<p>
							<strong>{__('Rating:', 'product-review')}</strong>{' '}
							{renderStars(rating)} ({rating}/5)
						</p>
					)}
				</div>

				{/* Feature / Details */}
				{items?.length > 0 && (
					<div className="product-review__details">
						<h3>{__('Key Details', 'product-review')}</h3>
						<ul>
							{items.map((item, i) => (
								<li key={i}>
									{item.heading && <strong>{item.heading}</strong>}
									{item.description && (item.heading ? `: ${item.description}` : item.description)}
								</li>
							))}
						</ul>
					</div>
				)}

				{/* Pros */}
				{bullets?.length > 0 && (
					<div className="product-review__pros">
						<h3>{bulletHeading || __('Pros', 'product-review')}</h3>
						<ul>
							{bullets.map((b, i) => (
								<li key={i}>{b}</li>
							))}
						</ul>
					</div>
				)}

				{/* Cons */}
				{cons?.length > 0 && (
					<div className="product-review__cons">
						<h3>{consHeading || __('Cons', 'product-review')}</h3>
						<ul>
							{cons.map((c, i) => (
								<li key={i}>{c}</li>
							))}
						</ul>
					</div>
				)}

				{/* CTA */}
				{cta?.text && cta?.url && (
					<div className="product-review__cta">
						<a href={cta.url} className="button button-primary">
							{cta.text}
						</a>
					</div>
				)}
			</section>

			{/* Inspector Controls (Sidebar) */}
			<InspectorControls>
				<PanelBody title={__('Product Info', 'product-review')} initialOpen={true}>
					<PanelRow>
						<TextControl
							label={__('Manufacturer', 'product-review')}
							value={manufacturer}
							onChange={(value) => setAttributes({ manufacturer: value })}
						/>
					</PanelRow>
					<PanelRow>
						<TextControl
							label={__('Price', 'product-review')}
							value={price}
							onChange={(value) => setAttributes({ price: value })}
						/>
					</PanelRow>
					<PanelRow>
						<RangeControl
							label={__('Rating (1–5)', 'product-review')}
							value={rating}
							onChange={(value) => setAttributes({ rating: value })}
							min={1}
							max={5}
						/>
					</PanelRow>
				</PanelBody>

				{/* Details */}
				<PanelBody title={__('Details', 'product-review')} initialOpen={false}>
					{items.map((item, index) => (
						<div key={index} style={{ marginBottom: '1rem' }}>
							<TextControl
								label={__('Item Heading', 'product-review')}
								value={item.heading}
								onChange={(val) => updateItem(val, index, 'heading')}
							/>
							<TextControl
								label={__('Item Description', 'product-review')}
								value={item.description}
								onChange={(val) => updateItem(val, index, 'description')}
							/>
							<Button
								isDestructive
								onClick={() => removeItem(index)}
								variant="secondary"
							>
								{__('Remove Item', 'product-review')}
							</Button>
						</div>
					))}
					<Button variant="primary" onClick={addItem}>
						{__('Add Item', 'product-review')}
					</Button>
				</PanelBody>

				{/* Pros */}
				<PanelBody title={__('Pros', 'product-review')} initialOpen={false}>
					<TextControl
						label={__('Heading', 'product-review')}
						value={bulletHeading}
						onChange={(value) => setAttributes({ bulletHeading: value })}
					/>
					{bullets.map((b, i) => (
						<div key={i} style={{ display: 'flex', gap: '8px', marginBottom: '6px' }}>
							<TextControl
								value={b}
								onChange={(val) => updateBullet('bullets', i, val)}
								placeholder={__('Add pro…', 'product-review')}
							/>
							<Button isDestructive onClick={() => removeBullet('bullets', i)}>
								{__('Remove', 'product-review')}
							</Button>
						</div>
					))}
					<Button variant="primary" onClick={() => addBullet('bullets')}>
						{__('Add Pro', 'product-review')}
					</Button>
				</PanelBody>

				{/* Cons */}
				<PanelBody title={__('Cons', 'product-review')} initialOpen={false}>
					<TextControl
						label={__('Heading', 'product-review')}
						value={consHeading}
						onChange={(value) => setAttributes({ consHeading: value })}
					/>
					{cons.map((c, i) => (
						<div key={i} style={{ display: 'flex', gap: '8px', marginBottom: '6px' }}>
							<TextControl
								value={c}
								onChange={(val) => updateBullet('cons', i, val)}
								placeholder={__('Add con…', 'product-review')}
							/>
							<Button isDestructive onClick={() => removeBullet('cons', i)}>
								{__('Remove', 'product-review')}
							</Button>
						</div>
					))}
					<Button variant="primary" onClick={() => addBullet('cons')}>
						{__('Add Con', 'product-review')}
					</Button>
				</PanelBody>

				{/* CTA */}
				<PanelBody title={__('Call to Action', 'product-review')} initialOpen={false}>
					<TextControl
						label={__('Button Text', 'product-review')}
						value={cta?.text}
						onChange={(value) => setAttributes({ cta: { ...cta, text: value } })}
					/>
					<TextControl
						label={__('Button URL', 'product-review')}
						value={cta?.url}
						onChange={(value) => setAttributes({ cta: { ...cta, url: value } })}
					/>
				</PanelBody>
			</InspectorControls>
		</>
	);
}

import { __ } from '@wordpress/i18n';
import { useBlockProps, InspectorControls } from '@wordpress/block-editor';
import { PanelBody, TextControl, Button } from '@wordpress/components';
import './editor.scss';

export default function Edit({ attributes = {}, setAttributes }) {
	const {
		heading = '',
		subHeading = '',
		items = [],
	} = attributes;

	const safeItems = Array.isArray(items) ? items : [];

	const updateItem = (index, key, value) => {
		const newItems = [...safeItems];
		newItems[index] = {
			question: '',
			answer: '',
			...newItems[index],
			[key]: value,
		};
		setAttributes({ items: newItems });
	};

	const addItem = () => {
		setAttributes({
			items: [...safeItems, { question: '', answer: '' }],
		});
	};

	const removeItem = (index) => {
		setAttributes({
			items: safeItems.filter((_, i) => i !== index),
		});
	};

	const blockProps = useBlockProps({
		className: 'faq-preview',
	});

	return (
		<>
			<InspectorControls>
				<PanelBody title={__('Headings', 'full-width-card')} initialOpen>
					<TextControl
						label={__('Heading', 'full-width-card')}
						value={heading}
						onChange={(value) => setAttributes({ heading: value || '' })}
					/>

					<TextControl
						label={__('Sub Heading', 'full-width-card')}
						value={subHeading}
						onChange={(value) => setAttributes({ subHeading: value || '' })}
					/>
				</PanelBody>

				<PanelBody title={__('FAQ Items', 'full-width-card')} initialOpen>
					{safeItems.map((item = {}, index) => (
						<div key={index} style={{ marginBottom: '1rem' }}>
							<TextControl
								label={__('Question', 'full-width-card')}
								value={item.question || ''}
								onChange={(value) =>
									updateItem(index, 'question', value)
								}
							/>

							<TextControl
								label={__('Answer', 'full-width-card')}
								value={item.answer || ''}
								onChange={(value) =>
									updateItem(index, 'answer', value)
								}
							/>

							<Button
								isDestructive
								variant="secondary"
								onClick={() => removeItem(index)}
							>
								{__('Remove', 'full-width-card')}
							</Button>

							<hr />
						</div>
					))}

					<Button variant="primary" onClick={addItem}>
						{__('Add FAQ Item', 'full-width-card')}
					</Button>
				</PanelBody>
			</InspectorControls>

			<section {...blockProps}>
				<h2>{heading || __('FAQ Heading', 'full-width-card')}</h2>
				<p>{subHeading || __('FAQ Subheading', 'full-width-card')}</p>

				{safeItems.map((item = {}, i) => (
					<div key={i} className="faq-preview-item">
						<strong>
							{item.question || __('Question…', 'full-width-card')}
						</strong>
						<p>
							{item.answer || __('Answer…', 'full-width-card')}
						</p>
					</div>
				))}
			</section>
		</>
	);
}

import { __ } from '@wordpress/i18n';
import {
	useBlockProps,
	RichText,
	InspectorControls
} from '@wordpress/block-editor';
import {
	Button,
	TextControl,
	TextareaControl,
	PanelBody,
	PanelRow
} from '@wordpress/components';
import './editor.scss';

export default function Edit({ attributes, setAttributes }) {
	const {
		heading = '',
		cost = '',
		address = '',
		hours = '',
		items = [],
		bulletHeading = '',
		bullets = [],
		cta = {}
	} = attributes;

	// --- Items (details) ---
	const updateItem = (value, index, field) => {
		const newItems = [...items];
		newItems[index] = { ...newItems[index], [field]: value };
		setAttributes({ items: newItems });
	};

	const addItem = () => {
		setAttributes({
			items: [...items, { heading: '', description: '' }]
		});
	};

	const removeItem = (index) => {
		setAttributes({
			items: items.filter((_, i) => i !== index)
		});
	};

	// --- Bullets ---
	const updateBullet = (index, newText) => {
		const newBullets = bullets.map((b, i) =>
			i === index ? { text: newText } : b
		);
		setAttributes({ bullets: newBullets });
	};

	const addBullet = () => {
		setAttributes({ bullets: [...bullets, { text: '' }] });
	};

	const removeBullet = (index) => {
		setAttributes({
			bullets: bullets.filter((_, i) => i !== index)
		});
	};

	// --- Main JSX ---
	return (
		<>
			<section {...useBlockProps()}>
				{/* Editable heading in canvas */}
				<RichText
					tagName="h2"
					value={heading}
					onChange={(value) => setAttributes({ heading: value })}
					placeholder={__('Attraction Overview…', 'attraction-overview')}
					className="attraction-overview__title"
				/>

				{/* Preview */}
				<div className="attraction-overview__preview">
					{/* Meta */}
					{(cost || address || hours) && (
						<dl className="overview-meta">
							{cost && (
								<>
									<dt>{__('Cost:', 'attraction-overview')}</dt>
									<dd>{cost}</dd>
								</>
							)}
							{address && (
								<>
									<dt>{__('Address:', 'attraction-overview')}</dt>
									<dd>{address}</dd>
								</>
							)}
							{hours && (
								<>
									<dt>{__('Hours:', 'attraction-overview')}</dt>
									<dd>{hours}</dd>
								</>
							)}
						</dl>
					)}

					{/* Items */}
					{items.length > 0 && (
						<div className="attraction-overview-items">
							<h3>{__('Details', 'attraction-overview')}</h3>
							<ul>
								{items.map((item, i) => (
									<li key={i}>
										{item.heading && <strong>{item.heading}</strong>}
										{item.description && (
											<span>
												{item.heading && ': '}
												{item.description}
											</span>
										)}
									</li>
								))}
							</ul>
						</div>
					)}

					{/* Bullets */}
					{bullets.length > 0 && (
						<div className="attraction-overview-bullets">
							<h3>{bulletHeading || __('Highlights', 'attraction-overview')}</h3>
							<ul>
								{bullets.map((b, i) => (
									<li key={i}>{b.text}</li>
								))}
							</ul>
						</div>
					)}

					{/* CTA */}
					{cta?.text && cta?.url && (
						<div className="attraction-overview-cta">
							<a href={cta.url} className="button button-primary">
								{cta.text}
							</a>
						</div>
					)}
				</div>
			</section>

			{/* Sidebar Controls */}
			<InspectorControls>
				{/* Overview meta */}
				<PanelBody title={__('Attraction Details', 'attraction-overview')} initialOpen={true}>
					<PanelRow>
						<TextControl
							label={__('Cost', 'attraction-overview')}
							value={cost}
							onChange={(value) => setAttributes({ cost: value })}
						/>
					</PanelRow>
					<PanelRow>
						<TextControl
							label={__('Address', 'attraction-overview')}
							value={address}
							onChange={(value) => setAttributes({ address: value })}
						/>
					</PanelRow>
					<PanelRow>
						<TextareaControl
							label={__('Hours', 'attraction-overview')}
							help={__('Enter multiple lines, e.g. "Mon–Fri: 9am–5pm"', 'attraction-overview')}
							value={hours}
							onChange={(value) => setAttributes({ hours: value })}
							rows={4}
						/>
					</PanelRow>
				</PanelBody>

				{/* Items */}
				<PanelBody title={__('Details List', 'attraction-overview')} initialOpen={false}>
					{items.map((item, index) => (
						<div key={index} style={{ marginBottom: '1rem' }}>
							<TextControl
								label={__('Item Heading', 'attraction-overview')}
								value={item.heading}
								onChange={(val) => updateItem(val, index, 'heading')}
							/>
							<TextControl
								label={__('Item Description', 'attraction-overview')}
								value={item.description}
								onChange={(val) => updateItem(val, index, 'description')}
							/>
							<Button
								isDestructive
								onClick={() => removeItem(index)}
								variant="secondary"
							>
								{__('Remove Item', 'attraction-overview')}
							</Button>
						</div>
					))}
					<Button variant="primary" onClick={addItem}>
						{__('Add Item', 'attraction-overview')}
					</Button>
				</PanelBody>

				{/* Bullets */}
				<PanelBody title={__('Highlights (Bullets)', 'attraction-overview')} initialOpen={false}>
					<TextControl
						label={__('Bullet Heading', 'attraction-overview')}
						value={bulletHeading}
						onChange={(value) => setAttributes({ bulletHeading: value })}
					/>
					{bullets.map((item, i) => (
						<div key={i} style={{ display: 'flex', gap: '8px', marginBottom: '6px' }}>
							<TextControl
								value={item.text}
								onChange={(val) => updateBullet(i, val)}
								placeholder={__('Add bullet…', 'attraction-overview')}
							/>
							<Button
								isDestructive
								onClick={() => removeBullet(i)}
							>
								{__('Remove', 'attraction-overview')}
							</Button>
						</div>
					))}
					<Button variant="primary" onClick={addBullet}>
						{__('Add Bullet', 'attraction-overview')}
					</Button>
				</PanelBody>

				{/* CTA */}
				<PanelBody title={__('Call to Action', 'attraction-overview')} initialOpen={false}>
					<TextControl
						label={__('Button Text', 'attraction-overview')}
						value={cta?.text}
						onChange={(value) => setAttributes({ cta: { ...cta, text: value } })}
					/>
					<TextControl
						label={__('Button Link', 'attraction-overview')}
						value={cta?.url}
						onChange={(value) => setAttributes({ cta: { ...cta, url: value } })}
					/>
				</PanelBody>
			</InspectorControls>
		</>
	);
}

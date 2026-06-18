import { __ } from '@wordpress/i18n';
import { useBlockProps, RichText } from '@wordpress/block-editor';
import { Button, TextControl } from '@wordpress/components';
import './editor.scss';

export default function Edit({ attributes, setAttributes }) {
	const { heading, cost, address, startDate, endDate, items, list, listHeading, cta } = attributes;

	const updateItem = (value, index, field) => {
		const newItems = [...items];
		newItems[index][field] = value;
		setAttributes({ items: newItems });
	};

	const addItem = () => {
		const newItems = [
			...items,
			{ heading: 'New Heading', description: 'Description' }
		];
		setAttributes({ items: newItems });
	};

	const removeItem = (index) => {
		const newItems = [...items];
		newItems.splice(index, 1);
		setAttributes({ items: newItems });
	};

	/* ------------------------------
	Additional UL List Controls
   ------------------------------ */
	const updateListItem = (value, index) => {
		const newList = [...list];
		newList[index] = value;
		setAttributes({ list: newList });
	};

	const addListItem = () => {
		setAttributes({ list: [...list, 'List item'] });
	};

	const removeListItem = (index) => {
		const newList = [...list];
		newList.splice(index, 1);
		setAttributes({ list: newList });
	};

	return (
		<section {...useBlockProps()}>

			{/* Heading */}

			<RichText
				tagName="h2"
				value={heading}
				onChange={(value) => setAttributes({ heading: value })}
				placeholder={__('Event Overview…', 'event-overview')}
			/>

			{/* Key Points With Structured Data */}

			<h3>{__('Key Points With Structured Data Attached', 'event-overview')}</h3>
			<ul className="event-overview-meta">
				<li>
					<strong>{__('Cost:', 'event-overview')}</strong>{' '}
					<RichText
						tagName="span"
						value={cost}
						onChange={(value) => setAttributes({ cost: value })}
						placeholder={__('Enter cost…', 'event-overview')}
					/>
				</li>

				<li>
					<strong>{__('Address:', 'event-overview')}</strong>{' '}
					<RichText
						tagName="span"
						value={address}
						onChange={(value) => setAttributes({ address: value })}
						placeholder={__('Enter address…', 'event-overview')}
					/>
				</li>

				<li>
					<strong>{__('Start Date:', 'event-overview')}</strong>
					<div className="event-date-time">
						<TextControl
							label={__('Date', 'event-overview')}
							value={startDate.date}
							type="date"
							onChange={(value) =>
								setAttributes({ startDate: { ...startDate, date: value } })
							}
						/>
						<TextControl
							label={__('Time', 'event-overview')}
							value={startDate.time}
							type="time"
							onChange={(value) =>
								setAttributes({ startDate: { ...startDate, time: value } })
							}
						/>
					</div>
				</li>

				<li>
					<strong>{__('End Date:', 'event-overview')}</strong>
					<div className="event-date-time">
						<TextControl
							label={__('Date', 'event-overview')}
							value={endDate.date}
							type="date"
							onChange={(value) =>
								setAttributes({ endDate: { ...endDate, date: value } })
							}
						/>
						<TextControl
							label={__('Time', 'event-overview')}
							value={endDate.time}
							type="time"
							onChange={(value) =>
								setAttributes({ endDate: { ...endDate, time: value } })
							}
						/>
					</div>
				</li>



			</ul>


			{/* Extra Information - Heading & Description */}

			<h3>{__('Single Items With Descriptive Text Below (No structured Data)', 'event-overview')}</h3>
			<ul className="event-overview-items">
				{items.map((item, index) => (
					<li key={index}>
						<RichText
							tagName="strong"
							value={item.heading}
							onChange={(value) => updateItem(value, index, 'heading')}
							placeholder={__('Heading…', 'event-overview')}
						/>
						<RichText
							tagName="span"
							value={item.description}
							onChange={(value) => updateItem(value, index, 'description')}
							placeholder={__('Description…', 'event-overview')}
						/>
						<Button
							variant="secondary"
							isDestructive
							onClick={() => removeItem(index)}
						>
							{__('Remove', 'event-overview')}
						</Button>
					</li>
				))}
			</ul>

			<Button variant="primary" onClick={addItem}>
				{__('Add Item', 'event-overview')}
			</Button>


			{/* CTA */}

			<h3>{__('CTA', 'event-overview')}</h3>
			<ul>
				<li>
					<strong>{__('Call To Action:', 'event-overview')}</strong>
					<div className="event-overview-cta">
						<TextControl
							label={__('Button Text', 'event-overview')}
							value={cta?.text}
							onChange={(value) => setAttributes({ cta: { ...cta, text: value } })}
							placeholder={__('Buy Tickets', 'event-overview')}
						/>

						<TextControl
							label={__('Button Link', 'event-overview')}
							value={cta?.url}
							onChange={(value) => setAttributes({ cta: { ...cta, url: value } })}
							placeholder="https://example.com"
						/>
					</div>
				</li>
			</ul>

			<h3>{__('Additional List With Bullet Points (No structured Data)', 'event-overview')}</h3>

			<ul className="event-overview-extra-list">

				<RichText
					tagName="span"
					value={listHeading}
					onChange={(value) => setAttributes({ listHeading: value })}
					placeholder={__('Enter List heading', 'event-overview')}
				/>

				{list.map((item, index) => (
					<li key={index}>
						<RichText
							tagName="span"
							value={item}
							onChange={(value) => updateListItem(value, index)}
							placeholder={__('List item…', 'event-overview')}
							allowedFormats={[
								'core/bold',
								'core/italic',
								'core/link'
							]}
						/>

						<Button
							variant="secondary"
							isDestructive
							onClick={() => removeListItem(index)}
						>
							{__('Remove', 'event-overview')}
						</Button>
					</li>
				))}
			</ul>

			<Button variant="primary" onClick={addListItem}>
				{__('Add List Item', 'event-overview')}
			</Button>



		</section >
	);
}

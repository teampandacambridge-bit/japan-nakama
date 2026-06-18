import { useBlockProps, RichText } from '@wordpress/block-editor';
import { Button, TextControl } from '@wordpress/components';
import { __ } from '@wordpress/i18n';

export default function Edit({ attributes, setAttributes }) {
    const {
        heading, cost, address, startDate, endDate,
        items = [], bulletHeading,
        bullets = [], cta
    } = attributes;

    const blockProps = useBlockProps();


    const updateItem = (index, field, value) => {
        const newItems = items.map((item, i) =>
            i === index ? { ...item, [field]: value } : item
        );
        setAttributes({ items: newItems });
    };

    const addItem = () => {
        setAttributes({
            items: [...items, { heading: '', description: '' }],
        });
    };

    const removeItem = (index) => {
        setAttributes({
            items: items.filter((_, i) => i !== index),
        });
    };

    // ----- Bullet Points -----
    const updateBulletItem = (index, newText) => {
        const newBullets = bullets.map((b, i) =>
            i === index ? { ...b, text: newText } : b
        );
        setAttributes({ bullets: newBullets });
    };

    const addBulletItem = () => {
        setAttributes({ bullets: [...bullets, { text: '' }] });
    };

    const removeBulletItem = (index) => {
        setAttributes({
            bullets: bullets.filter((_, i) => i !== index),
        });
    };

    // ----- Render -----
    return (
        <section {...useBlockProps({ className: 'post-overview-edit' })}>

            {/* Heading */}
            <RichText
                tagName="h2"
                value={heading}
                onChange={(value) => setAttributes({ heading: value })}
                placeholder={__('Event Overview…', 'event-overview')}
            />
            {/* Heading */}

            {/* Structured Data */}
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
            {/* Structured Data */}



            <h3>
                {__('Single Items With Descriptive Text Below (No structured Data)', 'event-overview')}
            </h3>

            <ul className="event-overview-items">
                {items.map((item, index) => (
                    <li key={`item-${index}`}>
                        <RichText
                            tagName="h4"
                            value={item.heading}
                            onChange={(value) => updateItem(index, 'heading', value)}
                            placeholder={__('Heading…', 'event-overview')}
                        />
                        <RichText
                            tagName="p"
                            value={item.description}
                            onChange={(value) => updateItem(index, 'description', value)}
                            placeholder={__('Description…', 'event-overview')}
                        />
                        <Button
                            variant="primary"
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

            {/* BULLET POINTS */}
            <h3 style={{ marginTop: '2rem' }}>{__('Bullet List (No structured Data)', 'event-overview')}</h3>

            <ul className="event-overview-bullets">

                <RichText
                    tagName="h4"
                    value={bulletHeading}
                    onChange={(value) => setAttributes({ bulletHeading: value })}
                    placeholder={__('Enter List heading', 'event-overview')}
                />

                {bullets.map((item, index) => (
                    <li
                        key={`bullet-${index}`}
                        style={{ display: 'flex', alignItems: 'center', gap: '8px' }}
                    >
                        <TextControl
                            tagName="p"
                            value={item.text}
                            onChange={(value) => updateBulletItem(index, value)}
                            placeholder={__('List item...', 'event-overview')}
                        />
                        <Button
                            variant="primary"
                            isDestructive
                            onClick={() => removeBulletItem(index)}
                        >
                            {__('Remove', 'event-overview')}
                        </Button>
                    </li>
                ))}
            </ul>

            <Button
                variant="primary"
                onClick={addBulletItem}
                style={{ marginTop: '10px' }}
            >
                {__('Add Bullet', 'event-overview')}
            </Button>

            <h3>{__('CTA', 'event-overview')}</h3>

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



        </section>


    );
}

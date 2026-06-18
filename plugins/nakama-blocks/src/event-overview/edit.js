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
    PanelRow
} from '@wordpress/components';
import './editor.scss';

export default function Edit({ attributes, setAttributes }) {
    const {
        heading = '',
        cost = '',
        address = '',
        startDate = {},
        endDate = {},
        items = [],
        bulletHeading = '',
        bullets = [],
        cta = {}
    } = attributes;

    // ---- Safe initializers ----
    const safeItems = Array.isArray(items) ? items : [];
    const safeBullets = Array.isArray(bullets) ? bullets : [];

    // --- Details Items ---
    const updateItem = (value, index, field) => {
        const newItems = [...safeItems];
        newItems[index] = { ...newItems[index], [field]: value };
        setAttributes({ items: newItems });
    };

    const addItem = () => {
        setAttributes({
            items: [...safeItems, { heading: '', description: '' }]
        });
    };

    const removeItem = (index) => {
        setAttributes({
            items: safeItems.filter((_, i) => i !== index)
        });
    };

    // --- Bullet helpers ---
    const updateBullet = (listKey, index, newText) => {
        const arr = Array.isArray(attributes[listKey]) ? attributes[listKey] : [];
        const updatedList = arr.map((b, i) =>
            i === index ? { text: newText } : b
        );
        setAttributes({ [listKey]: updatedList });
    };

    const addBullet = (listKey) => {
        const arr = Array.isArray(attributes[listKey]) ? attributes[listKey] : [];
        setAttributes({ [listKey]: [...arr, { text: '' }] });
    };

    const removeBullet = (listKey, index) => {
        const arr = Array.isArray(attributes[listKey]) ? attributes[listKey] : [];
        setAttributes({ [listKey]: arr.filter((_, i) => i !== index) });
    };

    // --- Main JSX ---
    return (
        <>
            <section {...useBlockProps()}>
                {/* Editable Title */}
                <RichText
                    tagName="h2"
                    value={heading}
                    onChange={(value) => setAttributes({ heading: value })}
                    placeholder={__('Event Overview…', 'event-overview')}
                    className="event-overview__title"
                />

                {/* Live Preview */}
                <div className="event-overview__preview">
                    {/* Structured Meta */}
                    {(cost || address || startDate?.date || endDate?.date) && (
                        <div className="event-meta">
                            {cost && (
                                <p><strong>{__('Cost:', 'event-overview')}</strong> {cost}</p>
                            )}
                            {address && (
                                <p><strong>{__('Address:', 'event-overview')}</strong> {address}</p>
                            )}
                            {(startDate?.date || startDate?.time) && (
                                <p>
                                    <strong>{__('Start:', 'event-overview')}</strong>{' '}
                                    {startDate?.date || ''}{startDate?.time ? ` @ ${startDate.time}` : ''}
                                </p>
                            )}
                            {(endDate?.date || endDate?.time) && (
                                <p>
                                    <strong>{__('End:', 'event-overview')}</strong>{' '}
                                    {endDate?.date || ''}{endDate?.time ? ` @ ${endDate.time}` : ''}
                                </p>
                            )}
                        </div>
                    )}

                    {/* Feature Items */}
                    {safeItems.length > 0 && (
                        <div className="event-features">
                            <h3>{__('Details', 'event-overview')}</h3>
                            <ul>
                                {safeItems.map((item, i) => (
                                    <li key={i}>
                                        {item.heading && <strong>{item.heading}</strong>}
                                        {item.description && (item.heading ? `: ${item.description}` : item.description)}
                                    </li>
                                ))}
                            </ul>
                        </div>
                    )}

                    {/* Bullets */}
                    {safeBullets.length > 0 && (
                        <div className="event-bullets">
                            <h3>{bulletHeading || __('Highlights', 'event-overview')}</h3>
                            <ul>
                                {safeBullets.map((b, i) => (
                                    <li key={i}>{b.text}</li>
                                ))}
                            </ul>
                        </div>
                    )}

                    {/* CTA */}
                    {cta?.text && cta?.url && (
                        <div className="event-overview-cta">
                            <a href={cta.url} className="button button-primary">
                                {cta.text}
                            </a>
                        </div>
                    )}
                </div>
            </section>

            {/* Sidebar Controls */}
            <InspectorControls>
                {/* Event Details */}
                <PanelBody title={__('Event Details', 'event-overview')} initialOpen={true}>
                    <PanelRow>
                        <TextControl
                            label={__('Cost', 'event-overview')}
                            value={cost}
                            onChange={(value) => setAttributes({ cost: value })}
                        />
                    </PanelRow>
                    <PanelRow>
                        <TextControl
                            label={__('Address', 'event-overview')}
                            value={address}
                            onChange={(value) => setAttributes({ address: value })}
                        />
                    </PanelRow>
                    <PanelRow>
                        <TextControl
                            label={__('Start Date', 'event-overview')}
                            type="date"
                            value={startDate?.date || ''}
                            onChange={(value) => setAttributes({ startDate: { ...startDate, date: value } })}
                        />
                    </PanelRow>
                    <PanelRow>
                        <TextControl
                            label={__('Start Time', 'event-overview')}
                            type="time"
                            value={startDate?.time || ''}
                            onChange={(value) => setAttributes({ startDate: { ...startDate, time: value } })}
                        />
                    </PanelRow>
                    <PanelRow>
                        <TextControl
                            label={__('End Date', 'event-overview')}
                            type="date"
                            value={endDate?.date || ''}
                            onChange={(value) => setAttributes({ endDate: { ...endDate, date: value } })}
                        />
                    </PanelRow>
                    <PanelRow>
                        <TextControl
                            label={__('End Time', 'event-overview')}
                            type="time"
                            value={endDate?.time || ''}
                            onChange={(value) => setAttributes({ endDate: { ...endDate, time: value } })}
                        />
                    </PanelRow>
                </PanelBody>

                {/* Items */}
                <PanelBody title={__('Details', 'event-overview')} initialOpen={false}>
                    {safeItems.map((item, index) => (
                        <div key={index} style={{ marginBottom: '1rem' }}>
                            <TextControl
                                label={__('Item Heading', 'event-overview')}
                                value={item.heading || ''}
                                onChange={(val) => updateItem(val, index, 'heading')}
                            />
                            <TextControl
                                label={__('Item Description', 'event-overview')}
                                value={item.description || ''}
                                onChange={(val) => updateItem(val, index, 'description')}
                            />
                            <Button
                                isDestructive
                                onClick={() => removeItem(index)}
                                variant="secondary"
                            >
                                {__('Remove Item', 'event-overview')}
                            </Button>
                        </div>
                    ))}
                    <Button variant="primary" onClick={addItem}>
                        {__('Add Item', 'event-overview')}
                    </Button>
                </PanelBody>

                {/* Bullets */}
                <PanelBody title={__('Highlights', 'event-overview')} initialOpen={false}>
                    <TextControl
                        label={__('Heading', 'event-overview')}
                        value={bulletHeading}
                        onChange={(value) => setAttributes({ bulletHeading: value })}
                    />
                    {safeBullets.map((item, i) => (
                        <div key={i} style={{ display: 'flex', gap: '8px', marginBottom: '6px' }}>
                            <TextControl
                                value={item.text || ''}
                                onChange={(val) => updateBullet('bullets', i, val)}
                                placeholder={__('Add bullet…', 'event-overview')}
                            />
                            <Button
                                isDestructive
                                onClick={() => removeBullet('bullets', i)}
                            >
                                {__('Remove', 'event-overview')}
                            </Button>
                        </div>
                    ))}
                    <Button variant="primary" onClick={() => addBullet('bullets')}>
                        {__('Add Bullet', 'event-overview')}
                    </Button>
                </PanelBody>

                {/* CTA */}
                <PanelBody title={__('Call to Action', 'event-overview')} initialOpen={false}>
                    <TextControl
                        label={__('Button Text', 'event-overview')}
                        value={cta?.text || ''}
                        onChange={(value) => setAttributes({ cta: { ...cta, text: value } })}
                    />
                    <TextControl
                        label={__('Button Link', 'event-overview')}
                        value={cta?.url || ''}
                        onChange={(value) => setAttributes({ cta: { ...cta, url: value } })}
                    />
                </PanelBody>
            </InspectorControls>
        </>
    );
}

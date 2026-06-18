import { __ } from '@wordpress/i18n';
import {
	useBlockProps,
	RichText,
	InspectorControls,
} from '@wordpress/block-editor';
import { PanelBody, TextControl } from '@wordpress/components';
import { Fragment } from '@wordpress/element';
import './editor.scss';

export default function Edit({ attributes, setAttributes }) {
	const { map, heading, addressEnglish, addressJapanese } = attributes;

	return (
		<section {...useBlockProps()}>
			<InspectorControls>
				<PanelBody title={__('Map Settings', 'google-map')}>
					<TextControl
						label={__('Map Embed URL', 'google-map')}
						value={map}
						onChange={(value) => setAttributes({ map: value })}
						help={__('Paste a Google Maps embed link here.', 'google-map')}
					/>
				</PanelBody>
			</InspectorControls>

			<RichText
				tagName="h2"
				value={heading}
				onChange={(value) => setAttributes({ heading: value })}
				placeholder={__('Write heading…', 'google-map')}
			/>

			{map && (
				<div className="map">
					<iframe
						src={map}
						width="600"
						height="450"
						style={{ border: 0 }}
						allowFullScreen=""
						loading="lazy"
						referrerPolicy="no-referrer-when-downgrade"
					></iframe>
				</div>
			)}

			<RichText
				tagName="h2"
				value={addressEnglish}
				onChange={(value) => setAttributes({ addressEnglish: value })}
				placeholder={__('English Address', 'google-map')}
			/>

			<RichText
				tagName="h2"
				value={addressJapanese}
				onChange={(value) => setAttributes({ addressJapanese: value })}
				placeholder={__('Japanese Address', 'google-map')}
			/>


		</section>
	);
}

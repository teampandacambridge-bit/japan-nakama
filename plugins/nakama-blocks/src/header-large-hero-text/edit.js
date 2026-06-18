import { __ } from '@wordpress/i18n';
import {
	useBlockProps,
	InspectorControls,
} from '@wordpress/block-editor';

import {
	PanelBody,
	TextControl,
	RichText
} from '@wordpress/components';

export default function Edit({ attributes, setAttributes }) {

	const {
		heading_1 = '',
		heading_2 = '',
		subHeading = ''
	} = attributes;

	return (
		<>
			<InspectorControls>
				<PanelBody title={__('Page Header Settings', 'heading-large-hero-text')} initialOpen={true}>

					<TextControl
						label="Heading 1"
						value={heading_1}
						onChange={(value) => setAttributes({ heading_1: value })}
						placeholder="Enter main heading (H1)"
					/>

					<TextControl
						label="Heading 2"
						value={heading_2}
						onChange={(value) => setAttributes({ heading_2: value })}
						placeholder="Enter accent heading"
					/>

					<TextControl
						label="Lead Text"
						value={subHeading}
						onChange={(value) => setAttributes({ subHeading: value })}
						placeholder="Enter lead text"
					/>

				</PanelBody>
			</InspectorControls>

			<section {...useBlockProps()}>
				<h2>Hero Section</h2>

				{heading_1}
				{heading_2}
				{subHeading}

			</section>
		</>
	);
}

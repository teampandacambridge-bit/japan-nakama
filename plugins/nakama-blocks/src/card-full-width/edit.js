import { __ } from '@wordpress/i18n';
import { useBlockProps, InspectorControls, RichText, MediaUpload, MediaUploadCheck } from '@wordpress/block-editor';
import { PanelBody, TextControl, Button } from '@wordpress/components';
import './editor.scss';

export default function Edit({ attributes, setAttributes }) {
	const { heading, subHeading, cta, imageUrl } = attributes;

	const onSelectImage = (media) => {
		setAttributes({
			imageUrl: media.url,
		});
	};

	const removeImage = () => {
		setAttributes({ imageUrl: "" });
	};

	return (
		<>
			<InspectorControls>

				<PanelBody title={__('Headings', 'full-width-card')}>
					<TextControl
						label={__('Heading', 'full-width-card')}
						value={heading}
						onChange={(value) => setAttributes({ heading: value })}
					/>

					<TextControl
						label={__('Sub Heading', 'full-width-card')}
						value={subHeading}
						onChange={(value) => setAttributes({ subHeading: value })}
					/>
				</PanelBody>

				<PanelBody title={__('Call to Action', 'full-width-card')}>
					<TextControl
						label={__('Button Text', 'full-width-card')}
						value={cta?.text}
						onChange={(value) => setAttributes({ cta: { ...cta, text: value } })}
					/>
					<TextControl
						label={__('Button Link', 'full-width-card')}
						value={cta?.url}
						onChange={(value) => setAttributes({ cta: { ...cta, url: value } })}
					/>
				</PanelBody>

				<PanelBody title={__('Image', 'card-full-width')}>

					{/* Show preview if image exists */}
					{imageUrl && (
						<div style={{ marginBottom: '1rem' }}>
							<img src={imageUrl} alt="" style={{ maxWidth: '100%' }} />
						</div>
					)}

					{/* Upload / Change */}
					<MediaUploadCheck>
						<MediaUpload
							onSelect={onSelectImage}
							allowedTypes={['image']}
							render={({ open }) => (
								<Button onClick={open} variant="primary">
									{imageUrl ? __('Change Image', 'card-full-width') : __('Upload Image', 'card-full-width')}
								</Button>
							)}
						/>
					</MediaUploadCheck>

					{/* Remove button */}
					{imageUrl && (
						<Button
							variant="secondary"
							isDestructive
							onClick={removeImage}
							style={{ marginTop: '10px' }}
						>
							{__('Remove Image', 'card-full-width')}
						</Button>
					)}

				</PanelBody>

			</InspectorControls>

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

				{cta?.text && cta?.url && (
					<div>
						<a href={cta.url} className="button button-primary">
							{cta.text}
						</a>
					</div>
				)}

			</section>
		</>
	);
}

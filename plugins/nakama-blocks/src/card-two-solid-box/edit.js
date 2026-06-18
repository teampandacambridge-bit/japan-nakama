import { __ } from '@wordpress/i18n';
import {
	useBlockProps,
	InspectorControls,
	RichText,
	MediaUpload,
	MediaUploadCheck,
} from '@wordpress/block-editor';
import {
	PanelBody,
	TextControl,
	Button
} from '@wordpress/components';
import './editor.scss';

export default function Edit({ attributes, setAttributes }) {

	const { boxLeft, boxRight } = attributes;

	const updateBox = (side, field, value) => {
		const updated = { ...attributes[side], [field]: value };
		setAttributes({ [side]: updated });
	};

	const updateCTA = (side, field, value) => {
		const updated = {
			...attributes[side],
			cta: { ...attributes[side].cta, [field]: value }
		};
		setAttributes({ [side]: updated });
	};

	const imageField = (side) => (
		<MediaUploadCheck>
			<MediaUpload
				onSelect={(media) => updateBox(side, "image", media.url)}
				allowedTypes={["image"]}
				render={({ open }) => (
					<div className="media-field">

						{/* If image exists */}
						{attributes[side].image ? (
							<>
								<img
									src={attributes[side].image}
									onClick={open}
									style={{ cursor: "pointer", maxWidth: "100%" }}
								/>

								<Button
									variant="secondary"
									isDestructive
									onClick={() => updateBox(side, "image", "")}
									style={{ marginTop: "10px", marginBottom: "10px", width: "100%" }}
								>
									Remove Image
								</Button>
							</>

						) : (
							/* No image, show upload button */
							<Button
								onClick={open}
								variant="primary"
								style={{
									marginBottom: "10px", width: "100% "
								}}>
								Upload Image
							</Button>
						)}
					</div>
				)
				}
			/>
		</MediaUploadCheck >
	);


	return (
		<>
			<InspectorControls>
				<PanelBody title="Left Card Settings">
					{imageField("boxLeft")}

					<TextControl
						label="Heading"
						value={boxLeft.heading}
						onChange={(val) => updateBox("boxLeft", "heading", val)}
					/>

					<TextControl
						label="Text"
						value={boxLeft.text}
						onChange={(val) => updateBox("boxLeft", "text", val)}
					/>

					<TextControl
						label="CTA Text"
						value={boxLeft.cta.text}
						onChange={(val) => updateCTA("boxLeft", "text", val)}
					/>

					<TextControl
						label="CTA URL"
						value={boxLeft.cta.url}
						onChange={(val) => updateCTA("boxLeft", "url", val)}
					/>
				</PanelBody>

				<PanelBody title="Right Card Settings" initialOpen={false}>
					{imageField("boxRight")}

					<TextControl
						label="Heading"
						value={boxRight.heading}
						onChange={(val) => updateBox("boxRight", "heading", val)}
					/>

					<TextControl
						label="Text"
						value={boxRight.text}
						onChange={(val) => updateBox("boxRight", "text", val)}
					/>

					<TextControl
						label="CTA Text"
						value={boxRight.cta.text}
						onChange={(val) => updateCTA("boxRight", "text", val)}
					/>

					<TextControl
						label="CTA URL"
						value={boxRight.cta.url}
						onChange={(val) => updateCTA("boxRight", "url", val)}
					/>
				</PanelBody>
			</InspectorControls>

			<section {...useBlockProps()}>
				<h2>Two Solid Blocks</h2>
				<div className="preview-cards">
					<div className="card">
						{boxLeft.image && <img src={boxLeft.image} />}
						<h3>{boxLeft.heading}</h3>
						<p>{boxLeft.text}</p>
						{boxLeft.cta.text && <a href="#">{boxLeft.cta.text}</a>}
					</div>

					<div className="card">
						{boxRight.image && <img src={boxRight.image} />}
						<h3>{boxRight.heading}</h3>
						<p>{boxRight.text}</p>
						{boxRight.cta.text && <a href="#">{boxRight.cta.text}</a>}
					</div>
				</div>
			</section>
		</>
	);
}


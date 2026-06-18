
import { __ } from '@wordpress/i18n';
import { useBlockProps, RichText } from '@wordpress/block-editor';
import './editor.scss';

export default function Edit({ attributes, setAttributes }) {
	const { heading, description, interviewee, interviewer, jobTitle, organization } = attributes;

	return (
		<section {...useBlockProps()}>
			<RichText
				tagName="h2"
				value={heading}
				onChange={(value) => setAttributes({ heading: value })}
				placeholder={__('Title', 'interview-overview')}
			/>

			<RichText
				tagName="p"
				value={description}
				onChange={(value) => setAttributes({ description: value })}
				placeholder={__('Description', 'interview-overview')}
			/>

			<RichText
				tagName="p"
				value={interviewee}
				onChange={(value) => setAttributes({ interviewee: value })}
				placeholder={__('Interviewee', 'interview-overview')}
			/>

			<RichText
				tagName="p"
				value={jobTitle}
				onChange={(value) => setAttributes({ jobTitle: value })}
				placeholder={__('Job Title', 'interview-overview')}
			/>

			<RichText
				tagName="p"
				value={organization}
				onChange={(value) => setAttributes({ organization: value })}
				placeholder={__('Organization', 'interview-overview')}
			/>

			<RichText
				tagName="p"
				value={interviewer}
				onChange={(value) => setAttributes({ interviewer: value })}
				placeholder={__('Interviewer', 'interview-overview')}
			/>
		</section>
	);
}

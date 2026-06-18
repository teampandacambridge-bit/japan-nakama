import { __ } from '@wordpress/i18n';
import {
	useBlockProps
} from '@wordpress/block-editor';

import './editor.scss';

export default function Edit({ attributes, setAttributes }) {


	return (
		<section {...useBlockProps()}>
			<h2>Advert</h2>
		</section>
	);
}

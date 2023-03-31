/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-i18n/
 */
import {__} from '@wordpress/i18n';

/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */
import {useBlockProps} from '@wordpress/block-editor';

/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * Those files can contain any CSS code that gets applied to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */
import './editor.scss';

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {WPElement} Element to render.
 */

import { useState, useEffect } from '@wordpress/element';
import { SelectControl } from '@wordpress/components';

export default function Edit(props) {
	const { attributes, setAttributes } = props;

	const [emails, setEmails] = useState([]);
	const [selectedEmail, setSelectedEmail] = useState(null);

	useEffect(() => {
		wp.ajax.post('get_users_details', {}).done(function (response) {
			console.log(response);
			setEmails(response);
		});
	}, []);

	// useEffect(() => {
	// 	setAttributes({ selectedEmail });
	// }, [selectedEmail]);
	//
	// useEffect(() => {
	// 	setSelectedEmail(attributes.selectedEmail);
	// }, [attributes.selectedEmail]);

	return (
		<SelectControl
			label="Email"
			options={emails}
			value={selectedEmail}
			onChange={(value) => {
				// setSelectedEmail(value)

				console.log("value: ",value)
			}
			}
		/>
	);
}


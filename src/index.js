/**
 * Registers a new block provided a unique name and an object defining its behavior.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-registration/
 */
import { registerBlockType } from '@wordpress/blocks';

import { useState, useEffect } from '@wordpress/element';
import { SelectControl } from '@wordpress/components';

// Define your block in a JavaScript file
registerBlockType('create-block/custom-users-block', {
    title: 'Custom Users Block',
    category: 'common',
    attributes: {
        selectedOption: {type: 'int'}, // Define an attribute to save the selected option
    },
    edit: function(props) {
        const {attributes, setAttributes} = props;
		const [emails, setEmails] = useState([]);

		useEffect(() => {
			wp.ajax.post('get_users_details', {}).done(function (response) {
				console.log(response);
				setEmails(response);
			});
		}, []);

        // Render the select box with options
        return (
			<SelectControl
				label="Email"
				options={emails}
				value={attributes.selectedOption}
				onChange={(value) => setAttributes({selectedOption: value})}
			/>
        );
    },
    save: function(props) {
        const {attributes} = props;

        // Render the selected option
        return (
            <div>
                <p>Selected option: {attributes.selectedOption}</p>
            </div>
        );
    },
});


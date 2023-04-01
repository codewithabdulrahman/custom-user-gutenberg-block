/**
 * Registers a new block provided a unique name and an object defining its behavior.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-registration/
 */

import axios from 'axios';
import { useState, useEffect } from '@wordpress/element';
import { SelectControl, Button } from '@wordpress/components';
import { registerBlockType, getBlockType } from '@wordpress/blocks';

// Define your block in a JavaScript file
registerBlockType('create-block/custom-users-block', {
    title: 'Custom Users Block',
    category: 'common',
    attributes: {
        selectedUserId: { type: 'int' },
        selectedUserName: { type: 'text' },
        selectedUserEmail: { type: 'text' },
        selectedUserImage: { type: 'text' },
    },
    edit: function (props) {
        const { attributes, setAttributes } = props;
        const [emails, setEmails] = useState([]);

        useEffect(() => {
            axios.get(cusBaseUrl.baseUrl + 'cub-get-users/v1/users')
                .then(response => {
                    if(response.data[0]['value'])
                        loadUserDetails(response.data[0]['value'])
                    setEmails(response.data)
                })
                .catch(error => console.error(error));
        }, []);

        const loadUserDetails = (user_id) => {
            axios.get(cusBaseUrl.baseUrl + 'cub-get-users/v1/user/' + user_id)
                .then(response => {
                    setAttributes({ selectedUserId: response.data.ID })
                    setAttributes({ selectedUserName: response.data.display_name })
                    setAttributes({ selectedUserEmail: response.data.user_email })
                    setAttributes({ selectedUserImage: response.data.avatar })
                })
                .catch(error => console.error(error));
        }

        // Render the select box with options
        return (
            <SelectControl
                label="Email"
                options={emails}
                value={attributes.selectedUserId}
                onChange={(value) => loadUserDetails(value)}
            />
        );
    },
    save: function (props) {
        const { attributes } = props;

        // Render the selected option
        return (
            <div class={'user-wrapper-' + attributes.selectedUserId}>
                <img src={attributes.selectedUserImage} alt={attributes.selectedUserName} />
                <div>{attributes.selectedUserName}</div>
                <div>{attributes.selectedUserEmail}</div>
                <div id={'biography-' + attributes.selectedUserId}></div>
                <button class="getBioGraphy" data-id={attributes.selectedUserId}>load user’s biograph</button>
            </div>
        );
    },
});

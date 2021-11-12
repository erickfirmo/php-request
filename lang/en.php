<?php

return [
    // attribute names
    'attributes' => [
        'name' => 'name',
        'email' => 'e-mail',
        'phone' => 'phone',
        'document_number' => 'document number',
    ],
    // error messages
    'messages' => [
        // content not found
        'not_found_content' => 'Content not found.',
        // name
        'name.required' => 'The name is required.',
        'name.max' => 'The name must have a maximum of :max characters.',
        'name.min' => 'The name must have a minimum of :min characters.',
        // email
        'email.required' => 'The e-mail is required.',
        'email.invalid' => 'The e-mail is invalid.',
        'email.max' => 'The e-mail must have a maximum of :max characters.',
        'email.min' => 'The e-mail must have a minimum of :min characters.',
        'email.unique' => 'The email is already in use.',
        // phone
        'phone.required' => 'The phone is required.',
        'phone.invalid' => 'The phone is invalid.',
        // document number
        'document_number.required' => 'The document number is required.',
        'document_number.invalid' => 'The document number is invalid.',
    ]
];
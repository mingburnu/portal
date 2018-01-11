<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => 'The :attribute must be accepted.',
    'active_url' => 'The :attribute is not a valid URL.',
    'after' => 'The :attribute must be a date after :date.',
    'alpha' => 'The :attribute may only contain letters.',
    'alpha_dash' => 'The :attribute may only contain letters, numbers, and dashes.',
    'alpha_num' => 'The :attribute may only contain letters and numbers.',
    'array' => 'The :attribute must be an array.',
    'before' => 'The :attribute must be a date before :date.',
    'between' => [
        'numeric' => 'The :attribute must be between :min and :max.',
        'file' => 'The :attribute must be between :min and :max kilobytes.',
        'string' => 'The :attribute must be between :min and :max characters.',
        'array' => 'The :attribute must have between :min and :max items.',
    ],
    'boolean' => 'The :attribute field must be true or false.',
    'confirmed' => 'The :attribute confirmation does not match.',
    'date' => 'The :attribute is not a valid date.',
    'date_format' => 'The :attribute does not match the format :format.',
    'different' => 'The :attribute and :other must be different.',
    'digits' => 'The :attribute must be :digits digits.',
    'digits_between' => 'The :attribute must be between :min and :max digits.',
    'email' => 'The :attribute must be a valid email address.',
    'exists' => 'The selected :attribute is invalid.',
    'filled' => 'The :attribute field is required.',
    'image' => 'The :attribute must be an image.',
    'in' => 'The selected :attribute is invalid.',
    'integer' => 'The :attribute must be an integer.',
    'ip' => 'The :attribute must be a valid IP address.',
    'json' => 'The :attribute must be a valid JSON string.',
    'max' => [
        'numeric' => 'The :attribute may not be greater than :max.',
        'file' => 'The :attribute may not be greater than :max kilobytes.',
        'string' => 'The :attribute may not be greater than :max characters.',
        'array' => 'The :attribute may not have more than :max items.',
    ],
    'mimes' => 'The :attribute must be a file of type: :values.',
    'min' => [
        'numeric' => 'The :attribute must be at least :min.',
        'file' => 'The :attribute must be at least :min kilobytes.',
        'string' => 'The :attribute must be at least :min characters.',
        'array' => 'The :attribute must have at least :min items.',
    ],
    'not_in' => 'The selected :attribute is invalid.',
    'numeric' => 'The :attribute must be a number.',
    'regex' => 'The :attribute format is invalid.',
    'required' => 'The :attribute field is required.',
    'required_if' => 'The :attribute field is required when :other is :value.',
    'required_with' => 'The :attribute field is required when :values is present.',
    'required_with_all' => 'The :attribute field is required when :values is present.',
    'required_without' => 'The :attribute field is required when :values is not present.',
    'required_without_all' => 'The :attribute field is required when none of :values are present.',
    'same' => 'The :attribute and :other must match.',
    'size' => [
        'numeric' => 'The :attribute must be :size.',
        'file' => 'The :attribute must be :size kilobytes.',
        'string' => 'The :attribute must be :size characters.',
        'array' => 'The :attribute must contain :size items.',
    ],
    'string' => 'The :attribute must be a string.',
    'timezone' => 'The :attribute must be a valid zone.',
    'unique' => 'The :attribute has already been taken.',
    'url' => 'The :attribute format is invalid.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'login fail' => 'Login Failed !',
        'account' => [
            'required' => 'Please input your account .'
        ],
        'password' => [
            'required' => 'Please input yout password.',
            'min' => 'Set Minimum password length to at least a value of :min .',
        ],
        'site_name' => [
            'required' => 'Please Website Title .',
        ],
        'logo' => [
            'max' => ':attribute Max file size：1MB .',
            'image' => ':attribute Upload image type .'
        ],
        'copyright' => [
            'required' => 'Please input :attribute .',
        ],
        'mail' => [
            'required' => 'Please input your account .',
            'email' => 'Check if email addresses are valid .',
        ],
        'email' => [
            'unique' => 'The account has already existed .',
            'email' => 'Please input email accout .',
        ],
        'pwd' => [
            'required' => 'Please input password .',
        ],
        'perm' => [
            'ne' => "Can't delete super admin accout .",
        ],
        '0_title' => [
            'required' => 'Please input :attribute messages .'
        ],
        'title' => [
            'required' => 'Please input :attribute name .'
        ],
        'url' => [
            'required' => 'Please input :attribute .',
            'url' => ':attribute Input format must be an url (include http://)',
            'regex' => ':attribute Input format must be an url (include http://)'
        ],
        'upload_file' => [
            'required' => 'Please uploda:attribute .',
            'max' => ':attribute Max file size：1MB .',
            'image' => ':attribute Upload image type .',
        ],
        'img' => [
            'required' => "Please input images's url .",
            'url' => 'Input format must be an url (include http://)',
            'regex' => 'Input format must be an url (include http://)'
        ],
        'content' => [
            'required' => 'Please input :attribute .'
        ],
        'publish_day' => [
            'required' => 'Please input the announcement time .',
            'date_format' => 'Please input vaild date .',
            'after' => 'The announcement time is too early .',
            'before' => 'The announcement time is too late .'
        ],
        'publish_hh' => [
            'required' => 'Required',
            'date_format' => 'Please input valid announcement hours'
        ],
        'publish_ii' => [
            'required' => 'Required',
            'date_format' => 'Please input valid announcement minutes'
        ],
        'publish_ss' => [
            'required' => 'Required',
            'date_format' => 'Please input valid announcement seconds'
        ],
        'end_day' => [
            'required' => 'Please input a legal end time .'
        ],
        'end_date' => [
            'date_format' => 'Please input a legal end time .',
            'after' => 'The end time is too early .',
            'before' => 'The end time is too late .'
        ],
        'end_hh' => [
            'required' => 'Required',
            'date_format' => 'Please input a legal end time.(hour)'
        ],
        'end_ii' => [
            'required' => 'Required',
            'date_format' => 'Please input a legal end time.(minutes)'
        ],
        'end_ss' => [
            'required' => 'Required',
            'date_format' => 'Please input a legal end time.(seconds)'
        ],
        'end_time' => [
            'after' => 'Announcement time must be earlier than the end time .'
        ],
        'parent_id' => [
            'in' => 'The position is wrong .',
            'node' => 'The position is wrong .',
        ],
        'book_name' => [
            'required' => 'Please input :attribute .'
        ],
        'cover' => [
            'required' => 'Please input book cover image url .',
            'url' => 'Input format must be an url (include http://)',
            'regex' => 'Input format must be an url (include http://)'
        ],
        'database_name' => [
            'required' => 'Please input :attribute .'
        ],
        'syntax' => [
            'required' => 'Please input :attribute .'
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [],

];

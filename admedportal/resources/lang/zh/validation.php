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
        'login fail' => '登入失敗。',
        'account' => [
            'required' => '請輸入您的帳號。'
        ],
        'password' => [
            'required' => '請輸入您的密碼。',
            'min' => '密碼至少:min個字元。',
        ],
        'site_name' => [
            'required' => '請輸入網站名稱。',
        ],
        'logo' => [
            'max' => ':attribute最大上傳大小：1MB。',
            'image' => ':attribute請上傳正確格式圖片。'
        ],
        'copyright' => [
            'required' => '請輸入:attribute。',
        ],
        'mail' => [
            'required' => '請輸入帳號。',
            'email' => '帳號的格式必須為有效的E-Mail。',
        ],
        'email' => [
            'unique' => '帳號已存在。',
            'email' => '請輸入符合格式之電子信箱',
        ],
        'pwd' => [
            'required' => '請輸入密碼。',
        ],
        'perm' => [
            'ne' => '無法刪除最高管理者帳號。',
        ],
        '0_title' => [
            'required' => '請輸入:attribute訊息名稱。'
        ],
        'title' => [
            'required' => '請輸入:attribute名稱。'
        ],
        'url' => [
            'required' => '請輸入:attribute。',
            'url' => ':attribute格式必須為網址(含http://)。',
            'regex' => ':attribute格式必須為網址(含http://)。'
        ],
        'upload_file' => [
            'required' => '請上傳:attribute。',
            'max' => ':attribute最大上傳大小：1MB。',
            'image' => ':attribute請上傳正確格式圖片。',
        ],
        'img' => [
            'required' => '請輸入圖檔網址。',
            'url' => '圖檔網址格式必須為網址(含http://)。',
            'regex' => '圖檔網址格式必須為網址(含http://)。'
        ],
        'content' => [
            'required' => '請輸入:attribute。'
        ],
        'publish_day' => [
            'required' => '請輸入公告日期。',
            'date_format' => '請輸入正確格式公告日期。',
            'after' => '公告日期太早。',
            'before' => '公告日期太晚。'
        ],
        'publish_hh' => [
            'required' => '公告時必須填。',
            'date_format' => '請輸入正確格式公告時。'
        ],
        'publish_ii' => [
            'required' => '公告分必須填。',
            'date_format' => '請輸入正確格式公告分。'
        ],
        'publish_ss' => [
            'required' => '公告秒必須填。',
            'date_format' => '請輸入正確格式公告秒。'
        ],
        'end_day' => [
            'required' => '請輸入結束日期。',
            'date_format' => '請輸入正確格式結束日期。',
            'after' => '結束日期太早。',
            'before' => '結束日期太晚。'
        ],
        'end_hh' => [
            'required' => '結束時必須填。',
            'date_format' => '請輸入正確格式結束時。'
        ],
        'end_ii' => [
            'required' => '結束分必須填。',
            'date_format' => '請輸入正確格式結束分。'
        ],
        'end_ss' => [
            'required' => '結束秒必須填。',
            'date_format' => '請輸入正確格式結束秒。'
        ],
        'end_time' => [
            'after' => '公告時間必須早於結束時間。'
        ],
        'parent_id' => [
            'in' => '位置不正確。',
            'node' => '位置不正確。',
        ],
        'book_name' => [
            'required' => '請輸入:attribute。'
        ],
        'cover' => [
            'required' => '請輸入書封圖檔網址。',
            'url' => '書封圖檔網址格式必須為網址(含http://)。',
            'regex' => '書封圖檔網址格式必須為網址(含http://)。'
        ],
        'database_name' => [
            'required' => '請輸入:attribute。'
        ],
        'syntax' => [
            'required' => '請輸入:attribute。'
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

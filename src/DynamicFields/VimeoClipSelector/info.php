<?php
return [
    'setting' => [
        'sample_text' => [
            '_type' => 'text',
            '_section' => '기본설정',
            'label' => '샘플 문구',
            'placeholder' => '샘플용 설정 필드입니다.',
            'description' => '샘플용 설정 필드입니다.',
        ],
        'client_key' => [
            '_type' => 'text',
            '_section' => '클라이언트키',
            'label' => '클라이언트키',
            'placeholder' => '비메오 클라이언트키를 발급받아주세요',
            'description' => '비메오 클라이언트키를 발급받아주세요',
        ],
    ],
    'support' => [
        'mobile' => true,
        'desktop' => true
    ]
];


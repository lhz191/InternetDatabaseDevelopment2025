<?php
return [
    'language' => 'zh-CN',
    'timeZone' => 'Asia/Shanghai',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'formatter' => [
            'class' => 'yii\i18n\Formatter',
            'defaultTimeZone' => 'Asia/Shanghai', // 数据库中存储的是北京时间
            'timeZone' => 'Asia/Shanghai',        // 显示时也使用北京时间
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
    ],
];

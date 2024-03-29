<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application. Just store away!
    |
    */

//    'default' => env('FILESYSTEM_DRIVER', 'local'),
    'default' => 'oss',

    /*
    |--------------------------------------------------------------------------
    | Default Cloud Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Many applications store files both locally and in the cloud. For this
    | reason, you may specify a default "cloud" driver here. This driver
    | will be bound as the Cloud disk implementation in the container.
    |
    */

    'cloud' => env('FILESYSTEM_CLOUD', 's3'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many filesystem "disks" as you wish, and you
    | may even configure multiple disks of the same driver. Defaults have
    | been setup for each driver as an example of the required options.
    |
    | Supported Drivers: "local", "ftp", "sftp", "s3", "rackspace"
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
        ],

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
        ],

        'admin' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'visibility' => 'public',
            'url' => env('APP_URL') . '/storage',
        ],

        'alioss' => [
            'driver'        => 'oss',
            'access_id'     => 'LTAI4G3jyhkNyYrhCWGqGMKy',
            'access_key'    => 'eRIZoLj36NIuV6n9zBdBYSSRqHobMt',
            'bucket'        => 'daiwei-oss',
            'endpoint'      => 'oss-cn-beijing.aliyuncs.com', // OSS 外网节点或自定义外部域名
            'cdnDomain'     => '', // 如果isCName为true, getUrl会判断cdnDomain是否设定来决定返回的url，如果cdnDomain未设置，则使用endpoint来生成url，否则使用cdn
            'ssl'           => true,  // true to use 'https://' and false to use 'http://'. default is false,
            'isCName'       => false, // 是否使用自定义域名,true: 则Storage.url()会使用自定义的cdn或域名生成文件url， false: 则使用外部节点生成url
            'debug'         => false,
            'url'           => 'https://oss-cn-beijing.aliyuncs.com/'
    ],

        // 仪器图片
        'instrument' => [
            'driver' => 'local',
            'root' => storage_path('app/public/instrument'),
            'visibility' => 'public',
            'url' => env('APP_URL') . '/storage/instrument',
        ],

        // 汽车图片
        'automobile' => [
            'driver'     => 'local',
            'root'       => storage_path('app/public/automobile'),
            'visibility' => 'public',
            'url' => env('APP_URL').'/storage/automobile',
        ],

    ],

];

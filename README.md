# Flysystem Adapter for Aliyun OSS.

This is a Flysystem adapter for the Aliyun OSS ~2.0.4

inspire by [aobozhang/aliyun-oss-adapter](https://github.com/aobozhang/aliyun-oss-adapter)

## Installation

```bash
composer require apollopy/flysystem-aliyun-oss
```

## for Laravel

This service provider must be registered.

```php
// config/app.php

'providers' => [
    '...',
    ApolloPY\Flysystem\AliyunOss\AliyunOssServiceProvider::class,
];
```

edit the config file: config/filesystems.php

add config

```php
'oss' => [
    'driver'     => 'oss',
    'access_id'  => env('OSS_ACCESS_ID','your id'),
    'access_key' => env('OSS_ACCESS_KEY','your key'),
    'bucket'     => env('OSS_BUCKET','your bucket'),
    'endpoint'   => env('OSS_ENDPOINT','your endpoint'),
    'prefix'     => env('OSS_PREFIX', ''), // optional
],
```

change default to oss

```php
    'default' => 'oss'
```

## Use

see [Laravel wiki](https://laravel.com/docs/5.1/filesystem)

## Plugins

inspire by [itbdw/laravel-storage-qiniu](https://github.com/itbdw/laravel-storage-qiniu)

```php
Storage::disk('oss')->putFile($path, '/local_file_path/1.png', ['mimetype' => 'image/png']);
Storage::disk('oss')->signedDownloadUrl($path, 3600, 'oss-cn-beijing.aliyuncs.com', true);
```

## IDE Helper

if installed [barryvdh/laravel-ide-helper](https://github.com/barryvdh/laravel-ide-helper)

edit the config file: config/ide-helper.php

```php
'interfaces'      => [
    '\Illuminate\Contracts\Filesystem\Filesystem' => ApolloPY\Flysystem\AliyunOss\FilesystemAdapter::class,
],
```

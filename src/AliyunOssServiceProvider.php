<?php

namespace ApolloPY\Flysystem\AliyunOss;

use Storage;
use OSS\OssClient;
use League\Flysystem\Filesystem;
use Illuminate\Support\ServiceProvider;
use ApolloPY\Flysystem\AliyunOss\Plugins\PutFile;
use ApolloPY\Flysystem\AliyunOss\Plugins\signedDownloadUrl;

/**
 * Aliyun Oss ServiceProvider class
 *
 * @author  ApolloPY <ApolloPY@Gmail.com>
 * @package ApolloPY\Flysystem\AliyunOss
 */
class AliyunOssServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        Storage::extend('oss', function ($app, $config) {
            $accessId = $config['access_id'];
            $accessKey = $config['access_key'];
            $endPoint = $config['endpoint'];
            $bucket = $config['bucket'];

            $client = new OssClient($accessId, $accessKey, $endPoint);
            $adapter = new AliyunOssAdapter($client, $bucket);

            $filesystem = new Filesystem($adapter);
            $filesystem->addPlugin(new PutFile());
            $filesystem->addPlugin(new signedDownloadUrl());

            return $filesystem;
        });
    }

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}

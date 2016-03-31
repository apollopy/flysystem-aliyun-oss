<?php

namespace ApolloPY\Flysystem\AliyunOss\Plugins;

use League\Flysystem\Plugin\AbstractPlugin;

/**
 * PrivateDownloadUrl class
 * 获取私有下载地址
 *
 * @author  ApolloPY <ApolloPY@Gmail.com>
 */
class SignedDownloadUrl extends AbstractPlugin
{
    /**
     * Get the method name.
     *
     * @return string
     */
    public function getMethod()
    {
        return 'signedDownloadUrl';
    }

    /**
     * Handle.
     *
     * @param string $path
     * @param int    $expires
     * @param string $host_name
     * @param bool   $use_ssl
     * @return string|false
     */
    public function handle($path, $expires = 3600, $host_name = '', $use_ssl = false)
    {
        if (! method_exists($this->filesystem, 'getAdapter')) {
            return false;
        }

        if (! method_exists($this->filesystem->getAdapter(), 'getSignedDownloadUrl')) {
            return false;
        }

        return $this->filesystem->getAdapter()->getSignedDownloadUrl($path, $expires, $host_name, $use_ssl);
    }
}

<?php

namespace ApolloPY\Flysystem\AliyunOss\Plugins;

use League\Flysystem\Plugin\AbstractPlugin;

/**
 * PrivateDownloadUrl class
 * 获取私有下载地址
 *
 * @author  ApolloPY <ApolloPY@Gmail.com>
 * @package ApolloPY\Flysystem\AliyunOss\Plugins
 */
class PrivateDownloadUrl extends AbstractPlugin
{
    /**
     * Get the method name.
     *
     * @return string
     */
    public function getMethod()
    {
        return 'privateDownloadUrl';
    }

    /**
     * Handle
     *
     * @param string $path
     * @param int    $expires
     * @return string|false
     */
    public function handle($path, $expires = 3600)
    {
        if (!method_exists($this->filesystem, 'getAdapter')) {
            return false;
        }

        if (!method_exists($this->filesystem->getAdapter(), 'getPrivateDownloadUrl')) {
            return false;
        }

        return $this->filesystem->getAdapter()->getPrivateDownloadUrl($path, $expires);
    }
}

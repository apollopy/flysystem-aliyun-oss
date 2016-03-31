<?php

namespace ApolloPY\Flysystem\AliyunOss {
    exit('This file should not be included, only analyzed by your IDE');

    class FilesystemAdapter extends \Illuminate\Filesystem\FilesystemAdapter
    {
        /**
         * Write using a local file path.
         *
         * @param string $path
         * @param string $localFilePath
         * @param array  $config
         * @return bool
         */
        public function putFile($path, $localFilePath, array $config = [])
        {
            return Plugins\PutFile::handle($path, $localFilePath, $config);
        }

        /**
         * Get the signed download url of a file.
         *
         * @param string $path
         * @param int    $expires
         * @param string $host_name
         * @param bool   $use_ssl
         * @return string|false
         */
        public function signedDownloadUrl($path, $expires = 3600, $host_name = '', $use_ssl = false)
        {
            return Plugins\SignedDownloadUrl::handle($path, $expires, $host_name, $use_ssl);
        }
    }
}

<?php

namespace ApolloPY\Flysystem\AliyunOss {
    exit("This file should not be included, only analyzed by your IDE");

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
         * Get the private download url of a file.
         *
         * @param     $path
         * @param int $expires
         * @return false|string
         */
        public function privateDownloadUrl($path, $expires = 3600)
        {
            return Plugins\PrivateDownloadUrl::handle($path, $expires);
        }
    }
}

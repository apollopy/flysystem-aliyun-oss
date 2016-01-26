<?php

namespace ApolloPY\Flysystem\AliyunOss {
    exit("This file should not be included, only analyzed by your IDE");

    class FilesystemAdapter extends \Illuminate\Filesystem\FilesystemAdapter
    {
        /**
         * Handle
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
    }
}

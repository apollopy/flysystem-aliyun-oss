<?php

namespace ApolloPY\Flysystem\AliyunOss\Tests;

use OSS\OssClient;
use PHPUnit_Framework_TestCase;
use League\Flysystem\Filesystem;
use ApolloPY\Flysystem\AliyunOss\Plugins\PutFile;
use ApolloPY\Flysystem\AliyunOss\AliyunOssAdapter;

class AliyunOssAdapterTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var \League\Flysystem\Filesystem
     */
    protected $filesystem;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        /*
         * TODO 测试依赖
         */
        $accessId = 'you access id';
        $accessKey = 'you access key';
        $endPoint = 'oss-cn-beijing.aliyuncs.com';
        $bucket = 'you bucket';

        $client = new OssClient($accessId, $accessKey, $endPoint);
        $adapter = new AliyunOssAdapter($client, $bucket);

        $adapter->deleteDir('test');
        $adapter->setPathPrefix('test');

        $filesystem = new Filesystem($adapter);
        $filesystem->addPlugin(new PutFile());

        $this->filesystem = $filesystem;
    }

    public function testPutFile()
    {
        $tmpfile = tempnam(sys_get_temp_dir(), 'OSS');
        file_put_contents($tmpfile, 'put file');

        $this->assertTrue($this->filesystem->putFile('1.txt', $tmpfile));
        $this->assertSame('put file', $this->filesystem->read('1.txt'));

        unlink($tmpfile);
        $this->filesystem->delete('1.txt');
    }

    /**
     * 1.txt.
     */
    public function testWrite()
    {
        $this->assertTrue($this->filesystem->write('1.txt', '123'));
    }

    /**
     * 1.txt
     * 2.txt.
     */
    public function testWriteStream()
    {
        $stream = tmpfile();
        fwrite($stream, 'OSS text');
        rewind($stream);

        $this->assertTrue($this->filesystem->writeStream('2.txt', $stream));

        fclose($stream);
    }

    /**
     * 1.txt
     * 2.txt.
     */
    public function testUpdate()
    {
        $this->assertTrue($this->filesystem->update('1.txt', '456'));
    }

    /**
     * 1.txt
     * 2.txt.
     */
    public function testUpdateStream()
    {
        $stream = tmpfile();
        fwrite($stream, 'OSS text2');
        rewind($stream);

        $this->assertTrue($this->filesystem->updateStream('2.txt', $stream));

        fclose($stream);
    }

    public function testHas()
    {
        $this->assertTrue($this->filesystem->has('1.txt'));
        $this->assertFalse($this->filesystem->has('3.txt'));
    }

    /**
     * 1.txt
     * 2.txt
     * 3.txt.
     */
    public function testCopy()
    {
        $this->assertTrue($this->filesystem->copy('1.txt', '3.txt'));
        $this->assertTrue($this->filesystem->has('3.txt'));
    }

    /**
     * 1.txt
     * 2.txt.
     */
    public function testDelete()
    {
        $this->assertTrue($this->filesystem->delete('3.txt'));
        $this->assertFalse($this->filesystem->has('3.txt'));
    }

    /**
     * 3.txt
     * 2.txt.
     */
    public function testRename()
    {
        $this->assertTrue($this->filesystem->rename('1.txt', '3.txt'));
        $this->assertFalse($this->filesystem->has('1.txt'));
        $this->assertTrue($this->filesystem->has('3.txt'));
    }

    /**
     * 3.txt
     * 2.txt
     * test/1.txt.
     */
    public function testCreateDir()
    {
        $this->assertTrue($this->filesystem->createDir('test'));
        $this->assertTrue($this->filesystem->copy('2.txt', 'test/1.txt'));
    }

    public function testListContents()
    {
        $list = $this->filesystem->listContents('');
        $this->assertArraySubset(
            [
                [
                    'type' => 'file',
                    'path' => '2.txt',
                ],
                [
                    'type' => 'file',
                    'path' => '3.txt',
                ],
                [
                    'type' => 'dir',
                    'path' => 'test',
                ],
            ],
            $list
        );

        $list = $this->filesystem->listContents('', true);
        $this->assertArraySubset(
            [
                [
                    'type' => 'file',
                    'path' => '2.txt',
                ],
                [
                    'type' => 'file',
                    'path' => '3.txt',
                ],
                [
                    'type' => 'dir',
                    'path' => 'test',
                ],
                [
                    'type' => 'file',
                    'path' => 'test/1.txt',
                ],
            ],
            $list
        );
    }

    /**
     * 3.txt
     * 2.txt.
     */
    public function testDeleteDir()
    {
        $this->assertTrue($this->filesystem->deleteDir('test'));
        $this->assertFalse($this->filesystem->has('test/'));
    }

    public function testRead()
    {
        $this->assertInternalType('string', $this->filesystem->read('2.txt'));
    }

    public function testReadStream()
    {
        $this->assertInternalType('resource', $this->filesystem->readStream('2.txt'));
    }

    public function testGetMetadata()
    {
        $data = $this->filesystem->getMetadata('2.txt');

        $this->assertArrayHasKey('type', $data);
        $this->assertArrayHasKey('dirname', $data);
        $this->assertArrayHasKey('path', $data);
        $this->assertArrayHasKey('timestamp', $data);
        $this->assertArrayHasKey('mimetype', $data);
        $this->assertArrayHasKey('size', $data);
    }

    public function testGetMimetype()
    {
        $this->assertInternalType('string', $this->filesystem->getMimetype('2.txt'));
    }

    public function testGetTimestamp()
    {
        $this->assertInternalType('integer', $this->filesystem->getTimestamp('2.txt'));
    }

    public function testGetSize()
    {
        $this->assertInternalType('integer', $this->filesystem->getSize('2.txt'));
    }
}

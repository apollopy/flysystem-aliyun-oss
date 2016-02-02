# ChangeLog

## 1.1.3

* 支持 config/filesystems.php 里配置目录前缀 (使用场景: 希望开发环境下上传的文件不要覆盖业务环境下上传的文件)

## 1.1.2

* Plugin/PrivateDownloadUrl 改为 Plugin/SignedDownloadUrl, 获得带签名且有过期时间的下载地址, 支持自定义 hostname 和选择是否使用 ssl (使用场景: 远程配置上传地址为内网, 但需要获得外网的临时下载地址提供给用户)

## 1.1.1

* ~~添加 Plugin/PrivateDownloadUrl, 获得私有下载地址~~ **(该方法设计不成熟, 下一版本就改掉了, 如要使用此功能, 建议升级 1.1.2)**
* 添加 _ide_helper.php, 让 FilesystemAdapter __call 调用 Plugin 时, IDE 有代码提示

## 1.1.0

* 添加 Plugin/PutFile 方法, 支持指定本地文件路径上传到 OSS
* AliyunOssAdapter 支持外部传入 mimetype 和 size 两个参数

## 1.0.0

* AliyunOssAdapter 实现 League\Flysystem\Adapter\AbstractAdapter 定义的所有接口
* 添加 AliyunOssServiceProvider 用于 Laravel 注册

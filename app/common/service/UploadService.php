<?php

namespace app\common\service;

use app\common\model\Config as ConfigModel;
use think\App;

class UploadService extends AbstractService
{

    public function __construct(App $app)
    {
        parent::__construct($app);
    }
    /**
     * @param $object
     * @param $path
     * @return string
     * @throws \Exception
     * 七牛oss
     */
    public function qiniuoss($object, $path)
    {
        $config = ConfigModel::where('group', 'qiniuoss')->column('value', 'code');
        $auth = new \Qiniu\Auth($config['qiniuoss_accesskey'], $config['qiniuoss_accesssecret']);
        $token = $auth->uploadToken($config['qiniuoss_bucket']);
        $upManager = new \Qiniu\Storage\UploadManager();
        list($ret, $error) = $upManager->putFile($token, $object, $path);
        try {
            if ($config['qiniuoss_cdn_domain']) {
                $osspath = ltrim($config['qiniuoss_cdn_domain'], '/') . '/' . ltrim($object, '/');
            } else {
                $osspath = '/' . $ret['key'];
            }
            return $osspath;
        } catch (\Qiniu\Http\Error $e) {

            return $e->getMessage();
        }


    }

    /**
     * @param $object
     * @param $path
     * @return string
     * alioss
     */
    public function alioss($object, $path)
    {
        $config = ConfigModel::where('group', 'alioss')->column('value', 'code');
        try {
            $ossClient = new \OSS\OssClient($config['alioss_accesskey'], $config['alioss_accesssecret'], $config['alioss_endpoint']);
            $oss = $ossClient->uploadFile($config['alioss_bucket'], $object, $path);
            if ($config['alioss_cdn_domain']) {
                $osspath = ltrim($config['alioss_cdn_domain'], '/') . '/' . ltrim($object, '/');
            } else {
                $osspath = $oss['info']['url'];
            }
            unlink($path);
            return $osspath;
        } catch (\OSS\Core\OSSException $e) {
            return $e->getMessage();

        }
    }

    /**
     * @param $object
     * @param $path
     * @return string
     * 腾迅oss
     */
    public function qcloudoss($object, $path)
    {
        $config = ConfigModel::where('group', 'qcloudoss')->column('value', 'code');
        try {
            $ossClient = new \Qcloud\Cos\Client(
                [
                    'region' => $config['qcloudoss_region'],
                    'credentials' => [
                        'secretId' => $config['qcloudoss_secretId'],
                        'secretKey' => $config['qcloudoss_secretKey'],
                    ]
                ]);
            $oss = $ossClient->Upload(
                $config['qcloudoss_bucket'],
                $config['qcloudoss_key'],
                $body = fopen($path, 'rb'));
            if ($config['qcloudoss_cdn_domain']) {
                $osspath = ltrim($config['qcloudoss_cdn_domain'], '/') . '/' . ltrim($object, '/');
            } else {
                $osspath = $oss['info']['url'];
            }
            unlink($path);
            return $osspath;
        } catch (\Qcloud\Cos\Exception\CosException $e) {
            return $e->getMessage();

        }
    }
}
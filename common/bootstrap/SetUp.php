<?php

namespace common\bootstrap;

use core\entities\power\Products;
use core\entities\Task;
use core\jobs\power\ProductJob;
use core\jobs\size\CategoryJob;
use core\jobs\size\ParseJob;
use core\jobs\size\XlsJob as SizeXlsJob;
use core\jobs\size\XmlJob as SizeXmlJob;
use core\jobs\power\XlsJob as PowerXlsJob;
use core\jobs\power\XmlJob as PowerXmlJob;
use yii\base\BootstrapInterface;
use yii\httpclient\Client;
use yii\queue\ErrorEvent;
use yii\queue\ExecEvent;
use yii\queue\PushEvent;
use yii\queue\Queue;

class SetUp implements BootstrapInterface
{

    /**
     * @param \yii\base\Application $app
     */
    public function bootstrap($app)
    {
        $container = \Yii::$container;

        $container->set(Client::class, function () use ($app) {
            return new Client([
                'transport' => 'yii\httpclient\CurlTransport',
            ]);
        });


    }


}
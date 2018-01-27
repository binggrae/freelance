<?php


namespace core\services;


use core\pages\HomePage;
use yii\httpclient\Client as BaseClient;
use yii\httpclient\Request;

class Client
{
    /**
     * @var BaseClient
     */
    private $client;

    public function __construct(BaseClient $client)
    {
        $this->client = $client;
    }


    public function get($url, $data = [])
    {
        return $this->send('get', $url, $data);

    }

    public function post($url, $data = [])
    {
        return $this->send('post', $url, $data);
    }


    /**
     * @param Request[] $requests
     * @return \yii\httpclient\Response[]
     */
    public function batch($requests)
    {
        return $this->client->batchSend($requests);
    }


    /**
     * @param $method
     * @param $url
     * @param array $data
     * @return Request
     */
    private function send($method, $url, $data = [])
    {
        $opt = [
            CURLOPT_COOKIEJAR => \Yii::getAlias('@common/data/cookie.txt'),
            CURLOPT_COOKIEFILE => \Yii::getAlias('@common/data/cookie.txt'),
            CURLOPT_TIMEOUT => 100,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/61.0.3163.100 Safari/537.36',
//            CURLOPT_VERBOSE => true,
        ];

        if (isset($data['proxy'])) {
            $proxy = $data['proxy'];
            $opt[CURLOPT_PROXY] = $proxy;
            $opt[CURLOPT_COOKIEJAR] = \Yii::getAlias('@common/data/cookie.'.md5($proxy).'.txt');
            $opt[CURLOPT_COOKIEFILE] = \Yii::getAlias('@common/data/cookie.'.md5($proxy).'.txt');
            unset($data['proxy']);
        }


        $response = $this->client->createRequest()
            ->setMethod($method)
            ->setUrl($url)
            ->setData($data)
            ->setOptions($opt);

        return $response;
    }


    public static function getProxy()
    {
        $proxies = [
             [701, '5.8.37.225', '8085'],
            [702, '146.185.201.23', '8085'],
            [703, '46.148.112.56', '8085'],
            [704, '46.161.62.98', '8085'],
            [705, '5.101.217.71', '8085'],
            [706, '5.101.222.115', '8085'],
            [707, '146.185.200.75', '8085'],
            [708, '5.8.37.209', '8085'],
            [709, '46.148.127.96', '8085'],
            [710, '46.148.112.63', '8085'],
            [712, '46.148.127.85', '8085'],
            [714, '46.161.62.59', '8085'],
            [715, '146.185.200.98', '8085'],
            [717, '46.148.112.117', '8085'],
            [719, '46.148.127.103', '8085'],
            [721, '46.148.120.171', '8085'],
            [724, '79.110.25.145', '8085'],
            [725, '46.161.63.78', '8085'],
            [727, '46.148.127.145', '8085'],
            [728, '93.179.89.46', '8085'],
            [730, '46.148.112.52', '8085'],
            [732, '46.161.63.96', '8085'],
            [733, '79.110.25.230', '8085'],
            [735, '46.161.63.16', '8085'],
            [737, '46.148.120.170', '8085'],
            [739, '46.161.63.83', '8085'],
            [740, '46.161.62.27', '8085'],
            [741, '93.179.89.31', '8085'],
            [744, '46.148.120.148', '8085'],
            [747, '46.148.112.130', '8085'],
            [748, '79.110.25.175', '8085'],
            [749, '46.148.112.172', '8085'],
            [750, '46.148.112.116', '8085'],
            [751, '46.148.127.192', '8085'],
            [752, '46.148.120.33', '8085'],
            [755, '79.110.25.240', '8085'],
            [756, '5.8.37.249', '8085'],
            [757, '46.161.62.111', '8085'],
            [758, '46.148.127.222', '8085'],
            [760, '46.161.63.62', '8085'],
            [763, '46.148.120.52', '8085'],
            [764, '46.161.62.108', '8085'],
            [765, '46.148.112.53', '8085'],
            [766, '146.185.200.29', '8085'],
            [772, '46.148.112.155', '8085'],
            [776, '46.148.120.45', '8085'],
            [780, '46.148.112.190', '8085'],
            [781, '146.185.201.62', '8085'],
            [782, '46.148.127.136', '8085'],
            [784, '146.185.200.58', '8085'],
            [785, '5.101.222.33', '8085'],
            [786, '93.179.89.82', '8085'],
            [790, '93.179.89.12', '8085'],
            [791, '146.185.201.78', '8085'],
            [792, '46.148.120.38', '8085'],
            [793, '146.185.200.113', '8085'],
            [794, '146.185.201.108', '8085'],
            [795, '46.148.120.60', '8085'],
            [796, '79.110.25.222', '8085'],
            [798, '46.161.62.34', '8085'],
            [799, '46.148.127.212', '8085'],
            [801, '79.110.25.249', '8085'],
            [802, '79.110.25.183', '8085'],
            [803, '93.179.89.27', '8085'],
            [805, '146.185.201.70', '8085'],
            [806, '46.161.63.38', '8085'],
            [807, '46.148.127.243', '8085'],
            [808, '93.179.89.67', '8085'],
            [810, '93.179.89.95', '8085'],
            [811, '46.148.120.53', '8085'],
            [812, '79.110.25.138', '8085'],
            [815, '185.14.195.206', '8085'],
            [816, '46.148.127.94', '8085'],
            [817, '79.110.25.245', '8085'],
            [820, '46.148.127.216', '8085'],
            [821, '46.148.127.81', '8085'],
            [822, '46.161.63.36', '8085'],
            [824, '46.148.112.150', '8085'],
            [825, '93.179.89.57', '8085'],
            [826, '46.148.120.43', '8085'],
            [829, '5.101.217.19', '8085'],
            [830, '5.101.217.76', '8085'],
            [831, '146.185.201.53', '8085'],
            [836, '46.148.120.135', '8085'],
            [837, '146.185.200.33', '8085'],
            [838, '46.148.127.183', '8085'],
            [840, '79.110.25.162', '8085'],
            [841, '46.148.112.77', '8085'],
            [842, '5.101.222.18', '8085'],
            [843, '146.185.201.83', '8085'],
            [844, '5.101.217.100', '8085'],
            [845, '46.161.62.86', '8085'],
            [847, '46.148.127.241', '8085'],
            [848, '46.148.112.126', '8085'],
            [849, '46.148.112.173', '8085'],
            [850, '46.148.127.204', '8085'],
            [851, '93.179.89.52', '8085'],
            [853, '46.148.127.218', '8085'],
            [854, '46.148.127.122', '8085'],
            [855, '93.179.89.93', '8085'],
            [859, '185.14.195.223', '8085'],
            [862, '46.148.120.22', '8085'],
            [863, '79.110.25.135', '8085'],
            [865, '46.148.120.57', '8085'],
            [866, '185.14.195.201', '8085'],
            [867, '185.14.195.217', '8085'],
            [869, '46.161.63.107', '8085'],
            [870, '185.14.195.209', '8085'],
            [872, '46.161.63.110', '8085'],
            [874, '46.148.112.135', '8085'],
            [875, '46.148.127.153', '8085'],
            [876, '5.101.222.108', '8085'],
            [878, '46.148.127.181', '8085'],
            [879, '146.185.201.64', '8085'],
            [882, '46.161.62.105', '8085'],
            [883, '5.101.217.25', '8085'],
            [886, '46.148.112.88', '8085'],
            [887, '5.8.37.211', '8085'],
            [889, '46.148.112.50', '8085'],
            [891, '79.110.25.194', '8085'],
            [892, '185.14.195.143', '8085'],
            [897, '46.148.112.170', '8085'],
            [898, '5.101.222.71', '8085'],
            [899, '5.101.217.118', '8085'],
            [900, '185.14.195.137', '8085'],
            [901, '79.110.25.182', '8085'],
            [902, '46.148.120.98', '8085'],
            [903, '146.185.200.50', '8085'],
            [904, '46.148.120.104', '8085'],
            [905, '46.148.120.142', '8085'],
            [906, '5.8.37.252', '8085'],
            [907, '46.148.127.194', '8085'],
            [908, '5.101.222.91', '8085'],
            [909, '46.148.120.123', '8085'],
            [910, '79.110.25.246', '8085'],
            [912, '46.148.127.207', '8085'],
            [913, '5.101.222.48', '8085'],
            [914, '146.185.200.12', '8085'],
            [915, '46.148.112.156', '8085'],
            [916, '46.161.62.113', '8085'],
            [917, '185.14.195.184', '8085'],
            [918, '5.101.222.41', '8085'],
            [919, '46.161.62.55', '8085'],
            [920, '46.148.112.72', '8085'],
            [921, '93.179.89.103', '8085'],
            [923, '79.110.25.205', '8085'],
            [927, '146.185.201.21', '8085'],
            [930, '46.148.120.93', '8085'],
            [931, '93.179.89.30', '8085'],
            [933, '46.148.112.45', '8085'],
            [935, '46.161.63.46', '8085'],
            [936, '46.148.120.47', '8085'],
            [937, '93.179.89.123', '8085'],
            [938, '46.148.127.92', '8085'],
            [939, '5.101.222.119', '8085'],
            [941, '185.14.195.179', '8085'],
            [942, '46.148.120.168', '8085'],
            [943, '46.161.62.85', '8085'],
            [944, '146.185.200.19', '8085'],
            [945, '46.148.120.84', '8085'],
            [946, '46.161.63.84', '8085'],
            [949, '46.161.63.27', '8085'],
            [951, '185.14.195.166', '8085'],
            [952, '46.148.112.133', '8085'],
            [953, '5.101.217.127', '8085'],
            [954, '46.148.112.85', '8085'],
            [956, '46.148.112.35', '8085'],
            [957, '79.110.25.129', '8085'],
            [959, '46.148.120.96', '8085'],
            [960, '46.148.112.149', '8085'],
            [961, '46.148.120.116', '8085'],
            [962, '46.148.120.29', '8085'],
            [963, '185.14.195.161', '8085'],
            [964, '5.101.217.124', '8085'],
            [965, '46.148.112.20', '8085'],
            [966, '46.148.127.125', '8085'],
            [967, '46.148.120.80', '8085'],
            [968, '46.148.112.140', '8085'],
            [969, '185.14.195.235', '8085'],
            [970, '46.148.120.102', '8085'],
            [971, '93.179.89.126', '8085'],
            [973, '46.161.63.58', '8085'],
            [974, '185.14.195.172', '8085'],
            [975, '46.148.112.86', '8085'],
            [976, '46.148.127.171', '8085'],
            [978, '79.110.25.237', '8085'],
            [979, '5.101.222.97', '8085'],
            [980, '93.179.89.37', '8085'],
            [981, '5.101.217.51', '8085'],
            [983, '93.179.89.21', '8085'],
            [984, '46.148.127.82', '8085'],
            [985, '46.148.112.162', '8085'],
            [988, '5.101.222.84', '8085'],
            [989, '146.185.201.114', '8085'],
            [990, '146.185.201.14', '8085'],
            [991, '79.110.25.193', '8085'],
            [992, '93.179.89.39', '8085'],
            [994, '5.101.217.15', '8085'],
            [996, '46.148.127.161', '8085'],
            [998, '79.110.25.221', '8085'],
            [1000, '46.148.127.186', '8085'],
            [1001, '46.148.112.165', '8085'],
            [1002, '46.148.120.11', '8085'],
            [1003, '5.8.37.208', '8085'],
            [1004, '46.148.120.59', '8085'],
            [1005, '146.185.201.127', '8085'],
            [1006, '46.161.63.54', '8085'],
            [1008, '79.110.25.236', '8085'],
            [1009, '46.148.112.143', '8085'],
            [1010, '185.14.195.152', '8085'],
            [1011, '46.148.127.213', '8085'],
            [1012, '46.148.120.25', '8085'],
            [1014, '46.148.112.102', '8085'],
            [1015, '79.110.25.202', '8085'],
            [1016, '5.101.222.76', '8085'],
            [1017, '146.185.200.118', '8085'],
            [1018, '46.148.127.117', '8085'],
            [1020, '93.179.89.114', '8085'],
            [1021, '79.110.25.233', '8085'],
            [1022, '46.161.63.76', '8085'],
            [1024, '46.161.62.104', '8085'],
            [1027, '146.185.201.111', '8085'],
            [1030, '46.161.63.122', '8085'],
            [1032, '46.148.127.205', '8085'],
            [1033, '46.148.112.32', '8085'],
            [1034, '46.148.120.39', '8085'],
            [1037, '46.148.120.166', '8085'],
            [1038, '46.148.127.148', '8085'],
            [1039, '46.161.63.89', '8085'],
            [1041, '46.161.63.105', '8085'],
            [1043, '46.161.63.113', '8085'],
            [1047, '46.161.62.76', '8085'],
            [1049, '146.185.201.4', '8085'],
            [1050, '146.185.200.41', '8085']
        ];
		


        $proxy = $proxies[array_rand($proxies)];

        return $proxy[1] . ':' . $proxy[2];
    }
}
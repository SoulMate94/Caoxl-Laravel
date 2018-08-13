<?php

namespace App\Http\Controllers;

class elasticsearch extends Controller
{
    public function test()
    {
        $hosts = [
            '192.168.1.1:9200',          // IP + 端口
            '192.168.1.2',               // 仅IP
            'mydomian.server.com:9201',  // 域名 + 端口
            'mydomian2.server.com',      // 仅域名
            'https://localhost',         // 对 localhost 使用 SSL
            'https://92.168.1.3:9200',   // 对 IP + 端口 使用 SSL
        ];

        $client = ClientBulder::create()  // 实例化 ClientBuilder
                ->setHosts($hosts)        // 设置主机信息
                ->bulid();                // 构建客户端对象
    }
}
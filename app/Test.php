<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Test
{
    public  function test($url) {
//        $headers = [
//            'X-Apple-Tz: 0',
//            'X-Apple-Store-Front: 143444,12',
//            'Accept:application/json, text/javascript, */*; q=0.01',
//            'Accept-Encoding: gzip, deflate',
//            'Accept-Language: en-US,en;q=0.5',
//            'Cache-Control: no-cache',
//            'Content-Type: application/x-www-form-urlencoded; charset=utf-8',
////            'Host: www.example.com',
////            'Referer: http://www.example.com/index.php', //Your referrer address
//            'User-Agent: Mozilla/5.0 (X11; Ubuntu; Linux i686; rv:28.0) Gecko/20100101 Firefox/28.0',
//            'X-MicrosoftAjax: Delta=true'
//        ];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
//        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0");
// receive server response ...
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

//        curl_setopt($ch, CURLOPT_HEADER, $headers);   //trace header response
//        curl_setopt($ch, CURLOPT_NOBODY, $headers);  //return body
//        curl_setopt($ch, CURLOPT_URL, $url);   //curl Targeted URL
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
//        curl_setopt($ch, CURLOPT_COOKIE, $cookie);
//        curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
        curl_setopt($ch, CURLOPT_REFERER, 'http://google.com');   //fake referer
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

        $server_output = curl_exec($ch);
//        curl_copy_handle($ch);
        curl_close($ch);
        return $server_output;
    }
}

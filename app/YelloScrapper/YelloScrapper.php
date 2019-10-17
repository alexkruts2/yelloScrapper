<?php

/**
 * 微信公众号文章爬取类
 * 使用方法：
 * $crawler = new YelloScrapper();
 * $content = $crawler->crawByUrl($url);
 */
namespace App\YelloScrapper;

class YelloScrapper
{
    public $ckfile = __DIR__.'./cookie.txt';
    public $baseUrl = "https://www.yellowpages.com.au/find/";
    function getHtmlContent($businessType,$location,$page=''){
        if(empty($page))
            $url = $this->baseUrl.$businessType."/".$location;
        else
            $url = $this->baseUrl.$businessType."/".$location."/page-".$page."?eventType=pagination";
        $timeOut = 20;
        $params = array(
            'url' => $url,
            'host' => '',
            'header' => '',
            'method' => 'GET',
            'referer' => '',
            'cookie_file'=>$this->ckfile,
            'timeout' => $timeOut
        );
        $curlRequest = new curlRequest();
        $curlRequest->init($params);
        $result = $curlRequest->exec();
        return $result;
    }
    function getHtmlContentFromUrl($url){
        $timeOut = 20;
        $params = array(
            'url' => $url,
            'host' => '',
            'header' => '',
            'method' => 'GET',
            'referer' => '',
            'cookie_file'=>$this->ckfile,
            'timeout' => $timeOut
        );
        $curlRequest = new curlRequest();
        $curlRequest->init($params);
        $result = $curlRequest->exec();
        return $result;
    }
    public function getValuesFromHtml($html,$start='',$end=''){
        if(empty($start))
            $startIndex = 0;
        else
            $startIndex = strpos($html,$start);
        $html = substr($html,$startIndex + strlen($start));
        if(empty($end))
            $endIndex = strlen($html);
        else
            $endIndex = strpos($html,$end);
        $result = substr($html,0,$endIndex);
        $result = str_replace('<b>','',$result);
        $result = str_replace('</b>','',$result);
        $result = str_replace('<br/>','',$result);
        $result = trim(preg_replace('/\s\s+/', ' ', $result));
        return $result;
    }




}
?>

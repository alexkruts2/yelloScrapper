<?php
/**
 * Created by PhpStorm.
 * User: MONO
 * Date: 10/26/2017
 * Time: 8:01 AM
 */

namespace App\Api\V1\Controllers;


use Illuminate\Http\Request;
use Goutte\Client;

class ArticleController extends BaseController
{
    public function getArticles(Request $request) {
        $client = new Client();
        $crawler = $client->request('GET', 'https://www.yellowpages.com.au/find/electricians-electrical-contractors/dromana-vic-3936');
//        $crawler = $client->request('GET', 'https://symfony.com/blog/');
        $crawler->filter('div.search-results > div.srp-brand-bar-container-div ')->each(function ($node) {
            print $node->text()."\n";
            echo "<br>";
        });
        echo "exit";



    }

}
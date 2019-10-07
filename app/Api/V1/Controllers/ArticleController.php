<?php
/**
 * Created by PhpStorm.
 * User: MONO
 * Date: 10/26/2017
 * Time: 8:01 AM
 */

namespace App\Api\V1\Controllers;


use Illuminate\Http\Request;
use App\YelloScrapper\YelloScrapper;
use PHPHtmlParser\Dom;

class ArticleController extends BaseController
{
    public $baseUrl = "https://www.yellowpages.com.au/";

    public function getArticles(Request $request) {
//        validate($request->all(), [
//            'category_id' => 'required',
//            'page' => 'required|numeric',
//            'pageSize' => 'numeric'
//        ]);
        $yelloScrapper = new YelloScrapper();
        $html = $yelloScrapper->getHtmlContent("electricians-electrical-contractors","3936");
        $html = $this->getValuesFromHtml($html['body']);

        $dom = new Dom;
        $dom->load($html);

        $items = $dom->find('.search-in-area')[0]->find('.search-results')[0]->find('.find-show-more-trial');
        $resultsInArea = $this->getAreaItems($items);

        $items = $dom->find('.search-target-media-content')[0]->find('.search-result-target-media')[0]->find('.extra-padding');
        $resultExtra = $this->getExtraItems($items);

        $pageNationLinks = $dom->find('.button-pagination-container');
        if(count($pageNationLinks)>0){
            $pageLinks = $pageNationLinks[0]->find('.pagination');
            foreach($pageLinks as $pageLink){
                $url = $this->baseUrl.$pageLink->getAttribute('href');
                $html = $yelloScrapper->getHtmlContentFromUrl($url);
                $html = $this->getValuesFromHtml($html['body']);
                $dom->load($html);
                $temp = $this->getAreaItems($items);
                array_push($resultsInArea,$temp);
            }
        }

        $result = array(
          "in_area"=>$resultsInArea,
            "extra_area"=>$resultExtra
        );
        return $result;
    }

    public function getAreaItems($items){
        $resultsInArea = [];
        foreach($items as $item){
            $names = $item->find('.listing-name');
            if(count($names)<1) continue;
            $name = $names[0]->innerHtml;
            $listingHeader = $item->find('.listing-heading')->firstChild()->innerHtml;
            $phones = $item->find('.click-to-call');
            $phone = count($phones)>0?$phones[0]->getAttribute('href'):'';
            $phone = str_replace("tel:","",$phone);
            $emails = $item->find('.contact-email');
            $email = count($emails)>0?$emails[0]->getAttribute('data-email'):'';
            $webSites = $item->find('.contact-url');
            $website = count($webSites)>0?$webSites[0]->getAttribute('href'):'';
            $temp = array(
                "businessName"=>$name,
                "address"=>$listingHeader,
                "mainPhone"=>$phone,
                "email"=>$email,
                "website"=>$website
            );
            array_push($resultsInArea,$temp);
        }
        return $resultsInArea;

    }

    public function getExtraItems($items){
        $resultExtra = [];
        foreach($items as $item){
            $names = $item->find('.listing-name');
            if(count($names)<1)continue;
            $name = $names[0]->innerHtml;

            $headers = $item->find('.listing-heading');
            $header = count($headers)>0?$headers[0]->innerHtml:'';

            $phones = $item->find('.click-to-call');
            $phone = count($phones)>0?$phones[0]->getAttribute('href'):'';
            $phone = str_replace("tel:","",$phone);

            $emails = $item->find('.contact-email');
            $email = count($emails)>0?$emails[0]->getAttribute('data-email'):'';

            $webSites = $item->find('.contact-url');
            $website = count($webSites)>0?$webSites[0]->getAttribute('href'):'';
            $temp = array(
                "businessName"=>$name,
                "header"=>$header,
                "mainPhone"=>$phone,
                "email"=>$email,
                "website"=>$website
            );
            array_push($resultExtra,$temp);
        }
        return $resultExtra;
    }

    public function getValuesFromHtml($html,$start,$end){
        $startIndex = strpos($html,$start);
        $html = substr($html,$startIndex + strlen($start));
        $endIndex = strpos($html,$end);
        $result = substr($html,0,$endIndex);
        return $result;
    }
}
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
        validate($request->all(), [
            'business_type' => 'required',
            'location' => 'required'
        ]);
        $businessType = $request->get('business_type');
        $location = $request->get('location');
        $yelloScrapper = new YelloScrapper();
        $html = $yelloScrapper->getHtmlContent($businessType,$location);
        $html = $this->getValuesFromHtml($html['body'],"<body data-logged-in=\"false\" class=\"search list-view\" id=\"search-results-page\">","</body>");
        $dom = new Dom;
        $dom->load($html);

        $searchInAreaDom = $dom->find('.search-in-area')[0];
        $searchResultsDom = $searchInAreaDom->find('.search-results')[0];

        $items = $searchResultsDom->find('.find-show-more-trial');
        $resultsInArea = $this->getAreaItems($items);

        $items = $dom->find('.search-target-media-content')[0]->find('.search-result-target-media')[0]->find('.extra-padding');
        $resultExtra = $this->getExtraItems($items);

        $pageNationLinks = $dom->find('.button-pagination-container');
        if(count($pageNationLinks)>0){
            $pageLinks = $pageNationLinks[0]->find('.pagination');
            $pages = [];
            foreach($pageLinks as $pageLink){
                if(empty($pageLink->getAttribute('href'))) continue;
                $url = $this->baseUrl.$pageLink->getAttribute('href');
                if(in_array($url,$pages)) continue;
                array_push($pages,$url);
                $html = $yelloScrapper->getHtmlContentFromUrl($url);
                $htmlstr = $this->getValuesFromHtml($html['body'],"<body data-logged-in=\"false\" class=\"search list-view\" id=\"search-results-page\">","</body>");
                $dom->load($htmlstr);
                $items = $dom->find('.search-in-area')[0]->find('.search-results')[0]->find('.find-show-more-trial');
                $temp = $this->getAreaItems($items);

                $resultsInArea = array_merge($resultsInArea,$temp);
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
            $legalIds = $item->find('.contact-legal-id');
            $legalId = count($legalIds)>0?$legalIds[0]->innerHtml:'';
            $legalId = str_replace('Legal ID:','',$legalId);

            $temp = array(
                "businessName"=>$name,
                "address"=>$listingHeader,
                "mainPhone"=>$phone,
                "email"=>$email,
                "website"=>$website,
                'legalId'=>$legalId
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
        $html = substr($html,$startIndex);
        $endIndex = strpos($html,$end);
        $result = substr($html,0,$endIndex + strlen($end));
        return $result;
    }
}

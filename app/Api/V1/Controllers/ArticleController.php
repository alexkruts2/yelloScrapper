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
    public $license_base_url = "https://www.licensedtrades.com.au/license_lookup";

    public function getArticles(Request $request) {
        validate($request->all(), [
            'business_type' => 'required',
            'location' => 'required'
        ]);
        $businessType = $request->get('business_type');
        $location = $request->get('location');
        $yelloScrapper = new YelloScrapper();
        $html_org = $yelloScrapper->getHtmlContent($businessType,$location);
        $html = $this->getValuesFromHtml($html_org['body'],"<body data-logged-in=\"false\" class=\"search list-view\" id=\"search-results-page\">","</body>");
        $dom = new Dom;
        $dom->load($html);

        $searchInAreaDom = $dom->find('.search-in-area')[0];
        if(empty($searchInAreaDom)){
            error_log('businessType='.$businessType,3,'log.txt');
            error_log("\n",3,'log.txt');
            error_log('location='.$location,3,'log.txt');
            error_log("\n",3,'log.txt');
            error_log($html_org['body'],3,'log.txt');
            error_log("\n",3,'log.txt');
            return "Please check your parameters again";
        }
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


    public function getLicense(Request $request){
        validate($request->all(), [
            'license_number' => 'required',
            'authority_code' => 'required'
        ]);
        $license_number = $request->get('license_number');
        $authority_code = $request->get('authority_code');
        $url = $this->license_base_url."?licensee_business_name=&license_number=".$license_number."&search=Search&authority%5B%5D=".$authority_code;
//        $url = "https://www.licensedtrades.com.au/license_lookup?licensee_business_name=&license_number=1070975&search=Search&authority%5B%5D=4";

        $yelloScrapper = new YelloScrapper();
        $html = $yelloScrapper->getHtmlContentFromUrl($url);
        $variable = $yelloScrapper->getValuesFromHtml($html['body'],'google seo stuff','ref_seo_google_track');
        $variable = $yelloScrapper->getValuesFromHtml($variable,"'","'");
        $searchHtml = base64_decode($variable);
        $dom = new Dom;
        $dom->load($searchHtml);
        $searchItems = $dom->find('.lh_18');
//        echo count($searchItems);
        $results = [];
        foreach($searchItems as $item){
            $temp = [];
            $itemHtml = $item->innerHtml;
            $dom->load($itemHtml);
            $companyNameDom = $dom->find('a');
            $companyName = $companyNameDom[0]->innerHtml;
            $temp['company_name'] = $companyName;
            $companyStateDom =  $dom->find('.bg_secondary');
            $companyState = $companyStateDom[0]->innerHtml;
            $temp['company_state'] = $companyState;
            $locationDom = $dom->find('.mln');
            $location = $locationDom[0]->innerHtml;
            $temp['location'] = $location;
            $blockDoms = $dom->find('.block');
            foreach($blockDoms as $blockDom){
                $each = $blockDom->innerHtml;
                $splitStrs = explode(':',$each);
                $key = $yelloScrapper->getValuesFromHtml($splitStrs[0],'>');
                $value = $yelloScrapper->getValuesFromHtml($splitStrs[1],'>');
                $temp[$key] = $value;
            }
            $trDoms = $dom->find('tr');
            $licenses = [];
            foreach($trDoms as $i=>$trDom){
                $licenseItem = [];
                if($i==0) continue;
                $dom->load($trDom->innerHtml);
                $tdDoms = $dom->find('td');
                $licenseItem['license_class'] = $tdDoms[0]->innerHtml;
                $licenseItem['start_date'] = $tdDoms[1]->innerHtml;
                $licenseItem['end_date'] = $tdDoms[2]->innerHtml;
                array_push($licenses,$licenseItem);
            }
            $temp['licenses'] = $licenses;
            array_push($results,$temp);
        }
        return $results;
    }

}

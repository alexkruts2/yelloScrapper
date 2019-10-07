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

class ArticleController extends BaseController
{
    public function getArticles(Request $request) {
//        validate($request->all(), [
//            'category_id' => 'required',
//            'page' => 'required|numeric',
//            'pageSize' => 'numeric'
//        ]);
        $yelloScrapper = new YelloScrapper();
        $html = $yelloScrapper->getHtmlContent("electricians-electrical-contractors","3936");


        return success([
            'page' => $html['body'],
        ]);
    }

}
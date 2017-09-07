<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\RssHost as RS;
use App\RssPost as RP;
use DateTime;

class RssController extends Controller {

    // read function
    public function read() {
        $json = [];
        $url = [];
        $rss_host = RS::all();

        foreach ($rss_host as $value) {
            // rss host info
            $blog_id = $value->id;
            $rss_title = $value->blog_name;
            $rss_url = $value->blog_url;
            $rss = simplexml_load_file($value->rss_feed);

            // rss version check
            $rss_ver = $rss->attributes()->version;
            if(isset($rss_ver) && $rss_ver == '2.0') {
                // RSS2.0 read
                foreach ($rss->channel->item as $value) {
                    $rss_array = array(
                                         "title"=>(string)$value->title
                                        ,"url"=>(string)$value->link
                                        ,"pubDate"=>new DateTime($value->pubDate)
                                        ,"blog_id"=>$blog_id
                                      );
                    $json[] = json_encode($rss_array, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES );
                }
            }else{
                //RSS1.0 read
                foreach ($rss->item as $value) {
                    $rss_array = array(
                                         "title"=>(string)$value->title
                                        ,"url"=>(string)$value->link
                                        ,"pubDate"=>new DateTime($value->children('http://purl.org/dc/elements/1.1/')->date)
                                        ,"blog_id"=>$blog_id
                                      );
                    $json[] = json_encode($rss_array, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES );
                }
            }

            // insert
            $insert = RP::insert($json);
            $json = [];
        }
    }

    // show function
    public function show() {
        $post = RP::orderBy('pub_date', 'desc')->get();
         return view('home',compact('post'));
    }


}

<?php

namespace App\Http\Controllers;
\File::requireOnce(__DIR__.'.\..\..\Libs\feedwriter\Feed.php');
\File::requireOnce(__DIR__.'.\..\..\Libs\feedwriter\Item.php');
\File::requireOnce(__DIR__.'.\..\..\Libs\feedwriter\ATOM.php');
\File::requireOnce(__DIR__.'.\..\..\Libs\feedwriter\RSS1.php');
\File::requireOnce(__DIR__.'.\..\..\Libs\feedwriter\RSS2.php');

use Illuminate\Http\Request;
use App\RssHost as RS;
use App\RssPost as RP;
use \FeedWriter\ATOM;
use \FeedWriter\RSS1;
use \FeedWriter\RSS2;

use DateTime;
date_default_timezone_set('Asia/Tokyo');

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

    public function rssfeed(Request $request) {
        $type = $request->input('feed');

        switch ($type) {
            case 'atom':
                $feed = new ATOM;
                break;
            case 'rss1':
                $feed = new RSS1;
                break;
            case 'rss2':
                $feed = new RSS2;
                break;
            default:
                $feed = new RSS2;
                break;
        }

        $feed->setTitle('さくら前線');
        $feed->setLink('https://桜前線.com');
        $feed->setDate(new DateTime());

        $post = RP::orderBy('pub_date', 'desc')->take(50)->get();
        foreach ($post as $value) {
            $item = $feed->createNewItem();
            $item->setTitle($value->post_title);
            $item->setLink($value->post_url);
            $item->setDate(strtotime($value->pub_date));
            $item->setAuthor($value->rssHost->blog_name);
            $feed->addItem($item);
        }

        $xml = $feed->generateFeed();
        $dom = new \DOMDocument;
        $dom->loadXML($xml);
        $dom->encoding = 'UTF-8';
        return response($dom->saveXML(), 200)->header('Content-Type', 'application/xml');
    }

}

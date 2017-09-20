<?php

namespace App\Http\Controllers;
\File::requireOnce(__DIR__.'./../../Libs/feedwriter/Feed.php');
\File::requireOnce(__DIR__.'./../../Libs/feedwriter/Item.php');
\File::requireOnce(__DIR__.'./../../Libs/feedwriter/ATOM.php');
\File::requireOnce(__DIR__.'./../../Libs/feedwriter/RSS1.php');
\File::requireOnce(__DIR__.'./../../Libs/feedwriter/RSS2.php');

use Illuminate\Http\Request;
use App\RssHost as RH;
use App\RssPost as RP;
use \FeedWriter\ATOM;
use \FeedWriter\RSS1;
use \FeedWriter\RSS2;

use DateTime;
date_default_timezone_set('Asia/Tokyo');

class RssController extends Controller {

    // show function
    public function index(Request $request) {
        $post_id = $request->input('id');
        $blog = RH::orderBy('id', 'asc')->get();
        $post = RP::orderBy('pub_date', 'desc')->take(50)->get();

        if(isset($post_id)) {
            RP::viewCountUp($post_id);
            $pickup = RP::where('id', $post_id)->get();
            $post = $pickup->merge($post);
        }

        foreach ($blog as $dt) {
            $blogs = RP::where('blog_id', $dt->id)->orderBy('pub_date', 'desc')->take(30)->get();
            if(isset($blog_post)) {
                $blog_post = $blogs->merge($blog_post);
            }else{
                $blog_post = $blogs;
            }
        }

        return view('home',compact('post','post_id','blog','blog_post'));
    }

    // read function
    public static function update() {
        $json = [];
        $url = [];
        $rss_host = RH::all();

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
            RP::insert($json);
            $json = [];
        }
    }

    public function rssfeed(Request $request) {
        $type = $request->input('feed');
        $url = url('/');

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
        $feed->setLink($url);
        $feed->setDate(new DateTime());

        $post = RP::orderBy('pub_date', 'desc')->take(50)->get();
        foreach ($post as $value) {
            $item = $feed->createNewItem();
            $item->setTitle($value->post_title);
            $item->setLink($url.'/?id='.$value->id);
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

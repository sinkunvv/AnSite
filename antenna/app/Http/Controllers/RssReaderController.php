<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\RssHost as RS;

class RssReaderController extends Controller
{
    public function read()
    {
        $title = [];
        $url = [];
        $rss_host = RS::all();

        foreach ($rss_host as $value) {
            // rss host info
            $rss_title = $value->blog_name;
            $rss_url = $value->blog_url;
            $rss = simplexml_load_file($value->rss_feed);

            // rss version check
            $rss_ver = $rss->attributes()->version;
            if(isset($rss_ver) && $rss_ver == '2.0') {
                // RSS2.0 read
                foreach ($rss->channel->item as $value) {
                    $title[] = $value->title;
                    $url[] = $value->link;
                }
            }else{
                //RSS1.0 read
                foreach ($rss->item as $value) {
                    $title[] = $value->title;
                    $url[] = $value->link;

                }
            }
            echo $rss_title;
            echo nl2br("\n");
            echo $rss_url;

            // title view
            foreach ($title as  $value) {
                echo nl2br("\n");
                echo $value;
            }
            $title = [];
            $url = [];
        }
    }
}

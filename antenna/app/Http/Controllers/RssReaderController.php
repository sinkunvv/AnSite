<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RssReaderController extends Controller
{
    public function read()
    {
        $title = [];
        $url = [];
        $rss = simplexml_load_file('https://blog.idevs.jp/?feed=rss2');
        

        // RSS feed read
        foreach ($rss->channel as $value) {
            $rss_title = $value->title;
            $rss_url = $value->link;
        }

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
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RssPost extends Model
{
    protected $table = 'rss_post';
    //protected $dates = ['pub_date'];

    // insert method
    public static function insert($json) {
        foreach ($json as  $value) {
            $RP = new RssPost;
            $array = json_decode($value, false);
            $exist = $RP->where('blog_id', $array->blog_id)
                        ->where('post_url', $array->url)
                        ->exists();
            if(!$exist) {
                $RP->post_title = $array->title;
                $RP->post_url = $array->url;
                $RP->blog_id = $array->blog_id;
                $RP->pub_date = $array->pubDate->date;
                $RP->save();
            }
        }
    }

    public function rssHost() {
         return $this->belongsTo('App\RssHost', 'blog_id');
    }

    public static function viewCountUp($post_id) {
        $exist = RssPost::where('id', $post_id)->exists();
        if($exist) {
            $post = RssPost::where('id', $post_id)
                ->increment('user_view');
        }
    }
}

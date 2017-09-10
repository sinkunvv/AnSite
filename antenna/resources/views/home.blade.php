@extends('layouts.master')

@section('title', 'アンテナサイト')

@section('sidebar')
    @parent
        @foreach ($blog as $dt)
            <li class="pure-menu-item">
                <a href="#{{$dt->blog_name}}" class="pure-menu-link">{{$dt->blog_name}}</a>
            </li>
        @endforeach
@stop

@section('content')
    <div id="new" class="anchor">
        <h1>新着記事</h1>
        <div class="rss-table">
            <table>
                <thead>
                    <tr>
                        <th>時刻</th>
                        <th>タイトル</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($post as $dt)
                    <tr>
                        <td>{{ date('h:i', strtotime($dt->pub_date)) }}</td>
                        <td><a href={{ $dt->post_url }} target="_blank">{{ $dt->post_title }}</a></td>
                        {{-- <td><a href={{ $dt->rssHost->blog_url }}>{{ $dt->rssHost->blog_name }}</a></td> --}}
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @foreach ($blog as $blog_dt)
        <div id="{{$blog_dt->blog_name}}" class="anchor">
            <h1>{{$blog_dt->blog_name}}</h1>
            <div class="rss-table">
                <table>
                    <thead>
                        <tr>
                            <th>時刻</th>
                            <th>タイトル</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($post as $post_dt)
                            @if ($post_dt->blog_id == $blog_dt->id)
                                <tr>
                                    <td>{{ date('m-d h:i', strtotime($post_dt->pub_date)) }}</td>
                                    <td><a href={{ $post_dt->post_url }} target="_blank">{{ $post_dt->post_title }}</a></td>
                                    {{-- <td><a href={{ $dt->rssHost->blog_url }}>{{ $dt->rssHost->blog_name }}</a></td> --}}
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endforeach
@stop

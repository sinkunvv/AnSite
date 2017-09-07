@extends('layouts.master')

@section('title', 'アンテナサイト')

@section('sidebar')
    @parent
    <li class="pure-menu-item menu-item-divided">
        <a href="/base/" class="pure-menu-link">ホーム追加分</a>
    </li>
@stop

@section('content')
    <table>
        <tbody>
            @foreach($post as $dt)
            <tr>
                <td>{{ $dt->pub_date->format('H:i:s') }}</td>
                <td><a href={{ $dt->post_url }}>{{ $dt->post_title }}</a></td>
                <td><a href={{ $dt->rssHost->blog_url }}>{{ $dt->rssHost->blog_name }}</a></td>
            </tr>
            @endforeach
        </tbody>
    </table>
@stop

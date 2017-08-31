@extends('layouts.master')

@section('title', 'アンテナサイト')

@section('sidebar')
    @@parent
    <p>ここはメインのサイドバーに追加される</p>
@endsection

@section('content')
    <p>ここが本文のコンテンツ</p>
@endsection

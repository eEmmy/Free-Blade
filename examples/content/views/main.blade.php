@extends('toExtend')

@section('title')
Main view
@endsection

@section('content')
<b class="red">Hello</b> <b class="green">world</b>!
@endsection

@section('audio')
<audio controls>
	<source src="{ audio('test', 'mp3') }" type="{ audio('mp3') }">
</audio>
@endsection

@section('video')
<video controls style="height: 250px;">
	<source src="{ video('test', 'mp4') }" type="{ video('mp4') }">
</video>
@endsection

@section('image')
<img src="{ image('test', 'jpeg') }" height="250">
@endsection

Main view content
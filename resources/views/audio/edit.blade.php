@extends('audio._form')

@section('page_title')
@if (!empty($audio->recording->artist->artist_display_name))
&raquo; {{ $audio->recording->artist->artist_display_name }}
@endif
&raquo; {{ $audio->audio_file_name }}
&raquo; Delete
@stop

@section('section_header')
<h2>
	@if (!empty($audio->recording->artist->artist_display_name))
	{{ $audio->recording->artist->artist_display_name }}
	<small>{{ $audio->recording->song->song_title }}</small>
	@else
	{{ $audio->recording->song->song_title }}
	@endif
</h2>
@stop

@section('section_label')
<h3>
	Edit
	<small>{{ $audio->audio_file_name }}</small>
</h3>
@stop

@section('content')
{!! Form::model( $audio, array( 'route' => array('audio.update', $audio->audio_id), 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'put' ) ) !!}
@parent
{!! Form::close() !!}
@stop

@section('sidebar')
@if (!empty($audio->audio_file_server) && !empty($audio->audio_file_name) && !empty($audio->audio_file_path))
<h4>Listen</h4>

<p>
	<audio id="file_preview" controls>
		<source src="http://{{ $audio->audio_file_server }}{{ $audio->audio_file_path }}/{{ $audio->audio_file_name }}" type="{{ $audio->audio_file_type }}" />
	</audio>
</p>
@endif

<ul class="list-unstyled">
	<li>&laquo; <a href="{{ route( 'audio.show', $audio->audio_id ) }}">Back to {{ $audio->audio_file_name }}</a></li>
</ul>
@stop
@extends('layout')

@section('page_title')
@if (!empty($artist->artist_display_name))
&raquo; {{ $artist->artist_display_name }}
@endif
 &raquo; Recordings &raquo; Browse
@stop

@section('section_header')
<h2>
	@if (!empty($artist->artist_display_name))
	{{ $artist->artist_display_name }}
	@else
	Observant Records
	@endif
</h2>
@stop

@section('section_label')
<h3>
	Recordings
	<small>Browse</small>
</h3>
@stop

@section('content')

<p>
	@if (!empty($artist->artist_id))
	<a href="{{ route('recording.create', array( 'artist' => $artist->artist_id )) }}" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> Add a recording</a>
	@else
	<a href="{{ route('recording.create') }}" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> Add a recording</a>
	@endif
</p>

@if (count($recordings) > 0)

{!! Form::open(array('id' => 'recording-id', 'class' => 'form-horizontal')) !!}

<div class="form-group">
	<div class="col-sm-12">
		{!! Form::select( 'recording_id', $recordings, null, array('class' => 'form-control', 'id' => 'recording_id') ) !!}
	</div>
</div>

<div class="form-group">
	<div class="col-sm-2">
		{!! Form::button('View', array( 'class' => 'btn btn-default', 'id' => 'select-recording' ) ); !!}
	</div>
</div>

{!! Form::close() !!}

<script type="text/javascript">
	(function ($) {
		$(function () {
			$('#recording_id').chosen();

			var Recording_List = {
				select_recording: function (recording_id) {
					var url = '/recording/' + recording_id;
					location.href = url;
				}
			};

			$('#recording_id').change(function () {
				Recording_List.select_recording(this.value);
			});
			$('#select-recording').click(function () {
				Recording_List.select_recording($('#recording_id').val());
			});
		});
	})(jQuery);
</script>

@endif

@stop

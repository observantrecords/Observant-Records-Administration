@extends('layout')

@section('page_title')
 &raquo; {{ $user->user_name }}
 &raquo; Delete
@stop

@section('section_header')
<h2>{{ $user->user_name }}</h2>
@stop

@section('section_label')
<h3>Delete</h3>
@stop

@section('content')

<p>
	You are about to delete <strong>{{ $user->user_name }}</strong> from the database.
</p>

<p>
	Are you sure you want to do this?
</p>

{!! Form::model( $user, array( 'route' => array('user.destroy', $user->user_id), 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'delete' ) ) !!}

<div class="form-group">
	<div class="col-sm-12">
		<div class="radio">
			<label>
				{!! Form::radio('confirm', '1') !!} Yes, I want to delete {{ $user->user_name }}.
			</label>
		</div>
		<div class="radio">
			<label>
				{!! Form::radio('confirm', '0') !!} No, I don't want to delete {{ $user->user_name }}.
			</label>
		</div>
	</div>
</div>

<div class="form-group">
	<div class="col-sm-12">
		{!! Form::submit('Confirm', array( 'class' => 'btn btn-danger' )) !!}
	</div>
</div>

{!! Form::close() !!}

@stop

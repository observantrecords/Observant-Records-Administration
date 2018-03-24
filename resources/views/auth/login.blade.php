@extends('layout')

@section('section_header')
    <h2>{{ __('Login') }}</h2>
@stop

@section('content')
    <form method="POST" action="{{ route('login') }}" class="form-horizontal" role="form">
        @csrf

        <div class="form-group">
            <label for="user_email" class="col-sm-2 control-label">{{ __('Login') }}</label>

            <div class="col-md-10">
                <input id="user_name" type="text" class="form-control{{ $errors->has('user_name') ? ' is-invalid' : '' }}" name="user_name" value="{{ old('user_name') }}" required autofocus>

                @if ($errors->has('user_name'))
                    <div class="alert alert-danger alert-dismissable">
                        <strong>{{ $errors->first('user_name') }}</strong>
                    </div>
                @endif
            </div>
        </div>

        <div class="form-group">
            <label for="password" class="col-md-2 control-label">{{ __('Password') }}</label>

            <div class="col-md-10">
                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                @if ($errors->has('password'))
                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                @endif
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-offset-2 col-md-10">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> {{ __('Remember Me') }}
                    </label>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-offset-2 col-md-10">
                <button type="submit" class="btn btn-primary">
                    {{ __('Login') }}
                </button>
            </div>
        </div>
    </form>
@endsection

@extends('layout.master')
@section('content')


    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <form action="/login" method="POST">
                {!! csrf_field() !!}
                <div class="form-group">
                    <label for="email" class="control-label {{ $errors->has('email') ? "has-danger" : "" }}"
                           value="{{ old('email') }}">Email</label>
                    <input type="text" class="form-control" id="email" name="email" title="Vaš email"
                           placeholder="Vaš email"
                           value="{{ is_string(request()->query('q-em')) ? request()->query('q-em') : old('email') }}">
                    <div class="error">{{$errors->first('email')}}</div>
                    <div class="error">{{$errors->first('login-email')}}</div>
                </div>
                <div class="form-group">
                    <label for="password" class="control-label {{ $errors->has('password') ? "has-danger" : "" }}">Lozinka</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Vaša lozinka"
                           value="{{ old('password') }}">
                    <div class="error">{{$errors->first('password')}}</div>
                </div>
                <div class="row">

                    <div class="col-md-7 col-md-offset-2" style="text-align:right; margin-top: 10px;">
                        <input type="hidden" name="remember" value="1">
                        <button type="submit" class="btn btn-success">Uloguj me</button>
                        {{--<div class="text-right" style="margin: 30px 0 10px 0;">--}}
                            {{--<a href="{{ route('forgot') }}">Zaboravljena lozinka?</a>--}}
                        {{--</div>--}}
                        {{--<div class="text-right">--}}
                            {{--<a href="{{ route('register') }}">Kreiraj račun </a>--}}
                        {{--</div>--}}
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

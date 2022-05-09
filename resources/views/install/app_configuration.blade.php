@extends('install.layout')

@section('content')

    @if($errors->all())
      <div class="alert alert-danger">
        <ul>
          <a href='#' class="close" data-dismiss="alert" aria-label="close">x</a>
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <h2>3. Admin & App Configuration</h2>
    <form method="POST" action="{{ url(route('store.app.configurations')) }}" class="form-horizontal">
        {{ csrf_field() }}

        <div class="box">
            <p>Please enter a username and password for the administration.</p>

            <div class="configure-form">
                <div class="form-group {{ $errors->has('admin.name') ? 'has-error': '' }}">
                    <label class="control-label col-sm-3" for="admin-name">Name <span>*</span></label>

                    <div class="col-sm-9">
                        <input type="text" name="admin[name]" value="{{ old('admin.name') }}" id="admin-first-name" class="form-control">

                        {!! $errors->first('admin.name', '<span class="help-block">:message</span>') !!}
                    </div>
                </div>

                <div class="form-group {{ $errors->has('admin.mobile') ? 'has-error': '' }}">
                    <label class="control-label col-sm-3" for="admin-last-name">Mobile <span>*</span></label>

                    <div class="col-sm-9">
                        <input type="text" name="admin[mobile]" value="{{ old('admin.mobile') }}" id="admin-mobile" class="form-control">

                        {!! $errors->first('admin.mobile', '<span class="help-block">:message</span>') !!}
                    </div>
                </div>

                <div class="form-group {{ $errors->has('admin.email') ? 'has-error': '' }}">
                    <label class="control-label col-sm-3" for="admin-email">Email <span>*</span></label>

                    <div class="col-sm-9">
                        <input type="text" name="admin[email]" value="{{ old('admin.email') }}" id="admin-email" class="form-control">

                        {!! $errors->first('admin.email', '<span class="help-block">:message</span>') !!}
                    </div>
                </div>

                <div class="form-group {{ $errors->has('admin.password') ? 'has-error': '' }}">
                    <label class="control-label col-sm-3" for="admin-password">Password <span>*</span></label>

                    <div class="col-sm-9">
                        <input type="password" name="admin[password]" id="admin-password" class="form-control">

                        {!! $errors->first('admin.password', '<span class="help-block">:message</span>') !!}
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-3" for="admin-confirm-password">Confirm Password
                      <span>*</span>
                    </label>
                    <div class="col-sm-9">
                        <input type="password" name="admin[password_confirmation]" id="admin-confirm-password" class="form-control">
                    </div>
                </div>

            </div>
        </div>

        <div class="box">
            <p>Please enter your app details.</p>
            <div class="configure-form p-b-0">
                <div class="form-group {{ $errors->has('app.app_name') ? 'has-error': '' }}">
                    <label class="control-label col-sm-3" for="app-name">App Name <span>*</span></label>

                    <div class="col-sm-9">
                        <input type="text" name="app[app_name]" value="{{ old('app.app_name') }}" id="app-name" class="form-control">

                        {!! $errors->first('app.app_name', '<span class="help-block">:message</span>') !!}
                    </div>
                </div>

            </div>
        </div>
        <div class="content-buttons clearfix">
            <button type="submit" class="btn btn-primary pull-right install-button">Install</button>
        </div>
    </form>

@endsection

@extends('admin._layouts.default')

@section('content-wrapper')
<div class="modal show">
    <div class="modal-dialog" style="width:420px;margin-top:120px;">
      <div class="modal-content">
        <div class="modal-header">
          <!-- <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button> -->
          <h4 class="modal-title">Sign In</h4>
        </div>
        {{ Form::open() }}
        <div class="modal-body">
            <div>
                @if ($errors->all())
                <div class="alert alert-dismissable alert-warning">
                  <h4>Warning!</h4>
                  @foreach ($errors->all('<li>:message</li>') as $message)
                  <p>{{ $message }}</p>
                  @endforeach
                </div>
                @endif

                <p>
                    <div class="form-group">
                        {{ Form::text('email', '', array('class' => 'form-control', 'placeholder'=>'Email address')) }}
                        <p class="text-warning">{{ ($errors->has('email') ? $errors->first('email') : '') }}</p>
                    </div>
                    <div class="form-group">
                        {{ Form::password('password', array('class' => 'form-control', 'placeholder'=>'Password')) }}
                        <p class="text-warning">{{ ($errors->has('password') ?  $errors->first('password') : '') }}</p>
                    </div>
                    <div class="form-group">
                        {{ Form::checkbox('remember_me', 'rememberMe') }} Remember me
                    </div>
                </p>
                <p>
                    <a href="{{ URL::to('admin/forgotpwd') }}">I forgot my password</a> <br/>
                    <a href="#register-page" class="text-center">Register a new membership</a>
                </p>
                
            </div>
        </div>
        <div class="modal-footer">
          <a href="{{ URL::to('/') }}">Back to site</a>
          <button type="submit" class="btn btn-primary">Sign in</button>
        </div>
        {{ Form::close() }}
      </div>
    </div>
</div>

@stop
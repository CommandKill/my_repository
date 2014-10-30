@extends('admin._layouts.default')

@section('content-wrapper')
<div class="modal show">
    <div class="modal-dialog" style="width:420px;margin-top:120px;">
      <div class="modal-content">
        <div class="modal-header">
          <!-- <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button> -->
          <h4 class="modal-title">Forgot password</h4>
        </div>
        {{ Form::open() }}
        <div class="modal-body">
            <div>
              @if ($errors->all())
              <div class="notice-box notice-box-warning">
                <h4>Warning!</h4>
                @foreach ($errors->all('<li>:message</li>') as $message)
                <p>{{ $message }}</p>
                @endforeach
              </div>
              @endif
              @if( Session::has('message') )
              <div class="notice-box notice-box-info">
                <h4>Success</h4>
                <p>{{ Session::get('message') }}</p>
              </div>
              @endif
              <div class="body bg-gray">
                  <div class="form-group">
                      {{ Form::text('email', '', array('class' => 'form-control', 'placeholder'=>'Email address')) }}
                      <small>{{ ($errors->has('email') ? $errors->first('email') : '') }}</small>
                  </div>
              </div>
              <!-- <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>"> -->
          </div>
        </div>
        <div class="modal-footer">
          <a href="{{ URL::to('admin/auth/signin') }}" class="btn btn-default">Back to login page</a>
          <button type="submit" class="btn btn-primary">Reset password</button>
        </div>
        {{ Form::close() }}
      </div>
    </div>
</div>

@stop
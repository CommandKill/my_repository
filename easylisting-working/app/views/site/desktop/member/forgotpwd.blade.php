@extends('site.desktop._layouts.index')
@section('content')
<div class="row">
<div class="col-xs-12">
    <div class="container">
        <header><h1>Forgot your password?</h1></header>
        <div class="row">
            <div class="col-xs-4 col-xs-offset-4">
                
                {{ Notification::showAll() }}

                {{ Form::open(array('url' => App::getLocale().'/forgotpwd','id'=>'frmForgot')) }}
                    <div class="form-group">
                        <label for="form-create-account-email">Email:</label>
                        <input type="email" class="form-control" name="email" id="email" placeholder='xxx@xxxx.com' required>
                    </div><!-- /.form-group -->
                  
                    <div class="form-group clearfix">
                        <button type="submit" class="btn pull-right btn-default" id="account-submit">Reset Password</button>
                    </div><!-- /.form-group -->
               	 {{ Form::close() }}
            </div>
        </div><!-- /.row -->
    </div><!-- /.container -->
</div>
</div>
@stop
@section('footer')
{{-- HTML::script('js/sample.js') --}}
<script type="text/javascript">
$(function(){
  
});
</script>
@stop
<li class="dropdown menu-large">
  <a href="#" class="dropdown-toggle" data-toggle="dropdown">
      @if(Session::has('member'))
      <i class="fa fa-car"></i> Hi,  {{ Session::get('member.first_name') }} {{ Session::get('member.last_name') }}<b class="caret"></b>
      @else
      <i class="fa fa-car"></i> My Garage <b class="caret"></b>
      @endif
  </a>
  <div class="dropdown-menu megamenu"> 
    <div class="container">

      <!-- Content -->
      <div class="row">
        <div class="col-sm-6 box-content">
            @if(Session::has('member.avatar'))
            <img class="img-circle pull-left profile" width="120" heigth="120" src="{{ $data['member_root_url'] }}/{{  Session::get('member.id') }}/150x150-{{  Session::get('member.avatar') }}">

            

            @elseif(Session::has('member.facebook_id') && Session::get('member.facebook_id') != '')
            <img class="img-circle pull-left profile" width="120" heigth="120" src="http://graph.facebook.com/{{  Session::get('member.facebook_id') }}/picture?width=120&height=120">
            @else
            <img class="img-circle pull-left profile" width="120" heigth="120" src="<?=asset('img/user-02.jpg')?>">
            @endif
          <ul class="pull-left">
            <li><strong class="header">Welcome back!</strong></li>
            <li>{{ Session::get('member.first_name') }} {{ Session::get('member.last_name') }}</li>
            <li><a href="{{ URL::to(App::getLocale().'/signout') }}" class="btn btn-default btn-sm btn-logout"><strong>{{$data['text']['signout']}}</strong></a></li>
          </ul>
          <ul class="listing pull-right">
            <li><a href="{{ URL::to(App::getLocale().'/profile') }}"><span class="glyphicon glyphicon-chevron-right"></span> {{$data['text']['profile']}}</a></li>
            <li><a href="{{ URL::to(App::getLocale().'/password') }}"><span class="glyphicon glyphicon-chevron-right"></span> {{$data['text']['reset_password']}}</a></li>
            <li><a href="{{ URL::to(App::getLocale().'/my-garage') }}"><span class="glyphicon glyphicon-chevron-right"></span> {{$data['text']['my_garage']}}</a></li>
          </ul>
        </div>
        <div class="col-sm-3 box-content">
          <strong class="header">Save searches</strong>
          <p class="short-desc">Save and run vehicle searches that you perform regularly.</p>
          <a href="{{ URL::to(App::getLocale().'/mysearch') }}"><span class="glyphicon glyphicon-save"></span> {{ $data['savesearch_count'] }} saved</a> 
        </div>
        <div class="col-sm-3">
          <strong class="header">Favourite cars</strong>
          <p class="short-desc">See all the cars saved in your account.</p>
          <a href="{{ URL::to(App::getLocale().'/favourite-cars') }}"><span class="glyphicon glyphicon-search"></span> {{ $data['favorite_count'] }} saved</a> 
        </div>
      </div>
      <!-- Content -->

    </div>
  </div><!-- /.megamenu -->
</li><!-- /.dropdown -->
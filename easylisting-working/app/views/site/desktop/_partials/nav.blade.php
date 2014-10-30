<div class="navbar-placeholder">
    <div id="nav-main" class="navbar navbar-default navbar-static-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="{{ URL::to(App::getLocale().'/') }}">{{ $data['text']['site'] or 'site' }}</a>
        </div><!-- /.navbar-header -->
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li class="dropdown menu-large">
              <a href="" class="dropdown-toggle" data-toggle="dropdown"> {{ $data['text']['buying'] or 'buying' }}<b class="caret"></b></a>
              <div class="dropdown-menu megamenu"> 
                <div class="container">

                  <!-- Content -->
                  <div class="row">
                    <div class="col-xs-4 box-content">
					  <a href="{{ URL::to(App::getLocale().'/p/inspection') }}">	
                      <strong class="header">Inspection Service</strong>
					  
                      <p class="short-desc"><img style="float:left;margin-right:5px;" src="{{ asset('img/icon-inspection@1x.png') }}"> Buying a used car can be daunting. Car inspection will help you decide easier.</p>
					 </a>	
                    </div>
                    <div class="col-xs-4 box-content">
                      <a href="{{ URL::to(App::getLocale().'/p/trusts-checklist') }}"><strong class="header">What is the Trustee checklist</strong>
                      <p class="short-desc">To help build trust in the community, we've introduced the Trustee checklist so you can decide who you should buy your next car from.</p>
                      <a href="{{ URL::to(App::getLocale().'/p/trusts-checklist') }}" style="background: #1ca5ba;color:#fff !important;height:32px !important" class="btn submit-btn" ><i class="glyphicon glyphicon-plus"></i> Learn more..</a>
					  </a>	
                    </div>
                    <div class="col-xs-4">
                      <ul class="listing">
                      <li><a href="{{ URL::to(App::getLocale().'/p/article-0') }}"><span class="glyphicon glyphicon-chevron-right"></span> Buying guide</a></li>
                      <li><a href="{{ URL::to(App::getLocale().'/p/article-1') }}"><span class="glyphicon glyphicon-chevron-right"></span> What is Inspected car</a></li>
                      <li><a href="{{ URL::to(App::getLocale().'/p/article-2') }}"><span class="glyphicon glyphicon-chevron-right"></span> 
What is Verified seller</a></li>
                      <li><a href="{{ URL::to(App::getLocale().'/p/article-3') }}"><span class="glyphicon glyphicon-chevron-right"></span> 
What is the trustee checklist?</a></li>
                    </ul>

                    </div>
                  </div>
                  <!-- Content -->
                </div>
              </div><!-- /.megamenu -->
            </li>
            <li class="dropdown menu-large">
              <a href="" class="dropdown-toggle" data-toggle="dropdown">{{ $data['text']['selling'] or 'selling' }} <b class="caret"></b></a>       
              <div class="dropdown-menu megamenu"> 
                <div class="container">

                  <!-- Content -->
                  <div class="row">
                    <div class="col-xs-4 box-content">
						<a href="{{ URL::to(App::getLocale().'/signup') }}">
                      <strong class="header">Register</strong>
                      <p class="short-desc"><img style="float:left;margin-right:5px;" src="{{ asset('img/icon-register.png') }}"> Ready to buy or sell on Website? Learn how to get a new account by registering. Or get help with signing in to your existing account.</p>
					 </a>
                    </div>
                    <div class="col-xs-4 box-content">
                      <strong class="header">Inspection</strong>
                      <p class="short-desc">With Car Inspection, you will get a thorough assessment of your vehicle by our partner Certified Service expert.</p>
                        <a href="{{ URL::to(App::getLocale().'/p/inspection') }}" style="background: #1ca5ba;color:#fff !important;height:32px !important" class="btn submit-btn" ><i class="glyphicon glyphicon-plus"></i> Learn more..</a>
                    </div>
                    <div class="col-xs-4">
                      <ul class="listing">
                      <li><a href="{{ URL::to(App::getLocale().'/p/article-1') }}"><span class="glyphicon glyphicon-chevron-right"></span> Become a Verified seller</a></li>
                      <li><a href="{{ URL::to(App::getLocale().'/p/article-2') }}"><span class="glyphicon glyphicon-chevron-right"></span> How much is my car worth?</a></li>
                      <li><a href="{{ URL::to(App::getLocale().'/p/how-to-selling') }}"><span class="glyphicon glyphicon-chevron-right"></span> Selling guide</a></li>
                      <li><a href="{{ URL::to(App::getLocale().'/p/article-3') }}"><span class="glyphicon glyphicon-chevron-right"></span> Trustee checklist</a></li>
                      <li><a href="{{ URL::to(App::getLocale().'/p/inspection') }}"><span class="glyphicon glyphicon-chevron-right"></span> Inspection</a></li>
                    </ul>

                    </div>
                  </div>
                  <!-- Content -->
                </div>
              </div><!-- /.megamenu -->
            </li><!-- /.dropdown -->
            <li><a href="{{ URL::to(App::getLocale().'/wizard') }}">{{ $data['text']['wizard'] or 'Wizard' }}</a></li>
			<li><a href="{{ URL::to(App::getLocale().'/p/inspection') }}">{{ $data['text']['inspection'] or 'Inspection' }}</a></li>
            <li><a href="{{ URL::to(App::getLocale().'/p/insurance') }}">{{ $data['text']['insurance'] or 'Insurance' }}</a></li>
			<li><a href="{{ URL::to(App::getLocale().'/p/finance') }}">{{ $data['text']['finance'] or 'Finance' }}</a></li>
            <li><a href="{{ URL::to(App::getLocale().'/review') }}">{{ $data['text']['review'] or 'Review' }}</a></li>
          </ul>

          <ul class="nav navbar-nav navbar-right">
              @if(Session::has('member'))

              @include('site.desktop._partials.nav-user')

              @else
              <li><a href="{{ URL::to(App::getLocale().'/signup') }}">{{ $data['text']['register'] or 'register' }}</a></li>
              <li><a href="{{ URL::to(App::getLocale().'/signin') }}">{{ $data['text']['signin'] or 'signin' }}</a></li>
              @endif

          </ul>
        </div><!-- /.navbar-collapse -->
      </div><!-- /.container -->
    </div><!-- #/.nav-main -->
</div>
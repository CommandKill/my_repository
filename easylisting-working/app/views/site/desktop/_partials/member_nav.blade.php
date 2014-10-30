<section id="sidebar">
    <header><h1>Account</h1></header>
    <aside>
        <ul class="sidebar-navigation">
			
            <li @if(Request::is('*/my-garage*')) class="active" @endif>
            	<a href="{{ URL::to(App::getLocale().'/my-garage') }}"><i class="fa fa-home"></i><span>My garage</span></a></li>
				
            <li @if(Request::is('*/my-cars*')) class="active" @endif>
            	<a href="{{ URL::to(App::getLocale().'/my-cars') }}"><i class="fa fa-car"></i><span>My cars</span></a></li>				

            <li @if(Request::is('*/favourite-cars*')) class="active" @endif>
				<a href="{{ URL::to(App::getLocale().'/favourite-cars') }}"><i class="fa fa-heart"></i><span>Favourite cars</span></a></li>
			
			<li @if(Request::is('*/mysearch*')) class="active" @endif>
				<a href="{{ URL::to(App::getLocale().'/mysearch') }}"><i class="fa fa-search"></i><span>My Search</span></a></li>
				
            <li @if(Request::is('*/profile*')) class="active" @endif>
            	<a href="{{ URL::to(App::getLocale().'/profile') }}"><i class="fa fa-user"></i><span>Profile</span></a></li>

			<li @if(Request::is(App::getLocale().'/address')) class="active" @endif>
            	<a href="{{ URL::to(App::getLocale().'/address') }}"><i class="fa fa-envelope-o"></i><span>Address</span></a></li>

            <li @if(Request::is('*/password*')) class="active" @endif>
            	<a href="{{ URL::to(App::getLocale().'/password') }}"><i class="fa fa-lock"></i><span>Reset password</span></a></li>

        </ul>
    </aside>
</section>
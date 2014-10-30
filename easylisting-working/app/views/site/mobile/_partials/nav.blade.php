<div id="sidr">
	<p class="profile">
		<img class="img-circle" width="120" heigth="120" src="<?=asset('img/user-02.jpg')?>">
		<br/>
		<a href="#" class="profile-name">User name</a>
		<ul>
			<li><a href="#">Profile</a></li>
		    <li><a href="#">Save search</a></li>
		    <li><a href="#">Your post</a></li>
		    <li><a href="#">Log out</a></li>
		</ul>
	</p>
	<h2>{{ $data['text']['site'] or 'site' }}</h2>
	<ul>
	    <li><a href="#">{{ $data['text']['site'] or 'site' }}</a></li>
	    <li><a href="{{ URL::to(App::getLocale().'/listing') }}"> {{ $data['text']['buying'] or 'buying' }}</a></li>
	    <li>
	        <a href="#">{{ $data['text']['selling'] or 'selling' }}</a>
	<!--         <ul>
	            <li><a href="#">Child link 1</a></li>
	            <li><a href="#">Child link 2</a></li>
	        </ul> -->
	    </li>
	    <li><a href="{{ URL::to(App::getLocale().'/wizard') }}">{{ $data['text']['wizard'] or 'wizard' }}</a></li>
	    <li><a href="{{ URL::to(App::getLocale().'/quick-sale') }}">{{ $data['text']['quick_sale'] or 'quick_sale' }}</a></li>
	    <li><a href="{{ URL::to(App::getLocale().'/review') }}">{{ $data['text']['review'] or 'review' }}</a></li>
	</ul>
	<form>
	    <input type="text" placeholder="Search...">
	</form>
</div>
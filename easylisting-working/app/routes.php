<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/
define("DOMAIN", getenv('DOMAIN'));
define("PREFIX_MOBILE", getenv('PREFIX_MOBILE'));
define("MOBILE_DOMAIN", getenv('MOBILE_DOMAIN'));
define("PREFIX_DESKTOP_CLASS", getenv('PREFIX_DESKTOP_CLASS'));
define("PREFIX_MOBILE_CLASS", getenv('PREFIX_MOBILE_CLASS'));
define("IS_PRODUCTION", getenv('IS_PRODUCTION'));

$locale = Request::segment(1);

if (in_array($locale, Config::get('locales.available_locales'))) {
    \App::setLocale($locale);
} else {
    $locale = null;
}

Route::pattern('id', '[0-9]+');
// Route::pattern('str','[0-9A-Za-z]+');

//////////////////////////////////////////////////////////////////////
// Use for debug query
// Event::listen('illuminate.query', function( $query ) {
//     echo '<div class="alert alert-info"><h2>'.$query.'</h2></div>';
// });
//////////////////////////////////////////////////////////////////////
// require '../vendor/willdurand/Geocoder/autoload.php';

function xxx($c=''){
	return 'hello'.$c;
}

Route::get('pdf', function(){

    $pdf = App::make('dompdf');
    $pdf->loadHTML('<h1>Test</h1>');
    return $pdf->stream();

});

Route::get('bbcode', function(){

	// need try custom 
	// name, pattern, replace
	BBCode::setParser('mailurl', '/\[mailurl\](.*)\[\/mailurl\]/', '<a href="mailto:$1">$1</a>');

	$bbcode = BBCode::parse('[mailurl]http://google.com[/mailurl]');

	BBCode::setParser('latestcar', '/\[latestcar\](.*)\[\/latestcar\]/', xxx('$1'));

	$bbcode = BBCode::parse('[latestcar]xxx[/latestcar]');

	// Lets parse!
	// $bbcode = BBCode::parse('[b]bold[/b][i]italic[/i]');


	return $bbcode;
});

Route::get('/buzz', function()
{
	$browser = new Buzz\Browser();
        $response = $browser->get('http://128.199.200.28');

        echo $browser->getLastRequest()."\n";
        echo $response;

	return 'ok';
});

Route::get('/geo', function()
{

	$buzz    = new \Buzz\Browser(new \Buzz\Client\Curl());
	$adapter = new \Geocoder\HttpAdapter\BuzzHttpAdapter($buzz);

	$locale = 'th_TH';
	$region = 'Thailand';
	$useSsl = true;
	$bingApiKey = 'AtPJUlQwZfyY0GSiqR6oj8flC0bUyyuuxj66zSTF-1soEXRAlIA9GXvky7ofAWH4';

	$geocoder = new \Geocoder\Geocoder();
	// $geocoder->registerProviders(array(
	//     new \Geocoder\Provider\GoogleMapsProvider(
	//         $adapter, $locale, $region, $useSsl
	//     ),
	// ));
	$chain    = new \Geocoder\Provider\ChainProvider(array(
	    new \Geocoder\Provider\FreeGeoIpProvider($adapter),
	    new \Geocoder\Provider\HostIpProvider($adapter),
	    new \Geocoder\Provider\GoogleMapsProvider($adapter, $locale, $region, $useSsl),
	    new \Geocoder\Provider\BingMapsProvider($adapter, $bingApiKey),
	));
	$geocoder->registerProvider($chain);

	try {
    	//$geocode = $geocoder->geocode('10 rue Gambetta, Paris, France');
    	//$geocode = $geocoder->geocode('กรุงเทพ พระโขนง สุขุมวิท 101/1');
    	//$geocode = $geocoder->geocode('กรุงเทพ พญาไท สามเสนใน');
    	//$geocode = $geocoder->geocode('ชลบุรี  ศรีราชา');
    	// $geocode = $geocoder->geocode('ขอนแก่น เมืองเก่า');
    	//$geocode = $geocoder->geocode('88.188.221.14');
    	$geocode = $geocoder->reverse('13.6840190887451', '100.6155014038086');
    	echo '<pre>';
	    var_export($geocode);
	} catch (Exception $e) {
	    echo $e->getMessage();
	}



	return 'ok';
});

/*
|--------------------------------------------------------------------------
| Global page use for all
|--------------------------------------------------------------------------	
*/
Route::controller('/tags', 'TagsController');

if (IS_PRODUCTION) {
	/*
	|--------------------------------------------------------------------------
	| Front-end for Production (Must create sub domain call 'm.domain' for test case )
	| in mobile version access via: http://easy-listing.com/en
	| in desktop version access via: http://m.easy-listing.com/en
	|--------------------------------------------------------------------------	
	*/
	//desktop version
	Route::group(array('domain' => DOMAIN), function() use ($locale)
	{
		Route::group(array('prefix' => $locale), function() use ($locale)
		{
			if(Agent::isMobile() || Agent::isTablet()) {
				return Redirect::to('http://'.MOBILE_DOMAIN.'/'.$locale);
			}
			//echo 'device - '.Agent::device();
			// Route::get('/', function()
			// {
			// 	Notification::success('The page was saved.');
			// 	Debugbar::info(Notification::showAll());
			// 	return View::make('test.blank');
			// });
			// Route::get('/', array('as' => 'site.homepage', 'uses' => 'HomepageController@getIndex'))->before('cache.grab')->after('cache.set');
			
			Route::post('/newsletter-subscribe', 'NewsletterSubscriptionController@subscribe');


			Route::get('/', array('as' => 'site.homepage', 'uses' => PREFIX_DESKTOP_CLASS.'HomepageController@getIndex'));
			Route::controller('post', PREFIX_DESKTOP_CLASS.'PostController');
			Route::controller('p/{slug}', PREFIX_DESKTOP_CLASS.'PageController');

			Route::controller('b/{slug}', PREFIX_DESKTOP_CLASS.'BlogController');

			
		    Route::get('/signin', PREFIX_DESKTOP_CLASS.'MemberController@signin');
		    Route::post('/signin', PREFIX_DESKTOP_CLASS.'MemberController@takeSignin');

		    Route::get('/signin-with-facebook', PREFIX_DESKTOP_CLASS.'MemberController@signinWithFacebook');
		    Route::get('/signup-with-facebook', PREFIX_DESKTOP_CLASS.'MemberController@signupWithFacebook');
		    Route::get('/link-with-facebook', PREFIX_DESKTOP_CLASS.'MemberController@linkWithFacebook');

		    Route::get('/resent-verify-email', PREFIX_DESKTOP_CLASS.'MemberController@resentVerifyEmail');

		    Route::get('/signup', PREFIX_DESKTOP_CLASS.'MemberController@signup');
		    Route::post('/signup', PREFIX_DESKTOP_CLASS.'MemberController@takeSignup');

		    Route::get('/forgotpwd', PREFIX_DESKTOP_CLASS.'MemberController@forgotpwd');
		    Route::post('/forgotpwd', PREFIX_DESKTOP_CLASS.'MemberController@takeForgotpwd');
		    Route::get('/resetpwd-verify', PREFIX_DESKTOP_CLASS.'MemberController@resetPasswordVerify');

		    Route::get('/signout', PREFIX_DESKTOP_CLASS.'MemberController@signout');
		    
		    Route::get('/email-verify', PREFIX_DESKTOP_CLASS.'MemberController@emailVerify');

		    Route::get('/profile', PREFIX_DESKTOP_CLASS.'MemberController@profile');
		    Route::post('/profile', PREFIX_DESKTOP_CLASS.'MemberController@takeProfile');

		    Route::post('/file-thumbnail', PREFIX_DESKTOP_CLASS.'MemberController@fileThumbnail');

		    Route::get('/address', PREFIX_DESKTOP_CLASS.'MemberController@address');
		    Route::post('/address', PREFIX_DESKTOP_CLASS.'MemberController@takeAddress');
		    Route::get('/unlink-facebook', PREFIX_DESKTOP_CLASS.'MemberController@unlinkFacebook');
		    Route::get('/password', PREFIX_DESKTOP_CLASS.'MemberController@resetPassword');
		    Route::post('/password', PREFIX_DESKTOP_CLASS.'MemberController@password');
			Route::get('/mysearch', PREFIX_DESKTOP_CLASS.'MemberController@mysearch');
			Route::get('/remove-search/{id}', PREFIX_DESKTOP_CLASS.'MemberController@removesearch');
			
		    Route::controller('my-garage/car/{id}', 'DesktopManageCarController');
		    Route::controller('my-garage/car', 'DesktopManageCarController');
		    Route::controller('my-garage', 'DesktopMyGarageController');
			Route::get('my-cars', 'DesktopMyGarageController@myCars');

		    // Route::controller('faq', 'FaqController');
		    Route::controller('/post', 'PostController');

		    Route::controller('favourite-cars', PREFIX_DESKTOP_CLASS.'MyCarFavoriteController');
			
		    Route::get('/compare/{str?}', PREFIX_DESKTOP_CLASS.'CompareController@getIndex');
		    Route::get('/listing', 'DesktopListingController@getIndex');
		    Route::post('/listing/save-report', 'DesktopListingController@saveReport');
			Route::post('/save-search', 'DesktopListingController@saveSearch');
		    Route::get('/car-detail/{id}', PREFIX_DESKTOP_CLASS.'PostDetailController@index');
		    Route::get('/car-favorite/{id}', PREFIX_DESKTOP_CLASS.'PostDetailController@saveFavoriteSatatus');
			Route::post('/car-share-email', PREFIX_DESKTOP_CLASS.'PostDetailController@shareEmail');
		    Route::get('/promote/{id}', PREFIX_DESKTOP_CLASS.'PromoteController@getIndex');
		    Route::get('/p/{slug}', PREFIX_DESKTOP_CLASS.'PageController@getIndex');
		    Route::get('/b/{slug}', PREFIX_DESKTOP_CLASS.'BlogController@getIndex');
		    // Route::controller('/wizard', PREFIX_DESKTOP_CLASS.'WizardController');

		    Route::get('/quick-sale', 'DesktopQuickSaleController@getIndex');
			Route::get('/insurance', 'DesktopQuickSaleController@getInsurance');
			Route::get('/finance', 'DesktopQuickSaleController@getFinance');
		    Route::get('/review', 'DesktopReviewController@getIndex');
		});
	});
	// mobile version
	Route::group(array('domain' => MOBILE_DOMAIN), function() use ($locale)
	{
		Route::group(array('prefix' => $locale), function() use ($locale)
		{
			Route::get('/', array('as' => 'site.homepage', 'uses' => PREFIX_MOBILE_CLASS.'HomepageController@getIndex'));
			Route::controller('post', PREFIX_MOBILE_CLASS.'PostController');
			Route::controller('p/{slug}', PREFIX_MOBILE_CLASS.'PageController');
		});
	});
} else {
	/*
	|--------------------------------------------------------------------------
	| Front-end for Development (access via ip)
	| in mobile version access via: http://127.0.0.1/m/en
	| in desktop version access via: http://127.0.0.1/en
	|--------------------------------------------------------------------------	
	*/
	// desktop version
	Route::group(array('prefix' => $locale), function()
	{
			Route::post('/newsletter-subscribe', 'NewsletterSubscriptionController@subscribe');


			Route::get('/', array('as' => 'site.homepage', 'uses' => PREFIX_DESKTOP_CLASS.'HomepageController@getIndex'));
			Route::controller('post', PREFIX_DESKTOP_CLASS.'PostController');
			Route::controller('p/{slug}', PREFIX_DESKTOP_CLASS.'PageController');

			Route::controller('b/{slug}', PREFIX_DESKTOP_CLASS.'BlogController');

			
		    Route::get('/signin', PREFIX_DESKTOP_CLASS.'MemberController@signin');
		    Route::post('/signin', PREFIX_DESKTOP_CLASS.'MemberController@takeSignin');

		    Route::get('/signin-with-facebook', PREFIX_DESKTOP_CLASS.'MemberController@signinWithFacebook');
		    Route::get('/signup-with-facebook', PREFIX_DESKTOP_CLASS.'MemberController@signupWithFacebook');
		    Route::get('/link-with-facebook', PREFIX_DESKTOP_CLASS.'MemberController@linkWithFacebook');

		    Route::get('/resent-verify-email', PREFIX_DESKTOP_CLASS.'MemberController@resentVerifyEmail');

		    Route::get('/signup', PREFIX_DESKTOP_CLASS.'MemberController@signup');
		    Route::post('/signup', PREFIX_DESKTOP_CLASS.'MemberController@takeSignup');

		    Route::get('/forgotpwd', PREFIX_DESKTOP_CLASS.'MemberController@forgotpwd');
		    Route::post('/forgotpwd', PREFIX_DESKTOP_CLASS.'MemberController@takeForgotpwd');
		    Route::get('/resetpwd-verify', PREFIX_DESKTOP_CLASS.'MemberController@resetPasswordVerify');

		    Route::get('/signout', PREFIX_DESKTOP_CLASS.'MemberController@signout');
		    
		    Route::get('/email-verify', PREFIX_DESKTOP_CLASS.'MemberController@emailVerify');

		    Route::get('/profile', PREFIX_DESKTOP_CLASS.'MemberController@profile');
		    Route::post('/profile', PREFIX_DESKTOP_CLASS.'MemberController@takeProfile');

		    Route::post('/file-thumbnail', PREFIX_DESKTOP_CLASS.'MemberController@fileThumbnail');

		    Route::get('/address', PREFIX_DESKTOP_CLASS.'MemberController@address');
		    Route::post('/address', PREFIX_DESKTOP_CLASS.'MemberController@takeAddress');
		    Route::get('/unlink-facebook', PREFIX_DESKTOP_CLASS.'MemberController@unlinkFacebook');
		    Route::get('/password', PREFIX_DESKTOP_CLASS.'MemberController@resetPassword');
		    Route::post('/password', PREFIX_DESKTOP_CLASS.'MemberController@password');
			Route::get('/mysearch', PREFIX_DESKTOP_CLASS.'MemberController@mysearch');
			Route::get('/remove-search/{id}', PREFIX_DESKTOP_CLASS.'MemberController@removesearch');
			
		    Route::controller('my-garage/car/{id}', 'DesktopManageCarController');
		    Route::controller('my-garage/car', 'DesktopManageCarController');
		    Route::controller('my-garage', 'DesktopMyGarageController');
			Route::get('my-cars', 'DesktopMyGarageController@myCars');

		    // Route::controller('faq', 'FaqController');
		    Route::controller('/post', 'PostController');

		    Route::controller('favourite-cars', PREFIX_DESKTOP_CLASS.'MyCarFavoriteController');
			
		    Route::get('/compare/{str?}', PREFIX_DESKTOP_CLASS.'CompareController@getIndex');
		    Route::get('/listing', 'DesktopListingController@getIndex');
		    Route::post('/listing/save-report', 'DesktopListingController@saveReport');
			Route::post('/save-search', 'DesktopListingController@saveSearch');
		    Route::get('/car-detail/{id}', PREFIX_DESKTOP_CLASS.'PostDetailController@index');
		    Route::get('/car-favorite/{id}', PREFIX_DESKTOP_CLASS.'PostDetailController@saveFavoriteSatatus');
			Route::post('/car-share-email', PREFIX_DESKTOP_CLASS.'PostDetailController@shareEmail');
		    Route::get('/promote/{id}', PREFIX_DESKTOP_CLASS.'PromoteController@getIndex');
		    Route::get('/p/{slug}', PREFIX_DESKTOP_CLASS.'PageController@getIndex');
		    Route::get('/b/{slug}', PREFIX_DESKTOP_CLASS.'BlogController@getIndex');
		    // Route::controller('/wizard', PREFIX_DESKTOP_CLASS.'WizardController');

		    Route::get('/quick-sale', 'DesktopQuickSaleController@getIndex');
			Route::get('/insurance', 'DesktopQuickSaleController@getInsurance');
			Route::get('/finance', 'DesktopQuickSaleController@getFinance');
		    Route::get('/review', 'DesktopReviewController@getIndex');

		    /*
		    |---------------------------------------------------------
		    |	Seller Verified
		    |---------------------------------------------------------
		    */
		    Route::get('/verified/delete-id', 'SellerVerifiedController@deleteID');
		    Route::post('/verified/add-id', 'SellerVerifiedController@addID');
		    Route::get('/verified/check-id', 'SellerVerifiedController@checkID');

		    Route::get('/verified/delete-car-docs', 'SellerVerifiedController@deleteCarDocs');
		    Route::post('/verified/add-car-docs', 'SellerVerifiedController@addCarDocs');
		    Route::get('/verified/check-car', 'SellerVerifiedController@checkCar');


	});
	// mobile version
	Route::group(array('prefix' => $locale.'/'.PREFIX_MOBILE), function()
	{
		Route::get('/', array('as' => 'site.homepage', 'uses' => PREFIX_MOBILE_CLASS.'HomepageController@getIndex'));
		Route::controller('post', PREFIX_MOBILE_CLASS.'PostController');
		Route::controller('p/{slug}', PREFIX_MOBILE_CLASS.'PageController');
	});
}

/*
|--------------------------------------------------------------------------
| Back-end
|--------------------------------------------------------------------------	
*/
Route::controller('admin/auth', 'AdmAuthController');
Route::group(array('prefix' => 'admin', 'before' => 'auth.admin'), function()
{
    Route::get('/', array('as' => 'admin.dashboard', 'uses' => 'AdminHomepageController@getIndex'));
    Route::controller('post', 'AdminPostController');
    Route::controller('seller-verified', 'AdminSellerVerifiedController');
    Route::controller('car', 'AdminCarController');
    Route::controller('car-vehicle', 'AdminCarVehicleController');
    Route::controller('car-parts', 'AdminCarPartController');
	Route::controller('ga', 'GoogleAnalyticController');
	Route::controller('system-language', 'SystemLanguageController');
	Route::controller('package', 'PackageController');
	Route::controller('questionaire', 'QuestionaireController');
	Route::controller('setting', 'SettingController');
	Route::controller('banner', 'BannerController');
	Route::controller('banner-page', 'BannerPageController');
	Route::controller('banner-position', 'BannerPositionController');
	Route::controller('banner-file', 'BannerFileController');
	Route::controller('email-template', 'EmailTemplateController');
	Route::controller('index-tool', 'IndexToolController');
	Route::controller('page', 'AdminPageController');
	Route::controller('content-blog', 'AdminBlogController');
	Route::controller('content-review', 'AdminReviewController');
	Route::controller('content-promote', 'AdminPromoteController');
	Route::controller('setting', 'SettingController');
	// Route::resource('setting', 'SettingController', array('only' => array('index', 'store')));

	Route::controller('api-doc', 'APIDocController');
	Route::controller('subscriber', 'SubscriberController');

    Route::controller('job', 'SaveSearchJobController');

    Route::controller('stats', 'StatsController');

	// Langauges
	Route::get('language', array('as' => 'admin.language.index', 'uses' => 'LanguageController@index'));
	Route::get('language/{lang}', array('as' => 'admin.language.index', 'uses' => 'LanguageController@index'));
	Route::get('language/{lang}/{module}', array('as' => 'admin.language.index', 'uses' => 'LanguageController@index'));
    Route::post('language/save', array('as' => 'admin.language.save', 'uses' => 'LanguageController@save'));
    Route::post('language/{lang}/save', array('as' => 'admin.language.save', 'uses' => 'LanguageController@save'));
    Route::post('language/{lang}/{module}/save', array('as' => 'admin.language.save', 'uses' => 'LanguageController@save'));

    Route::resource('users', 'UserController');
    Route::get('users/{id}/suspend', array('as' => 'admin.user.suspend', 'uses' => 'UserController@suspend'));
    Route::get('users/{id}/unsuspend', array('as' => 'admin.user.unsuspend', 'uses' => 'UserController@unsuspend'));
    Route::get('users/{id}/ban', array('as' => 'admin.user.ban', 'uses' => 'UserController@ban'));
    Route::get('users/{id}/unban', array('as' => 'admin.user.unban', 'uses' => 'UserController@unban'));
    Route::post('users/file-thumbnail', 'UserController@fileThumbnail');
    Route::controller('usergroup', 'UserGroupController');
	
    Route::controller('member', 'AdminMemberController');

	Route::controller('cropper-editor', 'CropperEditorController');

	// flusg cache
	Route::get('/flush', function()
	{
		Cache::flush();
		// return '*flushed*';
		return Redirect::to('admin');
	});

	// this uri for deploy to **my server**
	Route::get('/deploy', function()
	{
		// FIXME: change this follow to command
		SSH::run(array(
			'cd /var/www/easy-listing/',
		    'git pull origin master',
		    'composer update',
		    'cd /var/www/easy-listing-ssl/',
		    'git pull origin master',
		    'composer update'
		), function($line)
		{
		    echo $line.PHP_EOL."<br/>";
		});

		return '*deployed*';
	});

	// Test send email for newsletter
	Route::get('/newsletter', function()
	{
		// test with email id 7
		$email_template = EmailTemplate::where('id', 7)->with('template')->first();

		// replace '/js/plugins/elfinder/php/../../../..' to 'http://domina.com/'
		$subject = $email_template->template[0]['subject'];
		//Request::getHttpHost()
		$templates = str_replace('/js/plugins/elfinder/php/../../../..', 'http://128.199.140.65', $email_template->template[0]['template']);

		// replace [fullname] to variable
		$templates = str_replace('[fullname]','Test user', $templates);

		Mail::send('email.blank', array('email_template'=>$templates), function($message) use ($subject)
		{
		    $message->to("nor@ywsgroup.com")
			->subject($subject)
			->from(getenv('ADMIN_EMAIL'), getenv('ADMIN_NAME'));
		});
		return Redirect::to('admin/');
	});

	// print out all route
	Route::get('routes', function() {
		$routeCollection = Route::getRoutes();

		echo "<table style='width:100%'>";
		    echo "<tr>";
		        echo "<td width='10%'><h4>HTTP Method</h4></td>";
		        echo "<td width='10%'><h4>Route</h4></td>";
		        echo "<td width='80%'><h4>Corresponding Action</h4></td>";
		    echo "</tr>";
		    foreach ($routeCollection as $value) {
		        echo "<tr>";
		            echo "<td>" . $value->getMethods()[0] . "</td>";
		            echo "<td>" . $value->getPath() . "</td>";
		            echo "<td>" . $value->getActionName() . "</td>";
		        echo "</tr>";
		    }
		echo "</table>";
	});

		
});

/*
|--------------------------------------------------------------------------
| API Version1 
|--------------------------------------------------------------------------	
| Route group for API versioning
*/
// Route::group(array('prefix' => 'api/v1', 'before' => 'auth.basic'), function()
Route::group(array('prefix' => 'api/v1'), function()
{
    // Route::resource('url', 'UrlController',
    //             array('except' => array('create', 'store', 'update', 'destroy')));

    Route::controller('car', 'ApiCarController');
    Route::controller('address', 'ApiAddressController');
});

/*
|--------------------------------------------------------------------------
| API Version2 
|--------------------------------------------------------------------------	
| Route group for API versioning
*/
Route::group(array('prefix' => 'api/v2'), function()
{
    Route::controller('car', 'ApiCarElasticSearchController');
});

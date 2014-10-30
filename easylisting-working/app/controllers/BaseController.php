<?php

class BaseController extends Controller 
{
	var $current_lang = '';
	var $status = array();
	Var $language = array();
	var $path = array();
	var $expire_cache = 0;

	public function __construct()
	{
		Debugbar::info('read in BaseController');

		// dd(Cache::getMemory());

		$this->expire_cache = Carbon::now()->addMinutes(1440 * 1);// default 1 day

		//$action = Route::currentRouteAction();

		// App::setLocale('th'); //<- set default lang
		$this->current_lang = App::getLocale(); // 'en' or 'th'

		// Status in systen
		$this->status = Config::get('site.status');
		// $this->status = array_flip($this->status);

		// all path about assets
		$this->member_root_path = Config::get('site.member_root_path');
		$this->member_root_url = Config::get('site.member_root_url');

		// Langauge supported in system
		$key_languages = 'languages';
		if (Cache::has($key_languages)){
			$this->languages = Cache::get($key_languages);
			Debugbar::info($key_languages.' from cache');
		} else {
			$languages = Language::orderBy('id', 'DESC')->get()->toArray();
	        if (is_array($languages) && !empty($languages))
	        foreach ($languages as $key => $value) {
	        	$this->languages[$value['short_code']] = $value;
	        	//Cache::put($key_languages, $this->languages, $this->expire_cache);
	        	Cache::forever($key_languages, $this->languages);
	        }
	        Debugbar::info($key_languages.' from db');
		}

		//App::setLocale('th'); // test locales
		// Debugbar::info($object);
		// Debugbar::error("Error!");
		// Debugbar::warning('Watch out..');
		// Debugbar::addMessage('Another message', 'mylabel');
	}

	public function makeDirectory($path='') {
		if($path == '')return;
		File::makeDirectory($path, 0775, true, true);
	}

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}

	// public function resizeImage($src, $dest, $size='80x50', $inc_text=false)
 //    {
	//     list($dest_width, $dest_height) = explode('x', $size);


	// 	// open an image file
	// 	$ori_img = Image::make($src);

	// 	$ori_img->resize(null, $dest_height,function ($constraint) {
	//             $constraint->aspectRatio();
	//             $constraint->upsize();
	//         });

	// 	// fill image with color
	// 	// $img->fill('#ffffff');
	// 	$img = Image::canvas($dest_width, $dest_height, '#ffffff');
	// 	$img->insert($ori_img);
	// 	// $img->insert($ori_img, 'center');


	// 	// crop image
	// 	$start_x = ($img->width() - $dest_width) / 2;
	// 	//$start_x = 0;
	// 	$img->crop($dest_width, $dest_height, (int)$start_x, 0);

	// 	// insert a watermark
	// 	//$img->insert('public/watermark.png');

	// 	// write text at position
	// 	//$img->text('easylisting.com', 10, $dest_height - 10);
	// 	// use callback to define details
	// 	if($inc_text)
	// 	$img->text('easylisting.com', 10, $dest_height - 10, function($font) {
	// 	    $font->file(public_path().'/fonts/boon/otf/boon-400.otf');
	// 	    //$font->size(24);
	// 	    //$font->color('#000000');
	// 	    $font->color(array(255, 255, 255, 0.5));// draw transparent text
	// 	    //$font->align('center');
	// 	    //$font->valign('middle');
	// 	    //$font->angle(45);
	// 	});
		

	// 	// save image in desired format
	// 	$img->save($dest, 80);
 //    }

	public function resizeImage($src, $dest, $size='80x50', $inc_text=false)
    {
	    list($dest_width, $dest_height) = explode('x', $size);


		// open an image file
		$img = Image::make($src);

		$img->resize($dest_width, null,function ($constraint) {
	            $constraint->aspectRatio();
	            $constraint->upsize();
	        });
		$start_y = ($img->height() - $dest_height) / 2;
		$start_y = (int)$start_y;
	    $img->crop($dest_width, $dest_height, 0, $start_y);	

		// save image in desired format
		$img->save($dest, 80);
    }

    public function geoFromAddress($address){
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
            $geocode = $geocoder->geocode($address);
            //$geocode = $geocoder->geocode('88.188.221.14');
            //$geocode = $geocoder->reverse('13.6840190887451', '100.6155014038086');
            return $geocode;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function geoFromLatLon($lat, $lon){
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
            $geocode = $geocoder->reverse($lat, $lon);
            return $geocode;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function geoFromIPAddress($ip){
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
            $geocode = $geocoder->geocode($ip);
//            $geocode = $geocoder->reverse($lat, $lon);
            return $geocode;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}

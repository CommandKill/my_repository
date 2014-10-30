<div class="secondary-navigation">
    <div class="container">
        <div class="contact">
            <a href="#">
                <span class="extra-icon icon-phone"></span> {{ $data['setting']['site_hotline'] or 'site_hotline' }}
            </a>
            <a href="mailto:{{ $data['setting']['site_support_email'] or 'site_support_email' }}">
                <span class="extra-icon icon-email"></span> {{ $data['setting']['site_support_email'] or 'site_support_email' }}
            </a>
        </div>
        <div class="extra-area">
            <div class="social-area pull-right">
              <a href="{{ $data['setting']['site_facebook_page'] or 'site_facebook_page' }}"><i class="fa fa-facebook"></i></a>
              <a href="{{ $data['setting']['site_twitter_page'] or 'site_twitter_page' }}"><i class="fa fa-twitter"></i></a>
<!--               <a href="{{ $data['setting']['site_youtube_channel'] or 'site_youtube_channel' }}"><i class="fa fa-youtube-play"></i></a> -->
            </div>
        </div>
        <div class="language-switcher">

            <span>
                @if(App::getLocale() == 'th') 
                {{ $data['text']['thai_lang'] or 'thai_lang' }} 
                @else 
                <a href="{{ L18n::currentUrl('th') }}">{{ $data['text']['thai_lang'] or 'thai_lang' }}</a> 
                @endif
            </span> |
            <span>
                @if(App::getLocale() == 'en') 
                {{ $data['text']['eng_lang'] or 'eng_lang' }} 
                @else 
                <a href="{{ L18n::currentUrl('en') }}">{{ $data['text']['eng_lang'] or 'eng_lang' }}</a>
                @endif
            </span>
    
        </div>
    </div>
</div>
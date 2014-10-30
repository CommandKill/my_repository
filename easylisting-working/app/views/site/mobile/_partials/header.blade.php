<div class="navigation">
  <div class="secondary-navigation">
    <div class="container">
        <div class="contact">
            <a href="#">
                <span class="extra-icon icon-phone"></span> {{ $data['setting']['site_hotline'] or 'site_hotline' }}
            </a>
<!--             <a href="mailto:{{ $data['setting']['site_support_email'] or 'site_support_email' }}">
                <span class="extra-icon icon-email"></span> {{ $data['setting']['site_support_email'] or 'site_support_email' }}
            </a> -->
        </div>
        <div class="extra-area">
            <div class="social-area pull-right">
              <a href="{{ $data['setting']['site_facebook_page'] or 'site_facebook_page' }}"><i class="fa fa-facebook"></i></a>
              <a href="{{ $data['setting']['site_twitter_page'] or 'site_twitter_page' }}"><i class="fa fa-twitter"></i></a>
              <a href="{{ $data['setting']['site_youtube_channel'] or 'site_youtube_channel' }}"><i class="fa fa-youtube-play"></i></a>
            </div>
        </div>
    </div>
  </div> 
  <nav class="navbar navbar-default navbar-static-top" id="nav-main">
    <div class="container">

      <div class="navbar-header">
        <a class="navbar-brand" href="#">Brand</a>
      </div>

      <div class="">
        <button type="button" id="slider-menu-btn" class="navbar-toggle">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <ul class="nav navbar-nav navbar-right">
          <li class="{{ App::getLocale() == 'th' ? 'active' : '' }}"><a href="{{ L18n::currentUrl('th') }}">{{ $data['text']['thai_lang'] or 'thai_lang' }}</a> </li>
          <li class="{{ App::getLocale() == 'en' ? 'active' : '' }}"><a href="{{ L18n::currentUrl('en') }}">{{ $data['text']['eng_lang'] or 'eng_lang' }}</a></li>
        </ul>
      </div>
    </div>
  </nav>
</div>
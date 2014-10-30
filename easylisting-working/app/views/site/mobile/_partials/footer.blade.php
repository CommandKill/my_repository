<footer id="page-footer">
    <div class="inner">
        <section id="footer-main">
            <div class="container">
                <div class="row">
                    <article class="col-xs-12">
                        <h3>{{ $data['text']['aboutus'] or 'aboutus' }}</h3>
                        <p>{{ $data['text']['company_about'] or 'company_about' }}</p>
                        <hr>
                        <a href="{{ URL::to(App::getLocale().'/p') }}/about-us" class="link-arrow">{{ $data['text']['read_more'] or 'read_more' }}</a>
                    </article>
                    <article class="col-xs-12">
                        <h3>{{ $data['text']['contact'] or 'contact' }}</h3>
                        <address>{{ $data['text']['company_address'] or 'company_address' }}</address>
                        {{ $data['setting']['site_hotline'] or 'site_hotline' }}<br>
                        <a href="mailto:{{ $data['setting']['site_support_email'] or 'site_support_email' }}">
                            {{ $data['setting']['site_support_email'] or 'site_support_email' }}</a>
                    </article>
                    <article class="col-xs-12">
                        <h3>{{ $data['text']['useful_links'] or 'useful_links' }}</h3>
                        <ul class="list-unstyled list-links">
                            <li><a href="{{ URL::to(App::getLocale().'/listing') }}">All Cars</a></li>
                            <li><a href="{{ URL::to(App::getLocale().'/p/privacy-policy') }}">Privacy Policy</a></li>
                            <li><a href="{{ URL::to(App::getLocale().'/signin') }}">Login and Register Account</a></li>
                            <li><a href="{{ URL::to(App::getLocale().'/faq') }}">FAQ</a></li>
                            <li><a href="{{ URL::to(App::getLocale().'/p/terms-and-conditions') }}">Terms and Conditions</a></li>
                        </ul>
                    </article>
                    <article class="col-xs-12">
                        <h3>{{ $data['text']['finduson'] or 'finduson' }}</h3>
                        <ul class="list-unstyled information-box">
                            <li>
                                <a href="{{ $data['setting']['config_facebook_page'] or 'config_facebook_page' }}">
                                    <span class="social-icon icon-facebook">facebook</span> 
                                    {{ $data['text']['likeus_on_facebook'] or 'likeus_on_facebook' }}
                                </a>
                            </li>
                            <li>
                                <a href="{{ $data['setting']['config_twitter_page'] or 'config_twitter_page' }}">
                                    <span class="social-icon icon-twitter">twitter</span> 
                                    {{ $data['text']['followus_on_twitter'] or 'followus_on_twitter' }}
                                </a>
                            </li>
                            <li>
                                <a href="{{ $data['setting']['config_youtube_channel'] or 'config_youtube_channel' }}">
                                    <span class="social-icon icon-youtube">youtube</span> 
                                    {{ $data['text']['subscribe_on_youtube'] or 'subscribe_on_youtube' }}
                                </a>
                            </li>
                            <li>
                                <a href="mailto:{{ $data['setting']['site_support_email'] or 'site_support_email' }}">
                                    <span class="social-icon icon-email">email</span> 
                                    {{ $data['text']['subscribe_newsletter'] or 'subscribe_newsletter' }}
                                </a>
                            </li>
                        </ul>
                    </article>
                </div><!-- /.row -->
            </div><!-- /.container -->
        </section>
        <section id="footer-copyright">
            <div class="container">
                <span>{{ $data['setting']['site_copyright'] or 'site_copyright' }}</span>
            </div>
        </section>
    </div>
</footer>
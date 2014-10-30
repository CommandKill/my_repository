@extends('site.desktop._layouts.index')

@section('head')
<style>
.new-car{
min-height: 220px;
}
</style>
@stop
@section('content')
<div class="row">
<div class="col-xs-12">
<div class="container page">
    <div class="row detail-page">
        <div class="col-xs-9">
            <header class="car-title">
                <h1 style="color:#1B5184;">{{ $data['page_title'] }}</h1>
            </header>
            <div class="row">
                <div class="col-xs-12">
                    <section id="results">

                                            <section id="Cars">
                                            <div class="row">
                                                <div class="col-md-4 col-sm-4">
                                                    <div class="car new-car-item">
                                                        <a href="car-detail/4">
                                                            <div class="car-image">
                                                                <img alt="" src="http://128.199.200.28/img/cars/sample1.png">
                                                            </div>
                                                            <div class="overlay">
                                                                <div class="info">
                                                                    <h3>ขายด่วน ร้อนเงิน</h3>
                                                                    <figure>VOLKSWAGEN - CARAVELLE - TDI 2.0 AT</figure>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div><!-- /.car -->
                                                </div><!-- /.col-md-3 -->
                                                <div class="col-md-4 col-sm-4">
                                                    <div class="car new-car-item">
                                                        <a href="car-detail/4">
                                                            <div class="car-image">
                                                                <img alt="" src="http://128.199.200.28/img/cars/sample2.png">
                                                            </div>
                                                            <div class="overlay">
                                                                <div class="info">
                                                                    <h3>ขายด่วน ร้อนเงิน</h3>
                                                                    <figure>VOLKSWAGEN - CARAVELLE - TDI 2.0 AT</figure>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div><!-- /.car -->
                                                </div><!-- /.col-md-3 -->
                                                <div class="col-md-4 col-sm-4">
                                                    <div class="car new-car-item">
                                                        <a href="car-detail/4">
                                                            <div class="car-image">
                                                                <img alt="" src="http://128.199.200.28/img/cars/sample3.png">
                                                            </div>
                                                            <div class="overlay">
                                                                <div class="info">
                                                                    <h3>ขายด่วน ร้อนเงิน</h3>
                                                                    <figure>VOLKSWAGEN - CARAVELLE - TDI 2.0 AT</figure>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div><!-- /.car -->
                                                </div><!-- /.col-md-3 -->
                                            </div><!-- /.row-->
                                            <div class="row">
                                                <div class="col-md-4 col-sm-4">
                                                    <div class="car new-car-item">
                                                        <a href="car-detail/4">
                                                            <div class="car-image">
                                                                <img alt="" src="http://128.199.200.28/img/cars/sample7.png">
                                                            </div>
                                                            <div class="overlay">
                                                                <div class="info">
                                                                    <h3>ขายด่วน ร้อนเงิน</h3>
                                                                    <figure>VOLKSWAGEN - CARAVELLE - TDI 2.0 AT</figure>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div><!-- /.car -->
                                                </div><!-- /.col-md-3 -->
                                                <div class="col-md-4 col-sm-4">
                                                    <div class="car new-car-item">
                                                        <a href="car-detail/4">
                                                            <div class="car-image">
                                                                <img alt="" src="http://128.199.200.28/img/cars/sample8.png">
                                                            </div>
                                                            <div class="overlay">
                                                                <div class="info">
                                                                    <h3>ขายด่วน ร้อนเงิน</h3>
                                                                    <figure>VOLKSWAGEN - CARAVELLE - TDI 2.0 AT</figure>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div><!-- /.car -->
                                                </div><!-- /.col-md-3 -->
                                                <div class="col-md-4 col-sm-4">
                                                    <div class="car new-car-item">
                                                        <a href="car-detail/4">
                                                            <div class="car-image">
                                                                <img alt="" src="http://128.199.200.28/img/cars/sample9.png">
                                                            </div>
                                                            <div class="overlay">
                                                                <div class="info">
                                                                    <h3>ขายด่วน ร้อนเงิน</h3>
                                                                    <figure>VOLKSWAGEN - CARAVELLE - TDI 2.0 AT</figure>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div><!-- /.car -->
                                                </div><!-- /.col-md-3 -->
                                            </div><!-- /.row-->
                                            <section id="advertising">
                                                <a href="submit.html">
                                                    <div class="banner">
                                                        <div class="wrapper">
                                                            <span class="title">Do you want your car to be listed here?</span>
                                                            <span class="submit">Submit it now! <i class="fa fa-plus-square"></i></span>
                                                        </div>
                                                    </div><!-- /.banner-->
                                                </a>
                                            </section><!-- /#adveritsing-->

                                            <section id="cars" class="display-lines">
                                                <div class="car new-car">
                                                    <div class="car-image">
                                                        <a href="car-detail/5">
                                                            <img alt="" src="http://128.199.200.28/img/cars/sample9.png">
                                                        </a>
                                                    </div>
                                                    <div class="info">
                                                        <header>
                                                            <a href="car-detail/5"><h3>BMW X1 E84 sDrive20d 2.0 AT ปี 2012</h3></a>
                                                        </header>
                                                        <p>ดีเซลตัว TOP มี BSI 2016. เนวิเกเตอร์ DVD สั่งงานด้วยเสียง สีเทา, เกียร์อัตโนมัติ, วิทยุ, ล้อแมกซ์, CD, ABS, AIRBAG, พ.พาวเวอร์...
                                                                                                                    </p>
                                                                                                                    <br/>
                                                        <a href="car-detail/5" class="link-arrow">Read More</a>
                                                    </div>
                                                </div><!-- /.car -->
                                                <div class="car new-car">
                                                    <div class="car-image">
                                                        <a href="car-detail/5">
                                                            <img alt="" src="http://128.199.200.28/img/cars/sample4.png">
                                                        </a>
                                                    </div>
                                                   <div class="info">
                                                        <header>
                                                            <a href="car-detail/5"><h3>BMW X1 E84 sDrive20d 2.0 AT ปี 2012</h3></a>
                                                        </header>
                                                        <p>ดีเซลตัว TOP มี BSI 2016. เนวิเกเตอร์ DVD สั่งงานด้วยเสียง สีเทา, เกียร์อัตโนมัติ, วิทยุ, ล้อแมกซ์, CD, ABS, AIRBAG, พ.พาวเวอร์...
                                                                                                                    </p>
                                                                                                                    <br/>
                                                        <a href="car-detail/5" class="link-arrow">Read More</a>
                                                    </div>
                                                </div><!-- /.car -->
                                                <div class="car new-car no-border">
                                                    <div class="car-image">
                                                        <a href="car-detail/5">
                                                            <img alt="" src="http://128.199.200.28/img/cars/sample2.png">
                                                        </a>
                                                    </div>
                                                    <div class="info">
                                                        <header>
                                                            <a href="car-detail/5"><h3>BMW X1 E84 sDrive20d 2.0 AT ปี 2012</h3></a>
                                                        </header>
                                                        <p>ดีเซลตัว TOP มี BSI 2016. เนวิเกเตอร์ DVD สั่งงานด้วยเสียง สีเทา, เกียร์อัตโนมัติ, วิทยุ, ล้อแมกซ์, CD, ABS, AIRBAG, พ.พาวเวอร์...
                                                                                                                    </p><br/>
                                                        <a href="car-detail/5" class="link-arrow">Read More</a>
                                                    </div>
                                                </div><!-- /.car -->

                                                <section id="advertising">
                                                    <a href="submit.html">
                                                        <div class="banner">
                                                            <div class="wrapper">
                                                                <span class="title">Do you want your car to be listed here?</span>
                                                                <span class="submit">Submit it now! <i class="fa fa-plus-square"></i></span>
                                                            </div>
                                                        </div><!-- /.banner-->
                                                    </a>
                                                </section><!-- /#adveritsing-->

                                                <div class="car new-car">
                                                    <div class="car-image">
                                                        <a href="car-detail/5">
                                                            <img alt="" src="http://128.199.200.28/img/cars/sample5.png">
                                                        </a>
                                                    </div>
                                                    <div class="info">
                                                        <header>
                                                            <a href="car-detail/5"><h3>BMW X1 E84 sDrive20d 2.0 AT ปี 2012</h3></a>
                                                        </header>
                                                        <p>ดีเซลตัว TOP มี BSI 2016. เนวิเกเตอร์ DVD สั่งงานด้วยเสียง สีเทา, เกียร์อัตโนมัติ, วิทยุ, ล้อแมกซ์, CD, ABS, AIRBAG, พ.พาวเวอร์...
                                                                                                                    </p><br/>
                                                        <a href="car-detail/5" class="link-arrow">Read More</a>
                                                    </div>
                                                </div><!-- /.car -->
                                                <div class="car new-car">
                                                    <div class="car-image">
                                                        <a href="car-detail/5">
                                                            <img alt="" src="http://128.199.200.28/img/cars/sample1.png">
                                                        </a>
                                                    </div>
                                                    <div class="info">
                                                        <header>
                                                            <a href="car-detail/5"><h3>BMW X1 E84 sDrive20d 2.0 AT ปี 2012</h3></a>
                                                        </header>
                                                        <p>ดีเซลตัว TOP มี BSI 2016. เนวิเกเตอร์ DVD สั่งงานด้วยเสียง สีเทา, เกียร์อัตโนมัติ, วิทยุ, ล้อแมกซ์, CD, ABS, AIRBAG, พ.พาวเวอร์...
                                                                                                                    </p><br/>
                                                        <a href="car-detail/5" class="link-arrow">Read More</a>
                                                    </div>
                                                </div><!-- /.car -->
                                            <!-- Pagination -->
                                            <div class="center">
                                                <ul class="pagination">
                                                    <li class="disabled"><span>«</span></li>
                                                    <li class="active"><span>1</span></li>
                                                    <li><a href="#">2</a></li>
                                                    <li><a href="#">3</a></li>
                                                    <li><a href="#">4</a></li>
                                                    <li><a href="#">5</a></li>
                                                    <li><a href="#">»</a></li>
                                                </ul><!-- /.pagination-->
                                            </div><!-- /.center-->
                                            </section><!-- /#cars-->




                                            </section><!-- /#Cars-->
                                        </section>
                </div>
            </div>
        </div>
         <div class="col-xs-3">
            <div class="row">
                <div class="col-xs-12">



                    <aside id="featured-cars">
                        <header><h3>Featured cars</h3></header>
                        <div class="car small">
                            <a href="car-detail.html">
                                <div class="car-image">
                                    <img alt="" src="http://128.199.200.28/img/cars/sample2.png">
                                </div>
                            </a>
                            <div class="info">
                                <a href="car-detail.html"><h4>JEEP - WRANGLER - OVER LAND CRD 2.8 AT</h4></a>
                                <figure>ปี2014 สีดำ เกียร์อัตโนมัติ เครื่องดีเซล 2800cc</figure>
                                <!-- <div class="tag price">72,000 ฿</div> -->
                            </div>
                        </div><!-- /.car -->
                        <div class="car small">
                            <a href="car-detail.html">
                                <div class="car-image">
                                    <img alt="" src="http://128.199.200.28/img/cars/sample2.png">
                                </div>
                            </a>
                            <div class="info">
                                <a href="car-detail.html"><h4>FORD - FIESTA - 5Dr Sport 1.6 AT</h4></a>
                                <figure>ปี2012 สีขาว เกียร์อัตโนมัติ เครื่องเบนซิน 1600cc</figure>
                                <!-- <div class="tag price">36,000 ฿</div> -->
                            </div>
                        </div><!-- /.car -->
                        <div class="car small">
                            <a href="car-detail.html">
                                <div class="car-image">
                                    <img alt="" src="http://128.199.200.28/img/cars/sample2.png">
                                </div>
                            </a>
                            <div class="info">
                                <a href="car-detail.html"><h4>VOLKSWAGEN - CARAVELLE - TDI 2.0 AT</h4></a>
                                <figure>ปี2014 สีขาว เกียร์อัตโนมัติ เครื่องดีเซล 2000cc</figure>
                                <!-- <div class="tag price">128,600 ฿</div> -->
                            </div>
                        </div><!-- /.car -->
                    </aside>

                    <aside id="featured-cars">
                        <header><h3>Latest cars</h3></header>
                        <div class="car small">
                            <a href="car-detail.html">
                                <div class="car-image">
                                    <img alt="" src="http://128.199.200.28/img/cars/sample2.png">
                                </div>
                            </a>
                            <div class="info">
                                <a href="car-detail.html"><h4>JEEP - WRANGLER - OVER LAND CRD 2.8 AT</h4></a>
                                <figure>ปี2014 สีดำ เกียร์อัตโนมัติ เครื่องดีเซล 2800cc</figure>
                                <!-- <div class="tag price">72,000 ฿</div> -->
                            </div>
                        </div><!-- /.car -->
                        <div class="car small">
                            <a href="car-detail.html">
                                <div class="car-image">
                                    <img alt="" src="http://128.199.200.28/img/cars/sample2.png">
                                </div>
                            </a>
                            <div class="info">
                                <a href="car-detail.html"><h4>FORD - FIESTA - 5Dr Sport 1.6 AT</h4></a>
                                <figure>ปี2012 สีขาว เกียร์อัตโนมัติ เครื่องเบนซิน 1600cc</figure>
                                <!-- <div class="tag price">36,000 ฿</div> -->
                            </div>
                        </div><!-- /.car -->
                        <div class="car small">
                            <a href="car-detail.html">
                                <div class="car-image">
                                    <img alt="" src="http://128.199.200.28/img/cars/sample2.png">
                                </div>
                            </a>
                            <div class="info">
                                <a href="car-detail.html"><h4>VOLKSWAGEN - CARAVELLE - TDI 2.0 AT</h4></a>
                                <figure>ปี2014 สีขาว เกียร์อัตโนมัติ เครื่องดีเซล 2000cc</figure>
                                <!-- <div class="tag price">128,600 ฿</div> -->
                            </div>
                        </div><!-- /.car -->
                    </aside>

                    @include('site.desktop.widgets.howto')

                </div>
            </div>
        </div>
    </div>
</div>
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
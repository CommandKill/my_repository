@extends('site.desktop._layouts.index')
@section('head')
{{-- HTML::style('css/_site/mygarage.css') --}}
<style>
.btn-close-modal {
    background: red;
    width: 28px;
    height: 28px;
    text-align: center;
    position: absolute;
    right: -10px;
    top: -10px;
    color: #fff;
    font-size: 43px;
    border-radius: 50%;
    border: solid 2px;
    line-height: 13px;
    cursor: pointer;
    -webkit-box-shadow: 0 5px 15px rgba(0, 0, 0, 0.5);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.5);
}
</style>
@stop
@section('content')

    <div class="container">
        <div class="row page">
            <div class="col-md-3 col-sm-3">
                @include('site.desktop._partials.member_nav')
            </div>
            <div class="col-md-9 col-sm-9">
                <section id="my-cars">
                    <header>
                        <h1>My Search</h1>
                    <br />
                    <div class="row">

                    @if($search->count())
                    @foreach($search as $c)
                    
                    <div class="col-xs-4">
                        <div class="garage-item">
                            <div class="thumbnail">
                              <span class="label label-default">Created <abbr class="timeago" title="{{ $c->created_at }}">{{ $c->created_at }}</abbr></span>
                              <div class="caption">
                                <h3>
                                  <a href="{{ URL::to(App::getLocale().'/listing') }}?q={{ $c->query }}&amp;year={{ $c->car_year }}&amp;make={{ $c->car_make }}&amp;model={{ $c->car_model }}&amp;engine_size={{ $c->car_engine }}&amp;fuel={{ $c->car_fuel }}&amp;gear={{ $c->car_transmission }}&amp;door={{ $c->car_door }}&amp;mileage={{ $c->mileage }}&amp;body={{ $c->car_type }}&amp;color={{ $c->car_colors }}&amp;distance={{ $c->distance }}&amp;price-min={{ $c->min_price }}&amp;price-max={{ $c->max_price }}&amp;"><strong>{{ $c->strMake }} {{ $c->strModel }}</strong></a>
                                </h3>
                              </div>
                                <div class="action-box">
                                  <div class="btn-group">
                                    <a href="#delete" data-href="{{ URL::to(App::getLocale().'/remove-search/'.$c->id) }}" 
                                          data-toggle="modal" data-target="#modal-confirm-confirm-to-delete" 
                                          class='btn btn-default btn-delete'><i class="delete fa fa-trash-o"></i></a>
                                  </div>
                                   <a class="btn btn-primary" href="{{ URL::to(App::getLocale().'/listing') }}?q={{ $c->query }}&amp;year={{ $c->car_year }}&amp;make={{ $c->car_make }}&amp;model={{ $c->car_model }}&amp;engine_size={{ $c->car_engine }}&amp;fuel={{ $c->car_fuel }}&amp;gear={{ $c->car_transmission }}&amp;door={{ $c->car_door }}&amp;mileage={{ $c->mileage }}&amp;body={{ $c->car_type }}&amp;color={{ $c->car_colors }}&amp;distance={{ $c->distance }}&amp;price-min={{ $c->min_price }}&amp;price-max={{ $c->max_price }}&amp;">go to search</a>
                                </div>
                              
                            </div>


                        </div>
                    </div>
                    
                    @endforeach
                    @endif
                  

                    </div>
                    <div class="center">{{ $search->links() }}</div>
                </section>
            </div>
        </div>
    </div>

    <div class='modal fade' id='modal-confirm-confirm-to-delete' tabindex='-1'>
      <div class='modal-dialog'>
        <div class='modal-content'>
            <div class='modal-header'>
             <button aria-hidden='true' class='close' data-dismiss='modal' type='button'>×</button>
             <h4 class='modal-title' id='myModalLabel'>Delete listing</h4>
            </div>
            <div class='modal-body' style="padding-bottom: 0;">
                 <div class='form-group'>
                    <label class='control-label'>Are you sure you want to delete your search?</label>
                    <!-- <button class='btn btn-default btn-sm btn-block search-btn' type='submit'>Sure</button> -->
                    <a href="" id="link-delete-post" class='btn btn-primary btn-sm btn-block search-btn'>Yes</a>
                 </div> 
            </div>
        </div>
      </div>
    </div> <!-- /.modal --> 

    
@stop

@section('footer')
{{ HTML::script('js/plugins/jquery.timeago.js') }}
<script type='text/javascript'>
$(function(){

    $('.btn-delete').click(function(){
        $('#link-delete-post').attr('href', $(this).data('href'));
    });
    $('#modal-confirm-confirm-to-delete').on('shown.bs.modal', function (e) {

    })


    $("abbr.timeago").timeago();


}); 
</script>
@stop

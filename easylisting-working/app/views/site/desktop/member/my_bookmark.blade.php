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
        <div class="row">
            <div class="col-md-3 col-sm-3">
                @include('site.desktop._partials.member_nav')
            </div>
            <div class="col-md-9 col-sm-9">
                <section id="my-cars">
                    <header>
                        <h1>My Garage</h1>
                        <!-- <a href="{{ URL::to(App::getLocale().'/my-garage/create') }}" class="btn btn-default pull-right">Add New</a> -->
                        <a href="#new-post" data-toggle="modal" data-target="#modal-post-new"><i class="glyphicon glyphicon-plus"></i> Post new car</a>
                    </header>
                    <br />
                    <div class="row">

                    @if($data['posts']->count() > 0)
                    @foreach($data['posts'] as $c)
                    
                    <div class="col-xs-4 no-padding">
                        <div class="garage-item">
                            

                            <div class="thumbnail">
                              <img src="{{ asset('img/car-empty.jpg') }}" alt="...">
                              <div class="caption">
                                <h3><a href="{{ URL::to(App::getLocale().'/car-detail/'.$c->content_id) }}"><strong>{{ $c->title or 'Untitled' }}</strong></a></h3>
                                <p>
                                    <div class="pull-left">Created <abbr class="timeago" title="{{ $c->created_at }}">{{ $c->created_at }}</abbr></div>
                                    <br/>
                                    <div class="tag price"> {{ number_format($c->price) }} ฿</div>
                                </p>
                                <p>
                                    <a href="{{ URL::to(App::getLocale().'/my-garage/car/'.$c->content_id.'/select') }}" 
                                        class="edit btn btn-default"><i class="fa fa-pencil"></i></a>
                                    <a href="#delete" data-href="{{ URL::to(App::getLocale().'/my-garage/destroy/'.$c->content_id) }}" 
                                        data-toggle="modal" data-target="#modal-confirm-confirm-to-delete" 
                                        class='btn btn-default btn-delete'><i class="delete fa fa-trash-o"></i></a>
                                </p>
                              </div>
                            </div>


                        </div>
                    </div>
                    
                    @endforeach
                    @endif
                  

                    </div>
                    <div class="center">{{ $data['posts']->links() }}</div>
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
                    <label class='control-label'>Are you sure you want to delete your listing?</label>
                    <!-- <button class='btn btn-default btn-sm btn-block search-btn' type='submit'>Sure</button> -->
                    <a href="" id="link-delete-post" class='btn btn-primary btn-sm btn-block search-btn'>Yes</a>
                 </div> 
            </div>
        </div>
      </div>
    </div> <!-- /.modal --> 

    @include('site.desktop.member.my-garage.car-new-post-modal')
    
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

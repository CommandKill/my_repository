	    <div style="float:left;width:630px;clear:both;">
	                <p style="font-size:15px;">Hi {{ $friend_name }}</p>
					<p>{{ $name }}  thought this advert would be interesting to you.</p>
					<p style="margin-left:20px">{{ $msg }}</p>
	   </div>
	   <div style="float:left;border:1px solid #CFD6DE;width:640px;clear:both;padding:5px">
		   <div style="float:left;width:320px;height:200px">
	            @if($detail['gallery'][0]['name'] != 'null')
	            <img class="file-preview-image" src="{{ asset('uploaded/post/'.$detail['post_id'].'/gallery/330x200-'.$detail['gallery'][0]['name']) }}" title="{{ $detail['gallery'][0]['name'] }}" alt="{{ $detail['gallery'][0]['name'] }}">
	            @else
	            <img class="file-preview-image" src="{{ asset('img/avatar.jpg') }}" title="placeholder" alt="placeholder">
	            @endif
			</div>
            <div style="float:left;width: 310px;margin-left:5px;">
                <small>ID {{ $detail['post_id'] }}</small>
                <header>
                <a href="{{ URL::to(App::getLocale().'/car-detail/'.$detail['post_id']) }}">
                    {{ $detail['title'] }}
                </a>
                </header>
                <ul style="list-style-type:none;padding:10px;">
                    <li style="width: 125px;float: left;margin: 4px;font-weight: lighter;">
						<i style="background-image:url('{{ asset('img/icons/icon-mile@1x.png')}}') ;width:20px;height:20px;display:inline-blick;float:left; margin-right:4px;"></i>
						 {{$detail['mileage'] or 'n/a'}}
					 </li>
                    <li style="width: 125px;float: right;margin: 4px;font-weight: lighter;">
						<i style="background-image:url('{{ asset('img/icons/icon-year@1x.png')}}') ;width:20px;height:20px;display:inline-blick;float:left; margin-right:4px;"></i>
						{{$detail['year'] or 'n/a'}}
					</li>
                    <li style="width: 125px;float: left;margin: 4px;font-weight: lighter;">
						<i style="background-image:url('{{ asset('img/icons/icon-gear@1x.png')}}') ;width:20px;height:20px;display:inline-blick;float:left; margin-right:4px;"></i>
						{{$detail['gear'] or 'n/a'}}
					</li>
                    <li style="width: 125px;float: right;margin: 4px;font-weight: lighter;">
						<i style="background-image:url('{{ asset('img/icons/icon-engine@1x.png')}}') ;width:20px;height:20px;display:inline-blick;float:left; margin-right:4px;"></i>
						 {{$detail['size'] or 'n/a'}}
					 </li>
                    <li style="width: 125px;float: left;margin: 4px;font-weight: lighter;">
						<i style="background-image:url('{{ asset('img/icons/icon-fuel@1x.png')}}') ;width:20px;height:20px;display:inline-blick;float:left; margin-right:4px;"></i>
						{{$detail['type'] or 'n/a'}}
					</li>
                    <li style="width: 125px;float: right;margin: 4px;font-weight: lighter;">
						<i style="background-image:url('{{ asset('img/icons/icon-colour@1x.png')}}') ;width:20px;height:20px;display:inline-blick;float:left; margin-right:4px;"></i>
						 {{$detail['color'] or 'n/a'}}
					 </li>
                </ul>
            </div>
	        <div style="float:left;width:95%;border-top:1px solid #CFD6DE; padding:15px;">
	            <div style="float:right;width:110px;">
	                <a href="{{ URL::to(App::getLocale().'/car-detail/'.$detail['post_id']) }}" style="background: #5cb85c !important;color: #ffffff !important;border: 1px solid #55AB55;font-size:14px;padding:5px;width:100px;text-decoration: none;-webkit-border-radius: 3px;-moz-border-radius: 3px;border-radius: 3px;float:left;text-align:center;">View full ad</a>
	            </div>
	            <div style="float:left;width:150px">
	              <div type="button" style="background: #06A2E7 !important;color: #ffffff !important;border: 1px solid #06A2E7;font-size: 14px;padding:5px;width:100px;-webkit-border-radius: 3px;-moz-border-radius: 3px;border-radius: 3px;text-align:center">{{ number_format($detail['price']) }} ฿</div>
	            </div>
	        </div>
	   </div>

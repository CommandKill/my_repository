<?php
 
class Banner extends \Eloquent {
 
    protected $table = 'banners';

    protected $guarded = array('id');
	
	// public function scopePage($q,$status,$type){
	// 	return $q->join('content_data', function($join)
	//         {
	//             $join->on('content.id', '=', 'content_data.content_id')
	//                  ->where('content_data.language_code', '=', 'en');
	//         })->whereIn('content.status',$status)->where('content.content_type','=',$type);
	// }
	
	public function page(){
		return $this->hasOne('BannerPage','id', 'page_id');
	}
	
	public function position(){
		return $this->belongsTo('BannerPosition', 'position_id');
	}
 
	public function files(){
		return $this->belongsTo('BannerFile', 'file_id');
	}
}
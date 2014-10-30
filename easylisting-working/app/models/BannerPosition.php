<?php
 
class BannerPosition extends \Eloquent {
 
    protected $table = 'banners_positions';

    protected $guarded = array('id');
	
	// public function scopePage($q,$status,$type){
	// 	return $q->join('content_data', function($join)
	//         {
	//             $join->on('content.id', '=', 'content_data.content_id')
	//                  ->where('content_data.language_code', '=', 'en');
	//         })->whereIn('content.status',$status)->where('content.content_type','=',$type);
	// }
 
}
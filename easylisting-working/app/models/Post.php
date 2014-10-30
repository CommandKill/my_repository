<?php

class Post extends \Eloquent {
	protected $fillable = [];
	protected $table = 'posts';
	
	protected $guarded = array('id');
	
	public function lang(){
	    return $this->hasMany('PostLanguage');
	}

	public function gallery(){
	    return $this->hasMany('PostGallery')->orderBy('order','ASC');
	}

	public function tags(){
	    return $this->hasMany('PostTag');
	}

	public function post_by()
    {
        return $this->belongsTo('Member', 'created_by');
    }

    public function modify_by()
    {
        return $this->belongsTo('User', 'updated_by');
    }

	public function year(){
	    return $this->belongsTo('CarbaseYear');
	}

	public function color(){
	    return $this->belongsTo('CarbaseColor');
	}

	public function engine(){
	    return $this->belongsTo('CarbaseEngine');
	}

	public function fuel(){
	    return $this->belongsTo('CarbaseFuel');
	}

	public function gear(){
	    return $this->belongsTo('CarbaseGear');
	}

	public function make(){
	    return $this->belongsTo('CarbaseMake');
	}

	public function model(){
	    return $this->belongsTo('CarbaseModel');
	}

	public function submodel(){
	    return $this->belongsTo('CarbaseSubModel');
	}

	public function amphur(){
	    return $this->belongsTo('Amphur','amphur_id');
	}

	public function district(){
	    return $this->belongsTo('District','district_id');
	}

	public function province(){
	    return $this->belongsTo('Province','province_id');
	}

	public function car_verified(){
	    return $this->hasOne('CarVerified');
	}

	public function seller_verified(){
	    return $this->hasOne('SellerVerified', 'member_id', 'created_by');
	}
}
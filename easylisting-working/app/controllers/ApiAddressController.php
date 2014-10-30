<?php

class ApiAddressController extends APIController
{
	public function __construct()
	{
		parent::__construct();
	}

    public function getIndex()
    {
        $this->printMethod('ApiAddressController','v1/address');
    }

    public function getProvince()
    {
        $data = DB::table('province')
                ->select('id','name as province')
                ->orderBy('name', 'asc')
                ->get();

        return Response::json(array(
            'error' => false,
            'provinces' => $data),
            200
        );
    }

    public function getAmphur($province_id=null)
    {
        if ($province_id == null) {
            return Response::json(array(
                'error' => true,
                'message' => 'require province id'),
                404
            );
        }

        $data = DB::table('amphur')
                ->select('id','name as amphur')
                ->where('province_id', $province_id)
                ->orderBy('name', 'asc')
                ->get();

        return Response::json(array(
            'error' => false,
            'amphurs' => $data),
            200
        );
    }

    public function getDistrict($amphur_id=null)
    {
        if ($amphur_id == null) {
            return Response::json(array(
                'error' => true,
                'message' => 'require amphur id'),
                404
            );
        }

        $data = DB::table('district')
                ->select('id','name as district')
                ->where('amphur_id', $amphur_id)
                ->orderBy('name', 'asc')
                ->get();

        return Response::json(array(
            'error' => false,
            'districts' => $data),
            200
        );
    }

    public function getZipcode($district_id=null)
    {
        if ($district_id == null) {
            return Response::json(array(
                'error' => true,
                'message' => 'require district id'),
                404
            );
        }

        $district_code = DB::table('district')->select('code')->where('id', $district_id)->first();
        $data = DB::table('zipcode')
                ->select('id','zipcode')
                ->where('district_code', $district_code->code)
                ->get();

        return Response::json(array(
            'error' => false,
            'zipcodes' => $data),
            200
        );
    }
}
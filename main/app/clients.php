<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class clients extends Model
{
    public function get_ip_data($id,$sort,$limit=null,$start=null,$search=null){
    	$client_data = DB::table('client_users')
    		->where('id',$id)
    		->first();
    	if(!empty($search)){
    		if(empty($limit) && $start == 0){
		    	$result_data = DB::table('disclaimer')
		    	->where('client_id',$client_data->client_id)
		    	->where('id', 'LIKE', '%'.$search.'%')
		    	->orWhere('url', 'LIKE', '%'.$search.'%')
		    	->orWhere('ip_address', 'LIKE', '%'.$search.'%')
		    	->orWhere('date', 'LIKE', '%'.$search.'%')
		    	->orderBy('id',$sort)
		    	->get();
		    }else{
		    	$result_data = DB::table('disclaimer')
		    	->where('client_id',$client_data->client_id)
		    	->where('id', 'LIKE', '%'.$search.'%')
		    	->orWhere('url', 'LIKE', '%'.$search.'%')
		    	->orWhere('ip_address', 'LIKE', '%'.$search.'%')
		    	->orWhere('date', 'LIKE', '%'.$search.'%')
		    	->orderBy('id',$sort)
		    	->offset($start)
		    	->limit($limit)
		    	->get();
		    }
    	}else{
    		if(empty($limit) && $start == 0){
		    	$result_data = DB::table('disclaimer')
		    	->where('client_id',$client_data->client_id)
		    	->orderBy('id',$sort)
		    	->get();
		    }else{
		    	$result_data = DB::table('disclaimer')
		    	->where('client_id',$client_data->client_id)
		    	->orderBy('id',$sort)
		    	->offset($start)
		    	->limit($limit)
		    	->get();
		    }
    	}
  
		$result_data_arr = array();
		$i = 1;
		foreach ($result_data->toArray() as $key => $value) {
    		$value->sr_no = $i+$start;
    		$value->visit_date = date('M d Y H:i:s',strtotime($value->date));
    		$value->visit_type = ($value->status == 1)?'Visit':'Agree';
    		$result_data_arr[] = $value;

    		$i++;
    	}
    	return $result_data_arr;
    }
}

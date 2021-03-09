<?php 
	if (! function_exists('get_level_detail')) {
	   function get_level_detail($level_name) 
	   {
	     $level_res = \DB::table('levels')
        ->where('level_name', $level_name)
        ->first();
         return $level_res;
	   }
	}

	function get_client(){
		$user_data = DB::table('client_users')->get()->toArray();
		return $user_data;
	}

	function get_process_info_data($user_id,$process){
		$process_action = DB::table('certification_process_action')->where('certification_process','LIKE','%'.$process.'%')->get()->toArray();
		if (count($process_action) != 0) {
			$process_id = $process_action[0]->id;
			$process_data = DB::table('certification_process_info')
				->where('plan_id',$process_id)
				->where('client_id',$user_id)
				->first();
				$who_action = !empty($process_data)?$process_data->who_action:'';
				$where_action = !empty($process_data)?$process_data->where_action:'';
				$notes  = !empty($process_data)?$process_data->notes:'';
				$date = !empty($process_data)?$process_data->date:'';
				$new_array = (object) array(
					'who_action'   => $who_action,
					'where_action' => $where_action,
					'notes'        => $notes,
					'date'          => $date
				);
				
			
		}else{
			$new_array = (object) array(
					'who_action'   => '',
					'where_action' => '',
					'notes'        => '',
					'date'          => ''
				);
		}
		return $new_array;
	}
	function get_process_level_feature_data($id,$process_info_id){
        // DB::enableQueryLog();
        // print_r($id); die("dddd");
        $process_info = DB::table('certification_process_info')
        ->where('client_id',$id)
        ->whereIn('plan_id',$process_info_id)
        ->where('who_action','!=','NULL')
        ->where('where_action','!=','NULL')
        ->where('date','!=','NULL')
        ->get();
        // $query = DB::getQueryLog();
        if(count($process_info) !=0){
            $plan_id = array();
            foreach ($process_info as $process_val) {
                $plan_id[] = $process_val->plan_id;
            }
            if(count($plan_id) == count($process_info_id)){
                $action_name = DB::table('certification_process_action')
                    ->whereIn('level_feature_id',$plan_id)
                    ->distinct()->get(['level_feature_id'])->toArray();

                $level_feature_id = array();      
                foreach ($action_name as $action_val) {
                    $feature_process_action = DB::table('certification_process_action')
                    ->where('level_feature_id',$action_val->level_feature_id)
                    ->get()->toArray();
                    $total_level = array();
                    foreach ($process_info as $key => $level) {
                        $level_data = DB::table('certification_process_action')
                        ->where('level_feature_id',$level->plan_id)
                        ->where('level_feature_id',$action_val->level_feature_id)
                        ->first();
                        if(!empty($level_data)){
                            $total_level[] = $level_data;
                        }
                      
                    }

                    if(count($feature_process_action) == count($total_level)){
                        $level_feature_id[] = $action_val->level_feature_id;
                    }
                 
                }
                $level_feature_res =  DB::table('level_features')
                    ->whereIn('id',$level_feature_id)
                    ->get()->toArray();
                $level_feature_data = array();
                foreach ($level_feature_res as $level_feature_val) {
                   $certification_allow_data = DB::table('certification_process_action AS a')
                    ->leftJoin('certification_process_info AS b', 'a.level_feature_id', '=', 'b.plan_id')
                    ->select('b.date')
                    ->where('a.level_feature_id',$level_feature_val->id)
                    ->where('a.feature_award_allow', '1')
                            ->where('b.client_id',$id)
                    ->first();

                    $level_feature_val->certification_process_date = !empty($certification_allow_data)?$certification_allow_data->date:'';
                    $level_feature_data[] = $level_feature_val;
                }
                $sort = array();
                foreach ($level_feature_data as $key => $feature_val) {
			       $sort[$key] = strtotime($feature_val->certification_process_date);
			  	}
			  	array_multisort($sort, SORT_ASC, $level_feature_data);
                return $level_feature_data;
            }
        }
    }

    function get_term_policy_data($user_id=null,$email_id=null){
    	// print_r($email_id);
    	if($email_id != null && $user_id == null){
    		// die('kkll');
    		$user_data = DB::table('client_users')
	        ->where('email_id',$email_id)
	        ->first();
	       $term_data = DB::table('clients_info')
	        ->where('primary_id',$user_data->id)
	        ->first();
    	}else{
    		// die('kkllffff');
	    	$term_data = DB::table('clients_info')
	        ->where('primary_id',$user_id)
	        ->first();
	        
	    }
	    if(!empty($term_data)){
	    	return $term_data;
	    }else{
	    	return array();
	    }
    }
    function get_certification_purchase_info($level_id,$user_id=null){
    	$result = DB::table('payment_details')
    		->where('user_id', $user_id)
    		->where('level', $level_id)
    		->first();
        $clients_status = DB::table('clients_info')
            ->where('primary_id', $user_id)
            ->first();
        $result_arr = (object) array();
        $result_arr->payment_data = $result;
        $result_arr->expire_date = !empty($clients_status && $clients_status->certification_renewal_date != NULL)?date('Y-m-d',strtotime($clients_status->certification_renewal_date)):'';
        $result_arr->current_date = date('Y-m-d');
    	return $result_arr;
    }

    function get_awarded_data($user_id=null){
        $result = DB::table('clients_info')
            ->where('primary_id', $user_id)
            ->first();
        $level_data = DB::table('payment_details')
            ->where('user_id', $user_id)
            ->where('status','2')
            ->orderBy('id', 'DESC')
            ->first();
        $result_arr = array();
        $result_arr['award_data'] = $result;
        $result_arr['payment_info'] = $level_data; 
        return $result_arr;
    }

    function payment_info($payer_id){
        $result = DB::table('payment_details')
            ->where('payer_id', $payer_id)
            ->first();
        $user_id = !empty($result)?$result->user_id:'';
        $user_data = DB::table('client_users')
            ->where('id', $user_id)
            ->first();
        return $user_data;
    }
    function get_payment_info($user_id){
        $result = DB::table('payment_details')
            ->where('user_id', $user_id)
            ->orderBy('id','DESC')
            ->get()->toArray();
        $result_arr = array();
        if(!empty($result)){
            foreach ($result as $res_val) {
                $level_data = DB::table('levels')->where('id',$res_val->level)->first();
                $res_val->level_name = !empty($level_data)?$level_data->level_name:'';
                $result_arr[] = $res_val;
            }
        }
        return $result_arr;
    }
    function get_process_log_data($id,$plan_id){
    
    	    $process_info = DB::table('certification_process_info')
	            ->where('client_id',$id)
	            ->where('plan_id',$plan_id)
	            ->first();
	    if(!$process_info){
	             $process_info = DB::table('process_info_log')
	            ->where('client_id',$id)
	            ->where('plan_id',$plan_id)
	            ->first();
	    }
        return $process_info;
    }
?>
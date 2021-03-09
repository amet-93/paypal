<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;

class ProcessController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $process_action = $this->get_certification_process_action();
        $info_data = $this->get_certification_process($id);
        // print_r($process_action);die();
        return view('process.add_process',['id' => $id,'info_data' => $info_data,'process_action'=> $process_action]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if($request){
            $input = $request->all();
            $who_action = $input['who_action_'];
            $where_action = $input['where_action_'];
            $notes = $input['notes_'];
            
            // $validator = \Validator::make(
            //         [
            //             'who_action'            => $who_action,
            //             'where_action'          => $where_action
            //         ],
            //         [
            //             'who_action'             => 'required',
            //             'where_action'           => 'required'
            //         ]
            //     );
            // if($validator->fails()){
            //     return redirect('admin/add-process-info/'.$id)->withErrors($validator)->withInput();
            // }else{

            $payment_id = \DB::table('payment_details')->where(array('user_id' =>$id,'status' => '1'))->orderby('id','DESC')->pluck('id')->first();
            $process_data = $this->get_certification_process($id);
            $process_action = $this->get_certification_process_action();
            $total_action = count($process_action)+1;
            if(count($process_data) == 0){
                for ($i= 1; $i < $total_action; $i++) { 
                    $process_date = (!empty($input['process_date_'][$i]))?date('Y-m-d H:i:s',strtotime($input['process_date_'][$i])):NULL;
                    $insert_data = array(
                        'who_action'     => $who_action[$i],
                        'plan_id'        => $i,
                        'where_action'   => $where_action[$i],
                        'notes'          => $notes[$i],
                        'client_id'      => $id,
                        'date'           => $process_date
                    ); 
                    $info_data = \DB::table('process_info_log')->insert($insert_data);
                    $info_data = \DB::table('certification_process_info')->insert($insert_data);
                }
                
                if($info_data == true){
                    $request->session()->flash('alert-success','Certification process info save successfully');
                    return redirect('admin/add-process-info/'.$id);
                }
            }else{
                foreach($process_data as $process_val) { 
                    $process_date = (!empty($input['process_date_'][$process_val->id]))?date('Y-m-d H:i:s',strtotime($input['process_date_'][$process_val->id])):NULL;
                    $update_data = array(
                        'who_action'     => $who_action[$process_val->id],
                        'where_action'   => $where_action[$process_val->id],
                        'notes'          => $notes[$process_val->id],
                        'date'           => $process_date
                    );
                    // $info_data = \DB::table('certification_process_info')->where('id', $process_val->id)->update($update_data);
            
                    $info_data = \DB::table('process_info_log')->where('id', $process_val->id)->update($update_data);
                    $info_data = \DB::table('certification_process_info')->where('id', $process_val->id)->update($update_data);
                }
                // if($info_data == true){
                    $request->session()->flash('alert-success','Certification process info update successfully');
                    return redirect('admin/add-process-info/'.$id);
                // }
            }
            // }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    /**
     * Retreive the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function get_certification_process($id){
//        $process_info = \DB::table('process_info_log')->where('client_id',$id)->get();
         $process_info = \DB::table('certification_process_info')->where('client_id',$id)->get();
// dd(\DB::table('certification_process_info')->where('client_id',$id)->get());
        return $process_info;
    }
    public function get_certification_process_action(){
        $process_action = \DB::table('certification_process_action')->get();
        $process_array = array();
        foreach ($process_action as $process_val) {
            $certification_process = $process_val->certification_process;
            $certification_arr = explode(' ', $certification_process);
            $total_arr = count($certification_arr)-1;
            $certification_action = $certification_arr[$total_arr];
            $process_val->certification_action = $certification_action;
            $process_array[] = $process_val;
        }
        return $process_action;
    }
}

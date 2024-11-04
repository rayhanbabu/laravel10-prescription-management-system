<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\Appointment;
use App\Models\Member;
use App\Models\Chamber;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\validator;
use  DateTime;

class AppointmentController extends Controller
{

    public function appointment(Request $request){

        $user=user_info();
        $member = Member::where('admin_id',$user->admin_id)->get();
        $chamber = Chamber::where('admin_id',$user->admin_id)->get();

      if ($request->ajax()) {
          $data = Appointment::leftjoin('members','members.id','=','appointments.member_id')
          ->leftjoin('chambers','chambers.id','=','appointments.chamber_id')
          ->where('appointments.admin_id',$user->admin_id)
          ->select('chambers.chamber_name','members.member_name','members.phone','appointments.*')->latest()->get();

        return Datatables::of($data)
           ->addIndexColumn()
           ->addColumn('image', function($row){
            $imageUrl = asset('uploads/admin/'.$row->image); // Assuming 'image' is the field name in the database
            return '<img src="'.$imageUrl.'" alt="Image" style="width: 50px; height: 50px;"/>';
          })
          ->addColumn('status', function($row){
            $statusBtn = $row->appointment_status == '1' ? 
                '<button class="btn btn-success btn-sm">Completed</button>' : 
                '<button class="btn btn-secondary btn-sm" >Pending</button>';
            return $statusBtn;
          })
          ->addColumn('prescription', function($row){
            $btn = '<a href="/prescription/'.$row->id.'" class="btn btn-primary btn-sm">Print</a>';
            return $btn;
         })
         ->addColumn('setup', function($row){
            $btn = '<a href="/admin/appointment/setup/'.$row->id.'" class="btn btn-primary btn-sm">Setup</a>';
            return $btn;
         })
          ->addColumn('edit', function($row){
            $btn = '<a href="javascript:void(0);" data-id="' . $row->id . '" class="edit btn btn-primary btn-sm">Edit</a>';
            return $btn;
        })
          ->addColumn('delete', function($row){
            $btn = '<a href="javascript:void(0);" data-id="' . $row->id . '" class="delete btn btn-danger btn-sm">Delete</a>';
            return $btn;
        })
          ->rawColumns(['prescription','setup','image','status','edit','delete'])
          ->make(true);
       }

          return view('admin.appointment',['member'=>$member,'chamber'=>$chamber]);  
      }



      public function store(Request $request)
      {

          $user=user_info();
          $validator = \Validator::make(
              $request->all(),
              [
                  'member_id'=> 'required',
                  'chamber_id'=> 'required',
                  'image' => 'image|mimes:jpeg,png,jpg|max:400',
               ]);
  
          if ($validator->fails()) {
              return response()->json([
                  'status' =>400,
                  'message' =>$validator->messages(),
              ]);
          } else {
             $date= date("Y-m-d");
             $year= date("Y");
             $month= date("m");
             $day= date("d");

             $member = Member::where('id',$request->input('member_id'))->first();
             if($member){
             $date1 = new DateTime($date);
             $date2 = new DateTime($member->dobirth);
             $yearDifference = getYearsBetween2Dates($date1, $date2, false);

              $model = new Appointment;
              $model->admin_id = $user->admin_id;
              $model->member_id = $request->input('member_id');
              $model->chamber_id = $request->input('chamber_id');
              $model->payment_amount = $request->input('payment_amount');
              $model->disease_problem = $request->input('disease_problem');
              $model->age = $yearDifference;
              $model->date = $date;
              $model->year = $year;
              $model->month = $month;
              $model->day = $day;
              $model->created_by=$user->id;

               if ($request->hasfile('image')) {
                      $imgfile = 'booking-';
                      $image = $request->file('image');
                      $new_name = $imgfile . rand() . '.' . $image->getClientOriginalExtension();
                      $image->move(public_path('uploads/admin'), $new_name);
                      $model->image = $new_name;   
                 }
              $model->save();
  
              return response()->json([
                  'status' => 200,
                  'message' => 'Data Added Successfully',
              ]);

            }else{

            }

          }
      }


      public function edit(Request $request)
        {
          $id = $request->id;
          $data = Appointment::find($id);
            return response()->json([
                'status' => 200,
                'value' => $data,
            ]);
         }
  
  


      public function update(Request $request)
      {
  
          $user=user_info();
          $validator = \Validator::make($request->all(), [
               'member_id'=> 'required',
               'chamber_id'=> 'required', 
               'image' => 'image|mimes:jpeg,png,jpg|max:400',  
          ]);
  
         
          if ($validator->fails()) {
              return response()->json([
                  'status' => 400,
                  'message' => $validator->messages(),
              ]);
          } else {
              $model = Appointment::find($request->input('edit_id'));
              if ($model){
                $model->member_id = $request->input('member_id');
                $model->chamber_id = $request->input('chamber_id');
                $model->payment_amount = $request->input('payment_amount');
                $model->disease_problem = $request->input('disease_problem');
                $model->updated_by=$user->id;
  
                  if ($request->hasfile('image')) {
                      $imgfile = 'booking-';
                          $path = public_path('uploads/admin') . '/' . $model->image;
                          if (File::exists($path)) {
                               File::delete($path);
                          }
                          $image = $request->file('image');
                          $new_name = $imgfile . rand() . '.' . $image->getClientOriginalExtension();
                          $image->move(public_path('uploads/admin'), $new_name);
                          $model->image = $new_name;
                  }
                 $model->update();
                     return response()->json([
                        'status' => 200,
                        'message' => 'Data Updated Successfully'
                      ]);
              } else {
                  return response()->json([
                      'status' => 404,
                      'message' => 'Student not found',
                  ]);
              }
          }
      }
  

      public function delete(Request $request)
      {
          $model = Appointment::find($request->input('id'));
          $filePath = public_path('uploads/admin') . '/' . $model->image;
          if (File::exists($filePath)) {
              File::delete($filePath);
          }
          $model->delete();
          return response()->json([
              'status' => 200,
              'message' => 'Data Deleted Successfully',
          ]);
  
      }
  
     

}

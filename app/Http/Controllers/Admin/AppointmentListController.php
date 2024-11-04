<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Chamber;
use App\Models\Member;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use  DateTime;
use App\Models\Appointment;
use App\Models\Medicine;
use App\Models\Medicineprovide;
use App\Models\Medicineoutside;
use App\Models\Test;
use App\Models\Testprovide;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AppointmentListController extends Controller
{

   
    public function appointment_setup(Request $request, $appointment_id){

        $user=user_info();
        $result['appointment'] = Appointment::leftJoin('members','members.id','=','appointments.member_id')
        ->leftJoin('users','users.id','=','appointments.admin_id')
        ->leftJoin('chambers','chambers.id','=','appointments.chamber_id')
        ->where('appointments.id',$appointment_id)
        ->where('appointments.admin_id',$user->admin_id)
        ->select('chambers.chamber_name','users.name','members.member_name','members.gender','appointments.*')->first();


        //Medicine In Pharmacy
        $data = Medicineprovide::where('appointment_id',$appointment_id)->where('admin_id',$user->admin_id)->get();
           if ($data->count()>0) {
               $result['inmedicineattr']= Medicineprovide::where('appointment_id',$appointment_id)->where('admin_id',$user->admin_id)->get();
               $result['medicine'] = Medicine::leftjoin('generics','generics.id','=','medicines.generic_id')
                 ->where('medicines.admin_id',$user->admin_id)
                 ->select('generics.generic_name','medicines.*')->get();
           } else {
               $result['inmedicineattr'][0]['total_day'] = '';
               $result['inmedicineattr'][0]['eating_time'] = '';
               $result['inmedicineattr'][0]['eating_status'] = '';
               $result['inmedicineattr'][0]['medicine_id'] = '';
               $result['inmedicineattr'][0]['id'] = '';
               $result['medicine'] = Medicine::leftjoin('generics','generics.id','=','medicines.generic_id')
               ->where('medicines.admin_id',$user->admin_id)
               ->select('generics.generic_name','medicines.*')->get();
           }


           //Medicine out of Pharmacy
           $outmedicine = Medicineoutside::where('appointment_id',$appointment_id)->where('admin_id',$user->admin_id)->get();
           if ($outmedicine->count()>0) {
               $result['outmedicineattr']= Medicineoutside::where('appointment_id',$appointment_id)->where('admin_id',$user->admin_id)->get();
           } else {
               $result['outmedicineattr'][0]['total_day'] = '';
               $result['outmedicineattr'][0]['eating_time'] = '';
               $result['outmedicineattr'][0]['eating_status'] = '';
               $result['outmedicineattr'][0]['medicine_name'] = '';
               $result['outmedicineattr'][0]['id'] = '';
           }


          
           //Test In Medical
        $testprovide = Testprovide::where('appointment_id',$appointment_id)->where('admin_id',$user->admin_id)->get();
         if ($testprovide->count()>0) {
             $result['intestattr']= Testprovide::where('appointment_id',$appointment_id)->where('admin_id',$user->admin_id)->get();
             $result['test'] = Test::where('test_status',1)->where('admin_id',$user->admin_id)->orderBy('id','desc')->get();
         } else {
             $result['intestattr'][0]['test_id'] = '';
             $result['intestattr'][0]['id'] = '';
             $result['test'] = Test::where('test_status',1)->where('admin_id',$user->admin_id)->orderBy('id','desc')->get();
         }

         
             return view('admin.appointment_setup',$result); 
       }



    public function appointment_setup_update(Request $request){
        
             DB::beginTransaction();
             try {
             $appointment_id = $request->post('appointment_id');
             $date= date("Y-m-d");
             $year= date("Y");
             $month= date("m");
             $day= date("d");
             $user=user_info();
             $advice = $request->post('advice');
             $visit_day = $request->post('visit_day');

                 $model = Appointment::find($appointment_id);
             if($model){
                 $model->advice =$advice;
                 $model->visit_day =$visit_day;
                 $model->admin_id =$user->admin_id;
                 $model->created_by =$user->user_id;
                 $model->appointment_status=1;
                 $model->update();
               }


            //medicine in Pharmacy
            $inmedicineid = $request->post('inmedicineid');
            $medicine_id = $request->post('medicine_id');
            $eating_time = $request->post('eating_time');
            $eating_status = $request->post('eating_status');
            $total_day = $request->post('total_day');

            foreach ($inmedicineid as $key => $val) {  
              if ($medicine_id[$key] && $total_day[$key] ) { 
                    $inmedicineattr['medicine_id'] = $medicine_id[$key];
                    $inmedicineattr['total_day'] = $total_day[$key];
                    $inmedicineattr['eating_time'] = $eating_time[$key];
                    $inmedicineattr['eating_status'] = $eating_status[$key];
                    $inmedicineattr['appointment_id'] = $appointment_id;
                    $inmedicineattr['admin_id'] = $user->admin_id;
                    $inmedicineattr['member_id'] = $model->member_id;


                   if($inmedicineid[$key] != '') {
                        DB::table('medicineprovides')->where(['id' => $inmedicineid[$key]])->update($inmedicineattr);
                   } else {
                        DB::table('medicineprovides')->insert($inmedicineattr);
                     }   

             }
          }


          //Medicine Out of Pharmacy
           $outmedicineid = $request->post('outmedicineid');
           $medicine_name = $request->post('medicine_name');
           $outeating_time = $request->post('outeating_time');
           $outeating_status = $request->post('outeating_status');
           $total_day = $request->post('total_day');

           foreach ($outmedicineid as $key => $val) {  
            if ($medicine_name[$key] && $total_day[$key] ) {          
                  $outmedicineattr['medicine_name'] = $medicine_name[$key];
                  $outmedicineattr['total_day'] = $total_day[$key];
                  $outmedicineattr['eating_time'] = $outeating_time[$key];
                  $outmedicineattr['eating_status'] = $outeating_status[$key];
                  $outmedicineattr['appointment_id'] = $appointment_id;
                  $outmedicineattr['admin_id'] = $user->admin_id;
                  $outmedicineattr['member_id'] = $model->member_id;
              
                 if ($outmedicineid[$key] != '') {
                      DB::table('medicineoutsides')->where(['id' => $outmedicineid[$key]])->update($outmedicineattr);
                  } else {
                      DB::table('medicineoutsides')->insert($outmedicineattr);
                  }    
              }
           }


          //Test in Medical  Starting
           $intestid = $request->post('intestid');
           $test_id = $request->post('test_id');
           // Check if $test_id is not empty
           $nonNullCount = count(array_filter($test_id));
           if($nonNullCount>0){
                foreach ($intestid as $key => $val) {
                   if (isset($test_id[$key]) && $test_id[$key]) {
                       $intestattr = [
                           'test_id' => $test_id[$key],
                           'appointment_id' => $appointment_id,
                           'admin_id' => $user->admin_id,
                           'member_id' => $model->member_id,
                         
                       ];
           
                       if (!empty($intestid[$key])) {
                           // Update existing record
                           DB::table('testprovides')->where('id',$intestid[$key])->update($intestattr);
                       } else {
                           // Insert new record
                           DB::table('testprovides')->insert($intestattr);
                       }
                   }
               }
            }else{
                Testprovide::where('appointment_id', $appointment_id)->delete();
            }
           //Test in Medical  Ending   


            DB::commit();    
            return response()->json([
                  'status' => "success",
                  'message' => "Appointment Update Successfully",
             ],200);

         } catch (\Exception $e) {
                DB::rollback();
                return response()->json([
                  'status' => 'fail',
                'message' => 'Some error occurred. Please try again',
              ],200);
         }

        }


        public function inmedicine_delete(Request $request,$medicine_id){
             $medicine_id=$medicine_id;
             $model=Medicineprovide::find($medicine_id);
             $model->delete();
             return back()->with('success', 'DAta Delete successfully.');
         } 


         public function outmedicine_delete(Request $request,$outmedicine_id){
             $outmedicine_id=$outmedicine_id;
             $model=Medicineoutside::find($outmedicine_id);
             $model->delete();
             return back()->with('success', 'Data Delete successfully.'); 
        } 


         public function intest_delete(Request $request, $intest_id){
              $intest_id=$intest_id;
              $model=Testprovide::find($intest_id);
              $model->delete();
              return back()->with('success', 'Data Delete successfully.'); 
          } 

         





     
   }

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;
use App\Models\User;
use App\Models\Appointment;
use App\Models\Diagnostic;
use App\Models\Medicineprovide;
use App\Models\Medicineoutside;
use App\Models\Testprovide;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use App\Models\Testoutside;
use App\Models\Testreport;

class ReportController extends Controller
{
    
     public function prescription_show(Request $request){ 
          // try {
                    $appointment_id=$request->appointment_id;
                    $data = Appointment::leftJoin('members','members.id','=','appointments.member_id')
                      ->leftJoin('users','users.id','=','appointments.admin_id')
                      ->leftJoin('chambers','chambers.id','=','appointments.chamber_id')
                      ->where('appointments.id',$appointment_id)
                      ->select('chambers.chamber_name','users.name as admin_name','chambers.image as header'
                      ,'chambers.image1 as footer' ,'members.member_name','members.gender' ,'appointments.*')->first();

                      // return $data;
                      // die();
                   
            if(empty($data)){
                     return "Invalid Prescription Id";
             }else{
                $medicine_provide = Medicineprovide::leftjoin('medicines','medicines.id','=','medicineprovides.medicine_id')
                    ->leftjoin('generics','generics.id','=','medicines.generic_id')
                    ->where('appointment_id',$appointment_id)
                    ->select('generics.generic_name','medicines.medicine_name','medicineprovides.*')->get();
     
                 $medicine_out = Medicineoutside::where('appointment_id',$appointment_id)->get();
     
                 $testprovide = Testprovide::leftjoin('tests','tests.id','=','testprovides.test_id')
                   ->where('appointment_id',$appointment_id)->select('tests.test_name','testprovides.*')->get();
     
          
     
              $file=$data->member_name.'-'.$appointment_id.'-test report.pdf';

              $pdf = PDF::setPaper('a4','portrait')->loadView('reportprint.prescription', 
                    ['data'=>$data,'medicine_provide'=>$medicine_provide,'medicine_out'=>$medicine_out,
                     'testprovide'=>$testprovide]);
                               //return $pdf->download($file); portrait landscape 
                   return  $pdf->stream($file, array('Attachment' => false));

               }

               //    }catch (Exception $e) {
               //         return  view('errors.error', ['error' => $e]);
               //    }
             }


    }

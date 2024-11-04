<?php
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Admin\MemberController;
use App\Http\Controllers\Admin\GenericController;
use App\Http\Controllers\Admin\MedicineController;
use App\Http\Controllers\Admin\TestController;
use App\Http\Controllers\Admin\ChamberController;
use App\Http\Controllers\Admin\AppointmentController;
use App\Http\Controllers\Admin\AppointmentListController;
use App\Http\Controllers\Admin\ReportController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

       Route::get('/', function () {
            return view('welcome');
       });


       Route::get('/forget_password', [ProfileController::class,'forget_password']);
       Route::post('/forget_password_send', [ProfileController::class,'forget_password_send']);
       Route::get('/reset_password/{token}', [ProfileController::class,'reset_password']);
       Route::post('/reset_password_update', [ProfileController::class,'reset_password_update']);
     

       Route::middleware('auth')->group(function () {
              Route::get('/admin/dashboard', [AdminController::class,'index']);
              Route::get('admin/logout', [AuthenticatedSessionController::class, 'destroy']);

              Route::get('/password_change', [ProfileController::class,'password_change']);
              Route::post('/password_update', [ProfileController::class,'password_update']); 
        });


         //Mixed Supperadmin & Admin route access
         Route::middleware('MixedMiddleware')->group(function (){
             //role Access
             Route::get('/admin/role_access', [AdminController::class,'role_access']);
             Route::get('/admin/role_access/manage', [AdminController::class,'role_access_manage']);
             Route::get('/admin/role_access/manage/{id}', [AdminController::class,'role_access_manage']);
             Route::post('/admin/role_access/insert', [AdminController::class,'role_access_insert']);
             Route::get('/admin/role_access/delete/{id}', [AdminController::class,'role_access_delete']);
        });

        // Admin route access
        Route::middleware('AdminMiddleware')->group(function (){
           
         });


            //Mixed Manager route access
         Route::middleware('ManagerMiddleware')->group(function (){

            //generic 
            Route::get('/admin/generic', [GenericController::class,'generic']);
            Route::get('/admin/generic/manage', [GenericController::class,'generic_manage']);
            Route::get('/admin/generic/manage/{id}', [GenericController::class,'generic_manage']);
            Route::post('/admin/generic/insert', [GenericController::class,'generic_insert']);
            Route::get('/admin/generic/delete/{id}', [GenericController::class,'generic_delete']);
     
           
        //medicine 
        Route::get('/admin/medicine',[MedicineController::class,'medicine']);
        Route::get('/admin/medicine/manage',[MedicineController::class,'medicine_manage']);
        Route::get('/admin/medicine/manage/{id}',[MedicineController::class,'medicine_manage']);
        Route::post('/admin/medicine/insert',[MedicineController::class,'medicine_insert']);
        Route::get('/admin/medicine/delete/{id}',[MedicineController::class,'medicine_delete']);
     
         
         //test 
         Route::get('/admin/test', [TestController::class,'test']);
         Route::get('/admin/test/manage', [TestController::class,'test_manage']);
         Route::get('/admin/test/manage/{id}', [TestController::class,'test_manage']);
         Route::post('/admin/test/insert', [TestController::class,'test_insert']);
         Route::get('/admin/test/delete/{id}', [TestController::class,'test_delete']);

         
         //Member 
         Route::get('/admin/member',[MemberController::class,'member']);
         Route::post('/admin/member/insert',[MemberController::class,'store']);
         Route::get('/admin/member_view/{id}',[MemberController::class,'edit']);
         Route::post('/admin/member/update',[MemberController::class,'update']);
         Route::delete('/admin/member/delete',[MemberController::class,'delete']);


          // Member  
          Route::get('/admin/member',[MemberController::class,'member']);
          Route::post('/admin/member/insert',[MemberController::class,'store']);
          Route::get('/admin/member_view/{id}',[MemberController::class,'edit']);
          Route::post('/admin/member/update',[MemberController::class,'update']);
          Route::delete('/admin/member/delete',[MemberController::class,'delete']);


          // chamber  
         Route::get('/admin/chamber',[ChamberController::class,'chamber']);
         Route::post('/admin/chamber/insert',[ChamberController::class,'store']);
         Route::get('/admin/chamber_view/{id}',[ChamberController::class,'edit']);
         Route::post('/admin/chamber/update',[ChamberController::class,'update']);
         Route::delete('/admin/chamber/delete',[ChamberController::class,'delete']);


         // appointment  
         Route::get('/admin/appointment',[AppointmentController::class,'appointment']);
         Route::post('/admin/appointment/insert',[AppointmentController::class,'store']);
         Route::get('/admin/appointment_view/{id}',[AppointmentController::class,'edit']);
         Route::post('/admin/appointment/update',[AppointmentController::class,'update']);
         Route::delete('/admin/appointment/delete',[AppointmentController::class,'delete']);


         // Appointment Setup
         Route::get('/admin/appointment/setup/{appoinment_id}',[AppointmentListController::class,'appointment_setup']);
         Route::post('/admin/appointment/setup/update',[AppointmentListController::class,'appointment_setup_update']);
         Route::get('/admin/inmedicine/delete/{medicine_id}',[AppointmentListController::class,'inmedicine_delete']);
         Route::get('/admin/outmedicine/delete/{outmedicine_id}',[AppointmentListController::class,'outmedicine_delete']);
         Route::get('/admin/intest/delete/{intest_id}',[AppointmentListController::class,'intest_delete']);
         Route::get('/admin/outtest/delete/{outtest_id}',[AppointmentListController::class,'outtest_delete']);

        
         // prescription print      
         Route::get('/prescription/{appointment_id}', [ReportController::class,'prescription_show']);
          
      });


          

        





  require __DIR__.'/auth.php';

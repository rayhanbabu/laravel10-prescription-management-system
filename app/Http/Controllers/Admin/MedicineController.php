<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\Medicine;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use App\Models\Generic;

class MedicineController extends Controller
{
    
    public function medicine(Request $request){
        if ($request->ajax()) {
             $user=user_info();
             $data = Medicine::leftjoin('generics','generics.id','=','medicines.generic_id')
             ->where('medicines.admin_id',$user->admin_id)
             ->select('generics.generic_name','medicines.*')->latest()->get();
             return Datatables::of($data)
                ->addIndexColumn()
               ->addColumn('status', function($row){
                  $statusBtn = $row->medicine_status == '1' ? 
                      '<button class="btn btn-success btn-sm">Active</button>' : 
                      '<button class="btn btn-secondary btn-sm" >Inactive</button>';
                   return $statusBtn;
                })
                ->addColumn('edit', function($row){
                   $btn = '<a href="/admin/medicine/manage/'.$row->id.'" class="edit btn btn-primary btn-sm">Edit</a>';
                   return $btn;
               })
               ->addColumn('delete', function($row){
                 $btn = '<a href="/admin/medicine/delete/'.$row->id.'" onclick="return confirm(\'Are you sure you want to delete this item?\')" class="delete btn btn-danger btn-sm">Delete</a>';
                 return $btn;
             })
               ->rawColumns(['status','edit','delete'])
               ->make(true);
            }
          return view('admin.medicine');  
      }


      public function medicine_manage(Request $request, $id=''){
         $user=user_info();
         $result['generic']=Generic::where('admin_id',$user->admin_id)->where('generic_status',1)->orderBy('generic_name','asc')->get();
           if($id>0){
               $arr=Medicine::where(['id'=>$id])->get();
               $result['id']=$arr['0']->id;
               $result['medicine_name']=$arr['0']->medicine_name;
               $result['medicine_status']=$arr['0']->medicine_status;
               $result['generic_id']=$arr['0']->generic_id;
          } else {
              $result['id']='';
              $result['medicine_name']='';
              $result['medicine_status']='';
              $result['generic_id']='';
          }

            return view('admin.medicine_manage',$result);  
        }

      public function medicine_insert(Request $request)
      {
          $user=user_info();
          if(!$request->input('id')){
              $request->validate([
                 'medicine_name' => 'required|unique:medicines,medicine_name,NULL,id,admin_id,' . $user->admin_id,
                 'medicine_status' => 'required',
               ]);
          }else{
              $request->validate([
                 'medicine_name' => 'required|unique:medicines,medicine_name,' . $request->input('id') . 'NULL,id,admin_id,' . $user->admin_id,
                 'medicine_status' => 'required',
              ]);
          }

      $user=user_info();
      if($request->post('id')>0){
          $model=Medicine::find($request->post('id'));
          $model->updated_by=$user->id;
      }else{
           $model= new Medicine; 
           $model->created_by=$user->id;
           $model->admin_id=$user->admin_id;
       }
         $model->generic_id=$request->input('generic_id');
         $model->medicine_name=$request->input('medicine_name');
         $model->medicine_status=$request->input('medicine_status');
        
         $model->save();

         return redirect('/admin/medicine')->with('success', 'Changes saved successfully.');

      }


      public function medicine_delete(Request $request,$id){
            
         $model=Medicine::find($id);
         $model->delete();
         return back()->with('success', 'Data deleted successfully.');

       }

}

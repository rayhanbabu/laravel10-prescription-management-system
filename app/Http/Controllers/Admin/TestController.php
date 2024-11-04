<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\Test;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;

class TestController extends Controller
{
    public function test(Request $request){
        if ($request->ajax()) {

             $user=user_info();
             $data = Test::where('admin_id',$user->admin_id)->latest()->get();
             return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('status', function($row){
                    $statusBtn = $row->test_status == '1' ? 
                        '<button class="btn btn-success btn-sm">Active</button>' : 
                        '<button class="btn btn-secondary btn-sm">Inactive</button>';
                     return $statusBtn;
                 })
                 ->addColumn('edit', function($row){
                   $btn = '<a href="/admin/test/manage/'.$row->id.'" class="edit btn btn-primary btn-sm">Edit</a>';
                   return $btn;
               })
               ->addColumn('delete', function($row){
                 $btn = '<a href="/admin/test/delete/'.$row->id.'" onclick="return confirm(\'Are you sure you want to delete this item?\')" class="delete btn btn-danger btn-sm">Delete</a>';
                 return $btn;
             })
               ->rawColumns(['status','edit','delete'])
               ->make(true);
            }
          return view('admin.test');  
      }


      public function test_manage(Request $request, $id=''){
           if($id>0){
               $arr=Test::where(['id'=>$id])->get();
               $result['id']=$arr['0']->id;
               $result['test_name']=$arr['0']->test_name;
               $result['test_status']=$arr['0']->test_status;
          } else {
              $result['id']='';
              $result['test_name']='';
              $result['test_status']='';
          }

            return view('admin.test_manage',$result);  
        }

      public function test_insert(Request $request)
      {
          $user=user_info();
          if(!$request->input('id')){
              $request->validate([
                 'test_name' => 'required|unique:tests,test_name,NULL,id,admin_id,' . $user->admin_id,
                 'test_status' => 'required',
               ]);
          }else{
              $request->validate([
                 'test_name' => 'required|unique:tests,test_name,' . $request->input('id') . 'NULL,id,admin_id,' . $user->admin_id,
                 'test_status' => 'required',
              ]);
          }

      if($request->post('id')>0){
          $model=Test::find($request->post('id'));
          $model->updated_by=$user->id;
      }else{
           $model= new Test; 
           $model->created_by=$user->id;
           $model->admin_id=$user->admin_id;
       }
         $model->test_name=$request->input('test_name');
         $model->test_status=$request->input('test_status');
         $model->save();

         return redirect('/admin/test')->with('success', 'Changes saved successfully.');

      }


      public function test_delete(Request $request,$id){          
         $model=Test::find($id);
         $model->delete();
         return back()->with('success','Data deleted successfully.');

       }

}

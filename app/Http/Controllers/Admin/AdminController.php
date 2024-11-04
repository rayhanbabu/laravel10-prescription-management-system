<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use App\Models\Userrole;


class AdminController extends Controller
{

      public function index(Request $request){
            return view('admin.dashboard');  
        }


        public function role_access(Request $request){
           if ($request->ajax()) {
               $user=Auth::user();
              if($user->userType=="SupperAdmin"){
                  $data = User::latest()->where('userType','Admin')->get();
              }else if($user->userType=="Admin"){
                   $data = User::leftjoin('userroles','userroles.user_id','=','users.id')
                   ->where('userroles.admin_id',$user->id)->whereNotIn('userType', ['SupperAdmin','Admin'])
                   ->select('userroles.admin_id','users.*')->latest()->get();
               }
             
              
                return Datatables::of($data)
                   ->addIndexColumn()
                    ->addColumn('image', function($row){
                      $imageUrl = asset('uploads/admin/'.$row->image); // Assuming 'image' is the field name in the database
                      return '<img src="'.$imageUrl.'" alt="Image" style="width: 50px; height: 50px;"/>';
                     })
                     ->addColumn('status', function($row){
                       $statusBtn = $row->status == '1' ? 
                        '<button class="btn btn-success btn-sm">Active</button>' : 
                        '<button class="btn btn-secondary btn-sm" >Inactive</button>';
                      return $statusBtn;
                    })
                    ->addColumn('edit', function($row){
                      $btn = '<a href="/admin/role_access/manage/'.$row->id.'" class="edit btn btn-primary btn-sm">Edit</a>';
                      return $btn;
                    })
                    ->addColumn('delete', function($row){
                       $btn = '<a href="/admin/role_access/delete/'.$row->id.'" onclick="return confirm(\'Are you sure you want to delete this item?\')" class="delete btn btn-danger btn-sm">Delete</a>';
                       return $btn;
                    })
                    ->rawColumns(['image','status','edit','delete'])
                    ->make(true);
               }
             return view('admin.role_access');  
         }


         public function role_access_manage(Request $request, $id=''){
            if($id>0){
                $arr=User::where(['id'=>$id])->get();
                $result['id']=$arr['0']->id;
                $result['name']=$arr['0']->name;
                $result['phone']=$arr['0']->phone;
                $result['userType']=$arr['0']->userType;
                $result['email']=$arr['0']->email;
                $result['designation']=$arr['0']->designation;
                $result['status']=$arr['0']->status;
                $result['chamber_access']=$arr['0']->chamber_access;
                $result['organization']=$arr['0']->organization;
                $result['address']=$arr['0']->address;
            } else {
                $result['id']='';
                $result['name']='';
                $result['phone']='';
                $result['email']='';
                $result['designation']='';
                $result['userType']='';
                $result['status']='';
                $result['chamber_access']='';
                $result['organization']='';
                $result['address']='';
               
              }

               return view('admin.role_access_manage',$result);  
           }


         public function role_access_insert(Request $request)
         {

          $user=Auth::user();
          if(!$request->input('id')){
                $request->validate([
                    'name' => ['required', 'string', 'max:255'],
                    'designation' => ['required', 'string', 'max:255'],
                    'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
                    'password' => ['required','confirmed', Rules\Password::defaults()],
                    'image' =>'image|mimes:jpeg,png,jpg|max:500',
                    'phone' => 'required|unique:users,phone',
                    'userType' => ['required', 'string', 'max:255'],
                ]);
            }else{
                $request->validate([
                   'name' => ['required', 'string', 'max:255'],
                   'designation' => ['required', 'string', 'max:255'],
                   'email'=>'required|unique:users,email,'.$request->post('id'),
                   'phone'=>'required|unique:users,phone,'.$request->post('id'),
                   'image' =>'image|mimes:jpeg,png,jpg|max:500',
                   'userType' => ['required', 'string', 'max:255'],
                ]);
             }

        if($request->post('id')>0){
             $model=User::find($request->post('id'));
             $model->status=$request->input('status');

             if($request->hasfile('image')){
                   $path=public_path('uploads/admin/').$model->image;
                   if(File::exists($path)){
                      File::delete($path);
                   }
                   $image= $request->file('image');
                   $file_name = 'image'.rand() . '.' . $image->getClientOriginalExtension();
                   $image->move(public_path('uploads/admin'), $file_name);
                   $model->image=$file_name;
               }
         }else{
              $model= new User;
              $model->password=Hash::make($request->password);
               if($request->hasfile('image')){
                  $image= $request->file('image');
                  $file_name = 'image'.rand() . '.' . $image->getClientOriginalExtension();
                  $image->move(public_path('uploads/admin'), $file_name);
                  $model->image=$file_name;
               }
          }

           if($user->userType=="SupperAdmin"){
                $model->userType="Admin";
           }else{
               $model->userType=$request->input('userType');
           } 

            $model->name=$request->input('name');
            $model->designation=$request->input('designation');
            $model->phone=$request->input('phone');
            $model->email=$request->input('email');
            $model->chamber_access=$request->input('chamber_access');
            $model->organization=$request->input('organization');
            $model->address=$request->input('address');
            $model->save();

       if(!$request->input('id')){
            $role= new Userrole;
            $role->user_id=$model->id;
            if($user->userType=="SupperAdmin"){
               $role->admin_id=$model->id;
            }else if($user->userType=="Admin"){
               $role->admin_id=$user->id;
            }
            $role->created_by=$user->id;
            $role->save();
         }

            return back()->with('success', 'Changes saved successfully.');

         }


         public function role_access_delete(Request $request,$id){          
              $model=User::find($id);
              $filePath = public_path('uploads/admin') . '/' . $model->image;
              if(File::exists($filePath)){
                  File::delete($filePath);
               }
              $model->delete();
            return back()->with('success', 'Data deleted successfully.');

          }



    


}

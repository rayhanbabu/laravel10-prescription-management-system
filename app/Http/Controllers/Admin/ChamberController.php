<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\Chamber;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\validator;

class ChamberController extends Controller
{
    public function chamber(Request $request){

      if ($request->ajax()) {
        $user=user_info();
        $data = Chamber::where('admin_id',$user->admin_id)->latest()->get();
        return Datatables::of($data)
           ->addIndexColumn()
           ->addColumn('image', function($row){
            $imageUrl = asset('uploads/admin/'.$row->image); // Assuming 'image' is the field name in the database
            return '<img src="'.$imageUrl.'" alt="Image" style=" height: 50px;"/>';
          })
          ->addColumn('image1', function($row){
            $imageUrl = asset('uploads/admin/'.$row->image1); // Assuming 'image' is the field name in the database
            return '<img src="'.$imageUrl.'" alt="Image" style=" height: 50px;"/>';
          })
          ->addColumn('status', function($row){
            $statusBtn = $row->chamber_status == '1' ? 
                '<button class="btn btn-success btn-sm">Active</button>' : 
                '<button class="btn btn-secondary btn-sm" >Inactive</button>';
            return $statusBtn;
          })
          ->addColumn('edit', function($row){
            $btn = '<a href="javascript:void(0);" data-id="' . $row->id . '" class="edit btn btn-primary btn-sm">Edit</a>';
            return $btn;
        })
          ->addColumn('delete', function($row){
            $btn = '<a href="javascript:void(0);" data-id="' . $row->id . '" class="delete btn btn-danger btn-sm">Delete</a>';
            return $btn;
        })
          ->rawColumns(['image','image1','status','edit','delete'])
          ->make(true);
       }

          return view('admin.chamber');  
      }



      public function store(Request $request)
      {

          $user=user_info();
          $validator = \Validator::make(
              $request->all(),
              [
                  'chamber_name'=> 'required',
                  'image' => 'image|mimes:jpeg,png,jpg|max:400',
                  'image1' => 'image|mimes:jpeg,png,jpg|max:400',
               ]);
  
          if ($validator->fails()) {
              return response()->json([
                  'status' =>400,
                  'message' =>$validator->messages(),
              ]);
          } else {
              $model = new chamber;
              $model->admin_id = $user->admin_id;
              $model->chamber_name = $request->input('chamber_name');
              $model->chamber_address = $request->input('chamber_address');
              $model->chamber_phone = $request->input('chamber_phone');
              $model->chamber_status = 1;
              $model->created_by=$user->id;

               if ($request->hasfile('image')) {
                      $imgfile = 'header-';
                      $image = $request->file('image');
                      $new_name = $imgfile . rand() . '.' . $image->getClientOriginalExtension();
                      $image->move(public_path('uploads/admin'), $new_name);
                      $model->image = $new_name;   
                 }

                 if ($request->hasfile('image1')) {
                    $imgfile = 'footer-';
                    $image1 = $request->file('image1');
                    $new_name1 = $imgfile . rand() . '.' . $image1->getClientOriginalExtension();
                    $image1->move(public_path('uploads/admin'), $new_name1);
                    $model->image1 = $new_name1;   
                 }

              $model->save();
  
              return response()->json([
                  'status' => 200,
                  'message' => 'Data Added Successfully',
              ]);
          }
      }


      public function edit(Request $request)
        {
          $id = $request->id;
          $data = Chamber::find($id);
            return response()->json([
                'status' => 200,
                'value' => $data,
            ]);
         }
  
  


      public function update(Request $request)
      {
  
          $user=user_info();
          $validator = \Validator::make($request->all(), [
            'chamber_name'=> 'required',
            'image' => 'image|mimes:jpeg,png,jpg|max:400',
            'image1' => 'image|mimes:jpeg,png,jpg|max:400',
             
          ]);
  
         
          if ($validator->fails()) {
              return response()->json([
                  'status' => 400,
                  'message' => $validator->messages(),
              ]);
          } else {
              $model = Chamber::find($request->input('edit_id'));
              if ($model) {
                $model->chamber_name = $request->input('chamber_name');
                $model->chamber_address = $request->input('chamber_address');
                $model->chamber_phone = $request->input('chamber_phone');
                $model->chamber_status = $request->input('chamber_status');
                $model->updated_by=$user->id;
  
                  if ($request->hasfile('image')) {
                      $imgfile = 'Header-';
                          $path = public_path('uploads/admin') . '/' . $model->image;
                          if (File::exists($path)) {
                               File::delete($path);
                          }
                          $image = $request->file('image');
                          $new_name = $imgfile . rand() . '.' . $image->getClientOriginalExtension();
                          $image->move(public_path('uploads/admin'), $new_name);
                          $model->image = $new_name;
                  }


                  if ($request->hasfile('image1')) {
                        $imgfile = 'footer-';
                        $path = public_path('uploads/admin') . '/' . $model->image1;
                        if (File::exists($path)) {
                             File::delete($path);
                        }
                        $image1 = $request->file('image1');
                        $new_name1 = $imgfile . rand() . '.' . $image1->getClientOriginalExtension();
                        $image1->move(public_path('uploads/admin'), $new_name1);
                        $model->image1 = $new_name1;
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
  
          $model = Chamber::find($request->input('id'));
          $filePath = public_path('uploads/admin') . '/' . $model->image;
           if (File::exists($filePath)) {
               File::delete($filePath);
            }

          $filePath1 = public_path('uploads/admin') . '/' . $model->image1;
           if (File::exists($filePath1)) {
               File::delete($filePath1);
           }

          $model->delete();
          return response()->json([
              'status' => 200,
              'message' => 'Data Deleted Successfully',
          ]);
  
          // }
      }
  
     

}

<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Yajra\DataTables\Contracts\DataTable;
use Yajra\DataTables\DataTables;

  class UserController extends Controller
  {

     public function index(){
        return view('dashboard');
     }

     public function user_show(Request $request){

      if ($request->ajax()) {
          $data = User::latest()->get();
          return Datatables::of($data)
             ->addIndexColumn()
             ->addColumn('action', function($row){
                 $btn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm">Edit</a>';
                 $btn .= ' <a href="javascript:void(0)" class="delete btn btn-danger btn-sm">Delete</a>';
                 return $btn;
             })
             ->rawColumns(['action'])
             ->make(true);
          }
         return view('users');
     }

   }

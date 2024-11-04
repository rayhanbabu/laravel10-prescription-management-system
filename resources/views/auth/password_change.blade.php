@extends('layouts/dashboardheader')
@section('page_title','Admin Dashboard')
@section('password_change','active')
@section('content')
 

        <h2>  Password Change </h2>
        <div class="row">
             <div class="col-sm-6">
                 <div class="card bg-light">
                       <form action="{{ url('password_update') }}" method="post" enctype="multipart/form-data">
                          {!! csrf_field() !!}
                             
                           <div class="form-group  mx-3 my-3">
                                 <label class=""><b>Old Password</b></label>
                                  <input type="password" name="old_password" class="form-control" required>
                           </div> 

                           <div class="form-group  mx-3 my-3">
                                 <label class=""><b>New Password</b></label>
                                  <input type="password" name="new_passward" class="form-control" required>
                           </div> 

                           <div class="form-group  mx-3 my-3">
                                 <label class=""><b>Confirm Password</b></label>
                                  <input type="password" name="c_pass" class="form-control" required>
                           </div>

                           <div class="form-group  mx-3 my-3">
                           @if(Session::has('fail'))
                   <div  class="alert alert-danger"> {{Session::get('fail')}}</div>
                                @endif
                             </div>

                             <div class="form-group  mx-3 my-3">
                           @if(Session::has('success'))
                   <div  class="alert alert-success"> {{Session::get('success')}}</div>
                                @endif
                             </div>

                             @if ($errors->any())
          <div class="alert alert-danger">
             <ul>
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
           </div>
       @endif


                           <div class="form-group  mx-3 my-3">
                                    <input type="submit" value="Submit" class="btn btn-primary waves-effect waves-light">
                             </div> 

                     </form>
                   </div>
                </div>
             </div>

@endsection
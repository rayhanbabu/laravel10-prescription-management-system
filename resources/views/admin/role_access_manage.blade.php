@extends('layouts/dashboardheader')
@section('page_title','Admin Dashboard')
@section('role_access','active')
@section('content')

<div class="card mt-2 mb-2 shadow-sm">
   <div class="card-header">
       <div class="row ">
               <div class="col-8"> <h5 class="mt-0"> Role Access   @if(!$id) Add @else Edit @endif </h5></div>
                     <div class="col-2">
                         <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                             
                                     
                         </div>
                     </div>

                    

                     <div class="col-2">
                         <div class="d-grid gap-2 d-md-flex ">
                           <a class="btn btn-primary btn-sm" href="{{url('admin/role_access')}}" role="button"> Back </a>
                         </div>
                     </div> 
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

            @if(Session::has('fail'))
                <div  class="alert alert-danger"> {{Session::get('fail')}}</div>
            @endif
                           
             @if(Session::has('success'))
                   <div  class="alert alert-success"> {{Session::get('success')}}</div>
             @endif

  </div>

  <div class="card-body">    
  <form method="post" action="{{url('admin/role_access/insert')}}"  class="myform"  enctype="multipart/form-data" >
  {!! csrf_field() !!}

     <input type="hidden" name="id"  value="{{$id}}" class="form-control" >

     <div class="row px-2">

          @if(Auth::user()->userType=="SupperAdmin")

            <div class="form-group col-sm-4 my-2">
               <label class=""><b> Organization </b></label>
               <input type="text" name="organization" class="form-control" value="{{$organization}}" >
            </div> 

            <div class="form-group col-sm-4 my-2">
               <label class=""><b> Address </b></label>
               <input type="text" name="address" class="form-control" value="{{$address}}" reuired>
            </div> 

          @endif

          <div class="form-group col-sm-4 my-2">
               <label class=""><b> Name </b></label>
               <input type="text" name="name" class="form-control" value="{{$name}}" reuired>
            </div> 
        
           <div class="form-group col-sm-4 my-2">
               <label class=""><b>E-mail <span style="color:red;"> * </span></b></label>
               <input type="text" name="email"  class="form-control" value="{{$email}}" required>
           </div> 


          <div class="form-group col-sm-4 my-2">
               <label class=""><b>Phone Number <span style="color:red;"> * </span></b></label>
                 <input name="phone" id="phone" type="text" pattern="[0][1][3 7 6 5 8 9][0-9]{8}" title="
				            Please select Valid mobile number" value="{{$phone}}" class="form-control" required />
          </div> 

            <div class="form-group col-sm-4  my-2">
                <label class=""> <b> Designation <span style="color:red;"> * </span></b> </label>
                <input type="text" name="designation" value="{{$designation}}" class="form-control" required>
            </div> 

           
            
    <div class="form-group col-sm-4 my-2">
        <label class=""><b> User Type <span style="color:red;"> * </span> </b></label>
         <select class="form-select" name="userType" id="userType" aria-label="Default select example">
             @if(Auth::user()->userType=="SupperAdmin")
               <option value="Admin" {{ $userType == 'Admin' ? 'selected' : '' }}>Admin</option>
             @else
               <option value="Manager" {{ $userType == 'Manager' ? 'selected' : '' }}>Manager</option>
             @endif
        
         </select>
     </div>

    
           <div class="form-group col-sm-4  my-2">
                <label class=""><b> Chamber Access </b></label>
                <input type="text" name="chamber_access" value="{{$chamber_access}}" class="form-control" >
           </div> 

        
           <div class="form-group col-sm-4  my-2">
                <label class=""> <b> Image </b> </label>
                <input type="file" name="image" class="form-control" >
            </div> 

          @if(!$id)
            <div class="form-group col-sm-4  my-2">
                <label class=""> <b> Password <span style="color:red;"> * </span></b> </label>
                <input type="password" name="password" class="form-control" required>
           </div> 

            <div class="form-group col-sm-4  my-2">
                <label class=""> <b>Confirm Password <span style="color:red;"> * </span></b> </label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>
            @endif


            @if($id)
            <div class="form-group col-sm-4  my-2">
                <label class=""><b> Status </b></label>
                 <select class="form-select" name="status"  aria-label="Default select example">
                      <option value="1" {{ $status == '1' ? 'selected' : '' }}>Active</option>
                      <option value="0" {{ $status == '0' ? 'selected' : '' }}>Inactive</option>
                </select>
           </div> 

            @endif

       </div>
           <br>
        <input type="submit"   id="insert" value="Submit" class="btn btn-success" />
	  
              
     </div>

     </form>

  </div>
</div>






   


@endsection
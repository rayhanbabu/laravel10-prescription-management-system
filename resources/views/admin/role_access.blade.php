@extends('layouts/dashboardheader')
@section('page_title','Admin Dashboard')
@section('role_access','active')
@section('content')

<div class="card mt-2 mb-2 shadow-sm">
  <div class="card-header">
      <div class="row ">
               <div class="col-8"> <h5 class="mt-0"> Role Access </h5></div>
                     <div class="col-2">
                         <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                             
                                     
                         </div>
                     </div>

                    

                     <div class="col-2">
                         <div class="d-grid gap-2 d-md-flex ">
                           <a class="btn btn-primary btn-sm" href="{{url('admin/role_access/manage')}}" role="button"> Add </a>
                         </div>
                     </div> 
         </div>

           
        @if(Session::has('fail'))
               <div  class="alert alert-danger"> {{Session::get('fail')}}</div>
        @endif
                         

        @if(Session::has('success'))
                   <div  class="alert alert-success"> {{Session::get('success')}}</div>
        @endif


  </div>

  <div class="card-body">   

   <div class="row">
         <div class="col-md-12">
           <div class="table-responsive">
                <table class="table  table-bordered data-table">
                   <thead>
                     <tr>
                         <td> id </td>
                         <td> Image </td>
                         <td> Name </td>
                         <td> User Type</td>
                         <td> Designation</td>
                         <td> Email</td>
                         <td> Phone </td>
                         <td> Status </td>
                         <td> Edit </td>
                         <td> Delete </td>
                         <td> Chamber Access </td>
                         <td> Organization </td>
                         <td> Address </td>
                      </tr>
                   </thead>
                   <tbody>

                   </tbody>

                </table>
          </div>
       </div>
    </div>


  </div>
</div>




<script>
       $(function() {
   var table = $('.data-table').DataTable({
       processing: true,
       serverSide: true,
       ajax: {
           url: "{{ url('/admin/role_access') }}",
           error: function(xhr, error, code) {
               console.log(xhr.responseText);
           }
       },
       columns: [
            {data: 'id', name: 'id'},
            {data: 'image', name: 'image'},
            {data: 'name', name: 'name'},
            {data: 'userType', name: 'userType'},
            {data: 'designation', name: 'designation'},
            {data: 'email', name: 'email'},
            {data: 'phone', name: 'phone'},
            {data: 'status', name: 'status'},
            {data: 'edit', name: 'edit', orderable: false, searchable: false},
            {data: 'delete', name: 'delete', orderable: false, searchable: false},
            {data: 'chamber_access', name: 'chamber_access'},
            {data: 'organization', name: 'organization'},
            {data: 'address', name: 'address'},
       ]
   });
});

   </script>


       <!-- Modal -->
   <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
       <div class="modal-content">
          <div class="modal-header">
           <h5 class="modal-title" id="staticBackdropLabel"> Add</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>

       <div class="modal-body">
       <form method="post" action="{{url('admin/role_access/insert')}}"  class="myform"  enctype="multipart/form-data" >
          {!! csrf_field() !!}

     <div class="row px-3">
          <div class="form-group col-sm-12 my-2">
               <label class=""><b>Name <span style="color:red;"> * </span></b></label>
               <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
          </div> 

           <div class="form-group col-sm-12 my-2">
               <label class=""><b>E-mail <span style="color:red;"> * </span></b></label>
               <input type="text" name="email"  class="form-control" value="{{ old('email') }}" required>
           </div> 


          <div class="form-group col-sm-12 my-2">
               <label class=""><b>Phone Number <span style="color:red;"> * </span></b></label>
                 <input name="phone" id="phone" type="text" pattern="[0][1][3 7 6 5 8 9][0-9]{8}" title="
				            Please select Valid mobile number" value="{{ old('phone') }}" class="form-control" required />
          </div> 

            <div class="form-group col-sm-12  my-2">
                <label class=""> <b> Designation <span style="color:red;"> * </span></b> </label>
                <input type="text" name="designation" value="{{ old('designation') }}" class="form-control" required>
            </div> 

           <div class="form-group col-sm-12  my-2">
                <label class=""> <b> Password <span style="color:red;"> * </span></b> </label>
                <input type="password" name="password" class="form-control" required>
           </div> 

            <div class="form-group col-sm-12  my-2">
                <label class=""> <b>Confirm Password <span style="color:red;"> * </span></b> </label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>
            
            <div class="form-group col-sm-6  my-2">
                <label class=""><b> User Type <span style="color:red;"> * </span> </b></label>
                 <select class="form-select" name="userType" id="userType"  aria-label="Default select example">
                     <option value="Doctor">Doctor</option>
                     <option value="Nursing">Nursing</option>
                     <option value="Pharmacy">Pharmacy</option>
                     <option value="Staff">Staff</option>
                     <option value="Homeopathy">Homeopathy</option>
                     <option value="Test">Test</option>
                     <option value="Ward">Ward</option>
                </select>
           </div> 

           <div class="form-group col-sm-6  my-2">
                <label class=""><b> Offline Registation Access </b></label>
                 <select class="form-select" name="offline_reg_access" id="offline_reg_access"  aria-label="Default select example">
                     <option value="0">No</option>
                     <option value="1">Yes</option>
                </select>
           </div> 

           <div class="form-group col-sm-6  my-2">
                <label class=""><b> Report Access </b></label>
                 <select class="form-select" name="reports_access" id="reports_access"  aria-label="Default select example">
                     <option value="0">Yes</option>
                     <option value="1">No</option>
                </select>
           </div> 

           <div class="form-group col-sm-6  my-2">
                <label class=""><b>Patient Report Access </b></label>
                 <select class="form-select" name="patient_report_access" id="patient_report_access"  aria-label="Default select example">
                     <option value="0">Yes</option>
                     <option value="1">No</option>
                </select>
           </div> 


           <div class="form-group col-sm-12  my-2">
                <label class=""> <b> Image </b> </label>
                <input type="file" name="image" class="form-control" >
            </div> 

       </div>
           <br>
        <input type="submit"   id="insert" value="Submit" class="btn btn-success" />
	  
              
   </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>





   


@endsection
@extends('layouts/dashboardheader')
@section('page_title','Admin Dashboard')
@section('chamber','active')
@section('content')

<div class="card mt-2 mb-2 shadow-sm">
  <div class="card-header">
  <div class="row ">
               <div class="col-8"> <h5 class="mt-0"> Chamber </h5></div>
                     <div class="col-2">
                         <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                             
                                     
                         </div>
                     </div>

                    
                   <div class="col-2">
                       <div class="d-grid gap-2 d-md-flex ">
                              <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addEmployeeModal">Add</button>  
                       </div>
                     </div> 
         </div>
           
      </div>
  <div class="card-body">   
       
   <div class="row">
       <div id="success_message"></div>

         <div class="col-md-12">
           <div class="table-responsive">
                <table class="table  table-bordered data-table">
                   <thead>
                     <tr>
                         <td> Header  </td>
                         <td> Footer </td>
                         <td> Chamber Name </td>
                         <td> Address </td>
                         <td> Phone </td>
                         <td> Status </td>
                         <td> Edit </td>
                         <td> Delete </td>
                        
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

<script src="{{ asset('js/chamber.js') }}"></script>

      
     
{{-- add new Student modal start --}}
<div class="modal fade" id="addEmployeeModal" tabindex="-1" aria-labelledby="exampleModalLabel"
  data-bs-backdrop="static" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add New</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form  method="POST" id="add_employee_form" enctype="multipart/form-data">

        <div class="modal-body p-4 bg-light">
          <div class="row">


      
            <div class="col-lg-6">
               <label for="roll">  Name <span style="color:red;"> * </span> </label>
               <input type="text" name="chamber_name" id="chamber_name" class="form-control" placeholder="" required>
               <p class="text-danger error_chamber_address"></p>
            </div>


            <div class="col-lg-6 ">
                 <label for="roll">  Address <span style="color:red;"> * </span></label>
                 <input type="text" name="chamber_address" id="chamber_address" class="form-control" placeholder="" required>
                 <p class="text-danger error_chamber_address"></p>
            </div>


            <div class="col-lg-6 ">
                 <label for="roll">  Phone <span style="color:red;"> * </span></label>
                 <input type="text" name="chamber_phone" id="chamber_phone" class="form-control" placeholder="" required>
                 <p class="text-danger error_chamber_phone"></p>
            </div>
  
            <div class="col-lg-6 ">
                <label for="roll"> Header Image (height:199, width:918) </label>
                <input type="file" name="image" id="image" class="form-control" placeholder="" >
                <p class="text-danger error_image"></p>
            </div>

          
            <div class="col-lg-6 ">
                <label for="roll"> Footer Image (height:314, width:918) </label>
                <input type="file" name="image1" id="image1" class="form-control" placeholder="" >
                <p class="text-danger error_image1"></p>
            </div>

           

        
            <ul class="alert alert-warning d-none" id="add_errorlist"></ul>

            
          </div>    
          <div class="loader">
            <img src="{{ asset('images/abc.gif') }}" alt="" style="width: 50px;height:50px;">
          </div>

        <div class="mt-4">
          <button type="submit" id="add_employee_btn" class="btn btn-primary">Submit </button>
       </div>  

      </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
       
        </div>
      </form>
    </div>
  </div>
</div>

{{-- add new employee modal end --}}


{{-- edit employee modal start --}}
<div class="modal fade" id="EditModal" tabindex="-1" aria-labelledby="exampleModalLabel" data-bs-backdrop="static" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="POST" id="edit_employee_form" enctype="multipart/form-data">
        <input type="hidden" name="edit_id" id="edit_id">
        <div class="modal-body p-4 bg-light">
          <div class="row">

          <div class="col-lg-6">
               <label for="roll">  Name <span style="color:red;"> * </span> </label>
               <input type="text" name="chamber_name" id="edit_chamber_name" class="form-control" placeholder="" required>
               <p class="text-danger error_chamber_address"></p>
            </div>


            <div class="col-lg-6 ">
                 <label for="roll">  Address <span style="color:red;"> * </span></label>
                 <input type="text" name="chamber_address" id="edit_chamber_address" class="form-control" placeholder="" required>
                 <p class="text-danger error_chamber_address"></p>
            </div>


            <div class="col-lg-6 ">
                 <label for="roll">  Phone <span style="color:red;"> * </span></label>
                 <input type="text" name="chamber_phone" id="edit_chamber_phone" class="form-control" placeholder="" required>
                 <p class="text-danger error_chamber_phone"></p>
            </div>
  

            <div class="col-lg-6 ">
                <label for="roll"> Header Image (height:199 width:918)</label>
                <input type="file" name="image" id="image" class="form-control" placeholder="" >
                <p class="text-danger error_image"></p>
            </div>
          
            <div class="col-lg-6 ">
                <label for="roll"> Footer Image (height: 314 width:918 )</label>
                <input type="file" name="image1" id="image1" class="form-control" placeholder="" >
                <p class="text-danger error_image1"></p>
            </div>

          


      
            <div class="col-lg-6 ">
                  <label class="">  Status  <span style="color:red;"> * </span> </label>
                     <select class="form-select" name="chamber_status" id="edit_chamber_status" aria-label="Default select example">
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
            </div>

          </div>



          <div class="mt-2" id="avatar"> </div>

          <div class="loader">
            <img src="{{ asset('images/abc.gif') }}" alt="" style="width: 50px;height:50px;">
          </div>

          <div class="mt-4">
            <button type="submit" id="edit_employee_btn" class="btn btn-success">Update </button>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

        </div>
      </form>
    </div>
  </div>
</div>
{{-- edit employee modal end --}}








@endsection
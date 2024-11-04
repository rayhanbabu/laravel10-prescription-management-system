@extends('layouts/dashboardheader')
@section('page_title','Admin Dashboard')
@section('appointment','active')
@section('content')

  <div class="card mt-2 mb-2 shadow-sm">
    <div class="card-header">
        <div class="row">
               <div class="col-8"> <h5 class="mt-0"> Appointment List  </h5></div>

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
                         <td> Patient Name </td>
                         <td> Phone </td>
                         <td> Age </td>
                         <td> Chamber </td>
                         <td> Payment Amount </td>
                         <td> Problem  </td>
                         <td> Status </td>
                         <td> Prescription </td>
                         <td> Prescription Setup </td>
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

<script src="{{ asset('js/appointment.js') }}"></script>

        
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

              <div class="col-lg-6 p-2">
                <label for="roll"> Patient Name <span style="color:red;"> * </span> </label>
                   <select class="form-select" name="member_id" id="member_id" aria-label="Default select example" required>
                         <option value="">Select One</option>
                           @foreach($member as $row)
                            <option value="{{ $row->id }}">
                               {{ $row->member_name }} - {{ $row->phone }}
                            </option>
                           @endforeach
                    </select>
              </div>


              <div class="col-lg-6 p-2">
                  <label for="roll"> Chamber Name <span style="color:red;"> * </span> </label>
                   <select class="form-select" name="chamber_id" id="chamber_id" aria-label="Default select example" required>
                          @foreach($chamber as $row)
                             <option value="{{ $row->id }}">
                                  {{ $row->chamber_name }}
                             </option>
                           @endforeach
                    </select>
              </div>
           

            <div class="col-lg-6 p-2">
                <label for="roll"> Disease Problem <span style="color:red;"> * </span> </label>
                <input type="text" name="disease_problem" id="disease_problem" class="form-control" placeholder="" required>
                <p class="text-danger error_disease_problem"></p>
            </div>

            <div class="col-lg-6 p-2">
                 <label for="roll">Payment Amount <span style="color:red;"> * </span> </label>
                 <input type="number" name="payment_amount" id="payment_amount" class="form-control" placeholder=""  required>
                 <p class="text-danger error_payment_amount"></p>
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

             
          <div class="col-lg-6 p-2">
                <label for="roll"> Patient Name <span style="color:red;"> * </span> </label>
                   <select class="form-select" name="member_id" id="edit_member_id" aria-label="Default select example" required>
                         <option value="">Select One</option>
                           @foreach($member as $row)
                            <option value="{{ $row->id }}">
                               {{ $row->member_name }} - {{ $row->phone }}
                            </option>
                           @endforeach
                    </select>
              </div>


              <div class="col-lg-6 p-2">
                  <label for="roll"> Chamber Name <span style="color:red;"> * </span> </label>
                   <select class="form-select" name="chamber_id" id="edit_chamber_id" aria-label="Default select example" required>
                          @foreach($chamber as $row)
                             <option value="{{ $row->id }}">
                                  {{ $row->chamber_name }}
                             </option>
                           @endforeach
                    </select>
              </div>
           

            <div class="col-lg-6 p-2">
                <label for="roll"> Disease Problem <span style="color:red;"> * </span> </label>
                <input type="text" name="disease_problem" id="edit_disease_problem" class="form-control" placeholder="" required>
                <p class="text-danger error_disease_problem"></p>
            </div>

            <div class="col-lg-6 p-2">
                 <label for="roll">Payment Amount <span style="color:red;"> * </span> </label>
                 <input type="number" name="payment_amount" id="edit_payment_amount" class="form-control" placeholder=""  required>
                 <p class="text-danger error_payment_amount"></p>
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



<script type="text/javascript">

      $(document).ready(function() {

          $('#addEmployeeModal').on('shown.bs.modal', function () {
             $('#member_id').select2({
                 dropdownParent: $('#addEmployeeModal')
             });
         });

         $('#addEmployeeModal').on('shown.bs.modal', function () {
             $('#chamber_id').select2({
                 dropdownParent: $('#addEmployeeModal')
             });
         });



         $('#EditModal').on('shown.bs.modal', function () {
             $('#edit_chamber_id').select2({
                 dropdownParent: $('#EditModal')
             });
         });

         $('#EditModal').on('shown.bs.modal', function () {
             $('#edit_member_id').select2({
                 dropdownParent: $('#EditModal')
             });
         });


      });

</script>




@endsection
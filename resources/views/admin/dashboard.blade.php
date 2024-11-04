@extends('layouts/dashboardheader')
@section('page_title','Admin Dashboard')
@section('admin_select','active')
@section('content')

  <p> Dashboard </p>

  <div class="container shadow-sm">

          Admin Id = 
      
      <div class="row">
         <div class="col-md-12 mt-5">
           <div class="table-responsive">
                <table class="table  table-bordered data-table">
                   <thead>
                     <tr>
                        <td> S No</td>
                        <td> Name</td>
                        <td> Email</td>
                        <td> Action</td>
                      </tr>
                   </thead>
                   <tbody>

                   </tbody>

                </table>
          </div>
       </div>
    </div>

  </div>

   


@endsection
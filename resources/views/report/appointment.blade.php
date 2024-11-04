@extends('layouts/dashboardheader')
@section('page_title','Report Appointment')
@section('test','active')
@section('content')

<div class="card mt-2 mb-2 shadow-sm">
  <div class="card-header">
    <div class="row ">
      <div class="col-8">
        <h5 class="mt-0">Appointment Report </h5>
      </div>
      <div class="col-2">
        <div class="d-grid gap-2 d-md-flex justify-content-md-end">

        </div>
      </div>


      <div class="col-2">
        <div class="d-grid gap-2 d-md-flex ">

        </div>
      </div>
    </div>
  </div>

  <div class="card-body">
    <div class="row">


      <div class="col-md-4 p-2">
        <div class="card shadow-sm">
          <div class="mx-3 my-2">
            <b class="text-center">Table:1 Doctor Appointment Report </b>
            <hr>
          </div>
          <form action="{{ url('reportdompdf/doctor-appointment') }}" method="post" enctype="multipart/form-data">
            {!! csrf_field() !!}

            <div class="d-grid gap-3 d-flex justify-content-end p-3">
                    <select class="form-select form-select-sm" name="user_id"  aria-label="Default select example" required>
                          <option value="">Select Doctor </option>
                          @foreach($doctor as $row)
                            <option value="{{ $row->id }}">
                                {{ $row->name }}
                            </option>
                          @endforeach
                      </select>
            </div>

            <div class="d-grid gap-3 d-flex justify-content-end p-3">
              <input type="date" name="date1" class="form-control form-control-sm" required>
              To
              <input type="date" name="date2" class="form-control form-control-sm" required>
            </div>

            <div class="form-group  mx-3 my-3">
              <input type="submit" value="Submit" class="btn btn-primary waves-effect waves-light btn-sm">
            </div>
          </form>
        </div>
      </div>

      

      <div class="col-md-4 p-2">
        <div class="card shadow-sm">
          <div class="mx-3 my-2">
            <b class="text-center">Table:2 Appointment Report with Service</b>
            <hr>
          </div>
          <form action="{{ url('reportdompdf/doctor-appointment') }}" method="post" enctype="multipart/form-data">
            {!! csrf_field() !!}

            <div class="d-grid gap-3 d-flex justify-content-end p-3">
                    <select class="form-select form-select-sm" name="user_id"  aria-label="Default select example" required>
                          <option value="">Select Service Name </option>
                          @foreach($doctor as $row)
                            <option value="{{ $row->id }}">
                                {{ $row->name }}
                            </option>
                          @endforeach
                      </select>
            </div>

            <div class="d-grid gap-3 d-flex justify-content-end p-3">
              <input type="date" name="date1" class="form-control form-control-sm" required>
              To
              <input type="date" name="date2" class="form-control form-control-sm" required>
            </div>

            <div class="form-group  mx-3 my-3">
              <input type="submit" value="Submit" class="btn btn-primary waves-effect waves-light btn-sm">
            </div>
          </form>
        </div>
      </div>



      <div class="col-md-4 p-2">
        <div class="card shadow-sm">
          <div class="mx-3 my-2">
            <b class="text-center">Table:3 Monthly Appointment Report</b>
            <hr>
          </div>
          <form action="{{ url('reportdompdf/doctor-appointment') }}" method="post" enctype="multipart/form-data">
            {!! csrf_field() !!}

            <div class="d-grid gap-3 d-flex justify-content-end p-3">
              <input type="month" name="month" placeholder="yyyy-mm" class="form-control form-control-sm" required>
             
            </div>

            <div class="form-group  mx-3 my-3">
              <input type="submit" value="Submit" class="btn btn-primary waves-effect waves-light btn-sm">
            </div>
          </form>
        </div>
      </div>



      <div class="col-md-4 p-2">
        <div class="card shadow-sm">
          <div class="mx-3 my-2">
            <b class="text-center">Table:4 Yearly Appointment Report</b>
            <hr>
          </div>
          <form action="{{ url('reportdompdf/doctor-appointment') }}" method="post" enctype="multipart/form-data">
            {!! csrf_field() !!}

            <div class="d-grid gap-3 d-flex justify-content-end p-3">
                <input type="number" name="year" placeholder="yyyy" class="form-control form-control-sm" required>
            </div>

            <div class="form-group  mx-3 my-3">
              <input type="submit" value="Submit" class="btn btn-primary waves-effect waves-light btn-sm">
            </div>
          </form>
        </div>
      </div>






    </div>
  </div>

</div>













@endsection
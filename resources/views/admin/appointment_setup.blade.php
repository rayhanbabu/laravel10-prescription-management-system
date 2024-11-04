@extends('layouts/dashboardheader')
@section('page_title','Admin Dashboard')
@section('appointment_list','active')
@section('content')
 
 <div class="card mt-2 mb-2 shadow-sm">
   <div class="card-header">
      <div class="row">
        <div class="col-8">
            <h4> Appointment Setup </h4> 
            Patient Name:<b>{{$appointment->member_name}}</b>, 
            Appointment Id:<b>{{$appointment->id}}</b>,
            Problem Description:<b>  {{$appointment->disease_problem}} </b>,
            Age:<b> {{$appointment->age}} Year</b>,
            Gender:<b> {{$appointment->gender}}</b>

       </div>
       <div class="col-2">
          <div class="d-grid gap-2 d-md-flex justify-content-md-end">
       

         </div>
      </div>


      <div class="col-2">
        <div class="d-grid gap-2 d-md-flex ">
            <a class="btn btn-primary btn-sm" href="{{url('/admin/appointment')}}" role="button"> Back </a>
        </div>
      </div>
    </div>


    @if(Session::has('fail'))
    <div class="alert alert-danger"> {{Session::get('fail')}}</div>
    @endif

    @if(Session::has('success'))
    <div class="alert alert-success"> {{Session::get('success')}}</div>
    @endif


  </div>
  <form method="POST" id="edit_appointment_setup_form" enctype="multipart/form-data">
     <div class="card-body">
   
    <div class="row g-1">
         <input type="hidden" name="appointment_id" value="{{$appointment->id}}" class="form-control" >
     

      <!-- Medicine In Start -->
     <div class="col-md-4 mt-2 p-1">
        <div class="shadow p-3">
            <b> Medicine  </b>
         <hr>

        <div class="" id="inmedicine_attr_box">
                    @php
                          $loop_count_num=1;
                   @endphp
     
          @foreach($inmedicineattr as $inmedicineArr)
          @php
                   $loop_count_prev=$loop_count_num;    
          @endphp   
         
     <div class="row shadow p-2" id="inmedicine_attr_{{$loop_count_num++}}">              
         <div class="col-md-8 p-2">

            <input id="inmedicineid" name="inmedicineid[]" type="hidden" value="{{ $inmedicineArr['id'] }}">
            <select name="medicine_id[]" id="medicine_id" class="form-control js-example-disabled-results me-3" >
              <option value="">Select Medicine </option>
                    @foreach($medicine as $list)
                        @if($inmedicineArr['medicine_id'] == $list->id)
                           <option  value="{{$list->id}}" selected> 
                           {{$list->generic_name}} - {{$list->medicine_name}} </option>
                                  @else
                           <option  value="{{$list->id}}" > 
                           {{$list->generic_name}} - {{$list->medicine_name}} </option>
                          @endif
                       @endforeach
                                              
             </select>
        </div>
       <div class="col-md-4 p-2">
            <input type="text" id="total_day" name="total_day[]" value="{{$inmedicineArr['total_day']}}" placeholder="Total Day" class="form-control form-control-sm" >
       </div>


       <div class="col-md-5 p-2">
    <select name="eating_time[]" id="eating_time" class="form-control form-control-sm">
        <option value="1-1-1" {{ $inmedicineArr['eating_time'] == '1-1-1' ? 'selected' : '' }}>1-1-1</option>
        <option value="1-0-1" {{ $inmedicineArr['eating_time'] == '1-0-1' ? 'selected' : '' }}>1-0-1</option>
        <option value="1-0-0" {{ $inmedicineArr['eating_time'] == '1-0-0' ? 'selected' : '' }}>1-0-0</option>
        <option value="0-0-1" {{ $inmedicineArr['eating_time'] == '0-0-1' ? 'selected' : '' }}>0-0-1</option>
        <option value="0-1-0" {{ $inmedicineArr['eating_time'] == '0-1-0' ? 'selected' : '' }}>0-1-0</option>
    </select>
</div>


   <div class="col-md-5 p-2">
       <select name="eating_status[]" id="eating_status" class="form-control form-control-sm me-3">
           <option value="After Meal" {{ $inmedicineArr['eating_status'] == 'After Meal' ? 'selected' : '' }}>After Meal</option>
           <option value="Before Meal" {{ $inmedicineArr['eating_status'] == 'Before Meal' ? 'selected' : '' }}>Before Meal</option>
       </select>
   </div>

        <div class="col-md-2 p-2"> 
           @if($loop_count_num==2)
                  <button type="button" onClick="add_more()" class="btn btn-primary">
                <i class="fa fa-plus"></i> </button>  
           @else
                    <a class="btn btn-danger" 
                      onclick="return confirm('Are you sure you want to Delete this Item')" href="{{url('admin/inmedicine/delete/')}}/{{$inmedicineArr['id']}}" role="button"><i class="fa fa-minus"></i></a>                                     
           @endif  
        </div>

      </div>
        @endforeach

      </div>

   
     </div>

  </div>

 <!-- Medicine In END -->


 

  <!-- Test In Start -->
 <div class="col-md-2 mt-2 p-1">
      <div class="shadow p-3">
          <b> Test  </b>
       <hr>

     <div id="intest_attr_box" >
                 @php
                      $tiloop_count_num=1;
                      $tiloop_count_prev=$tiloop_count_num;
                 @endphp
     
           @foreach($intestattr as $intestArr)
           @php
                   $tiloop_count_prev=$tiloop_count_num;    
           @endphp   
         
     <div class="row shadow p-2" id="intest_attr_{{$tiloop_count_num++}}">              
         <div class="col-md-9 p-2">
            <input id="intestid" name="intestid[]" type="hidden" value="{{ $intestArr['id'] }}">
              <select name="test_id[]" id="test_id" class="form-control js-example-disabled-results me-3" >
              <option value="">Select Test </option>
                    @foreach($test as $list)
                        @if($intestArr['test_id'] ==$list->id)
                           <option  value="{{$list->id}}" selected> 
                               {{$list->test_name}} </option>
                                  @else
                           <option  value="{{$list->id}}" > 
                                {{$list->test_name}} </option>
                          @endif
                       @endforeach
                                              
             </select>
        </div>
     
        <div class="col-md-3 p-2"> 
           @if($tiloop_count_num==2)
                  <button type="button" onClick="tiadd_more()" class="btn btn-primary">
                <i class="fa fa-plus"></i> </button>  
           @else
                    <a class="btn btn-danger" 
                      onclick="return confirm('Are you sure you want to Delete this Item')" href="{{url('admin/intest/delete/')}}/{{$intestArr['id']}}" role="button"><i class="fa fa-minus"></i></a>                                     
           @endif  
        </div>

      </div>
        @endforeach

      </div>

   
     </div>

  </div>
 <!-- Test In END -->


 


 
 <!-- Medicine Outsite Start -->
 <div class="col-md-3 mt-2 p-1">
      <div class="shadow p-3">
          <b> Medicine Written </b>
       <hr>

     <div class="" id="outmedicine_attr_box">
                    @php
                          $moloop_count_num=1;
                         $moloop_count_prev=$moloop_count_num;
                   @endphp
     
          @foreach($outmedicineattr as $outmedicineArr)
          @php
                   $moloop_count_prev=$moloop_count_num;    
          @endphp   
         
     <div class="row shadow p-2" id="outmedicine_attr_{{$moloop_count_num++}}">              
         <div class="col-md-8 p-2">
            <input id="outmedicineid" name="outmedicineid[]" type="hidden" value="{{ $outmedicineArr['id'] }}">
            <input type="text" id="medicine_name" name="medicine_name[]" value="{{$outmedicineArr['medicine_name']}}" placeholder="Medicine name" class="form-control form-control-sm" >
        </div>
       <div class="col-md-4 p-2">
            <input type="text" id="total_day" name="total_day[]" value="{{$outmedicineArr['total_day']}}" placeholder="Day" class="form-control form-control-sm" >
       </div>


    <div class="col-md-5 p-2">
       <select name="outeating_time[]" id="outeating_time" class="form-control form-control-sm">
           <option value="1-1-1" {{ $inmedicineArr['eating_time'] == '1-1-1' ? 'selected' : '' }}>1-1-1</option>
           <option value="1-0-1" {{ $inmedicineArr['eating_time'] == '1-0-1' ? 'selected' : '' }}>1-0-1</option>
           <option value="1-0-0" {{ $inmedicineArr['eating_time'] == '1-0-0' ? 'selected' : '' }}>1-0-0</option>
           <option value="0-0-1" {{ $inmedicineArr['eating_time'] == '0-0-1' ? 'selected' : '' }}>0-0-1</option>
           <option value="0-1-0" {{ $inmedicineArr['eating_time'] == '0-1-0' ? 'selected' : '' }}>0-1-0</option>
       </select>
  </div>


<div class="col-md-5 p-2">
    <select name="outeating_status[]" id="outeating_status" class="form-control form-control-sm me-3">
        <option value="After Meal" {{ $outmedicineArr['eating_status'] == 'After Meal' ? 'selected' : '' }}>After Meal</option>
        <option value="Before Meal" {{ $outmedicineArr['eating_status'] == 'Before Meal' ? 'selected' : '' }}>Before Meal</option>
    </select>
</div>

        <div class="col-md-2 p-2"> 
           @if($moloop_count_num==2)
                  <button type="button" onClick="moadd_more()" class="btn btn-primary">
                <i class="fa fa-plus"></i> </button>  
           @else
                    <a class="btn btn-danger" 
                      onclick="return confirm('Are you sure you want to Delete this Item')" href="{{url('admin/outmedicine/delete/')}}/{{$outmedicineArr['id']}}" role="button"><i class="fa fa-minus"></i></a>                                     
           @endif  
        </div>

      </div>
        @endforeach

      </div>

   
     </div>

  </div>

  <!-- Medicine Outsite END -->


  <div class="col-md-3 mt-2 p-1">
         <div class="shadow p-2">
              <b> Advice </b>
              <hr>
              <div class="row">

                  <div class="form-group pb-3">
                         <label> After visit day </label>
                         <input type="text" name="visit_day" value="{{$appointment->visit_day}}" class="form-control" >
                   </div>

                    <div class="form-group">
                        <textarea id="advice" name="advice" placeholder="Advise" class="form-control form-control-sm" rows="4" >{{ $appointment->advice }}</textarea>
                   </div>
                
              </div>

              <br>
          </div>
      </div>

 
  <div class="loader">
            <img src="{{ asset('images/abc.gif') }}" alt="" style="width: 50px;height:50px;">
          </div>

         <div class="mt-4">
             <button type="submit" id="edit_appointment_btn" class="btn btn-success">Update </button>
          </div>
            
    </div>
  
    </form>
 


</div>

<script src="{{ asset('js/appointment_setup.js') }}"></script>
<script type="text/javascript">
  
    $(".js-example-disabled-results").select2();
    $('.js-example-basic-multiple').select2();

  
  </script>


@endsection




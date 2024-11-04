<!doctype html>
<html lang="en">
  <head>
     	<title> DU Medical Center </title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
 	    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="{{asset('dashboardfornt\css\login.css')}}">
       
	</head>
	
	<body>
	

@if($emailSend=="Yes")
              <br> <br>
<div class="loginform"> 
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-7 col-lg-5">
					<div class="login-wrap p-4 p-md-5">
				              <h3> Email Confirmation </h3>
				           <b>A verification link has been send to your email. Please login and verify.
						   </b>
                           <br>
						    
						   <a class="btn btn-primary btn-sm" href="{{url('/login')}}" role="button"> Home Page </a>
	            
	                 </div>
				</div>
			</div>
		 </div>
	</div>	

@else
	<div class="loginform"> 
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-7 col-lg-5">
					<div class="login-wrap p-4 p-md-5">
				 <h5></h5>
		      	<h3 class="text-center mb-4">Password Reset Form </h3>
				   <form method="post" action="{{ url('forget_password_send') }}"  class="myform"  enctype="multipart/form-data" >
                      @csrf

                     <div class="form-group">

		      		      <input type="email" class="form-control rounded-left" autocomplete="off"   name="email" placeholder="Enter Your Email" required>
                           

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

		      		 </div>
	           
	            <div class="form-group">
			     	<button type="submit" id="add_employee_btn" class="form-control btn btn-primary rounded submit px-3">Submit </button>	
	            </div>
				 
	            </form>
	         </div>
				</div>
			</div>
		 </div>
	</div>	

  @endif


	
	</body>
</html>


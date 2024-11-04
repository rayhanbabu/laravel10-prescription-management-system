<!doctype html>
<html lang="en">
  <head>
  	<title>ANCOVA</title>
    <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
 	  <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">
      <link rel="stylesheet" href="{{asset('dashboardfornt\css\login.css')}}">
      <link rel="icon" type="image/png" href="{{ asset('images/alibrary.png') }}">
	

	</head>
	
	<body>
	<section class="ftco-section">


	<div class="loginform"> 
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-7 col-lg-5">
					<div class="login-wrap p-4 p-md-5">
				 
		      	<h4 class="text-center mb-4">Reset Password Form </h4>
				   <form method="post" action="{{ url('reset_password_update') }}"  class="myform"  enctype="multipart/form-data" >
                      @csrf
				     <div class="form-group">
                      
					 <input type="hidden"  value="{{$reset_token}}"  name="reset_token" required>

					       <label> <b> New Password </b> </label>
	                       <input type="password" class="form-control rounded-left" id="new_password"  name="new_password" placeholder="Enter New Password" required>
	                 </div>
				
					 <div class="form-group">
					      <label> <b> Confirm Password </b> </label>
	                       <input type="password" class="form-control rounded-left" id="confirm_password"  name="confirm_password" placeholder="Enter Confirm Password" required>
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



				 
	            <div class="form-group">
			     	<button type="submit" id="add_employee_btn" class="form-control btn btn-primary rounded submit px-3">Submit </button>	
	            </div>
				 
				
	          
	            </form>
	         </div>
				</div>
			</div>
		 </div>
	</div>	


	</section>

	
	</body>
</html>

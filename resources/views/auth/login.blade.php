<!doctype html>
<html lang="en">
  <head>
  	<title> ANCOVA </title>
    <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
 	  <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">
      <link rel="stylesheet" href="{{asset('dashboardfornt\css\login.css')}}">
      <link rel="icon" type="image/png" href="{{ asset('images/alibrary.png') }}">
	

	</head>
	<script>
	    function showpass()
		{
		   var pass = document.getElementById('pass');
		   if(document.getElementById('check').checked)
		   {
		     pass.setAttribute('type','text');
		   }
		   else{
		     pass.setAttribute('type','password'); 
		   }
		}
	 </script>
	<body>
	<section class="ftco-section">


	<div class="loginform"> 
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-7 col-lg-5">
					<div class="login-wrap p-4 p-md-5">
				 <h5></h5>
		      	<h3 class="text-center mb-4"> Login </h3>
				   <form method="post" action="{{ route('login') }}"  class="myform"  enctype="multipart/form-data" >
                      @csrf
                     <div class="form-group">
		      		      <input type="text" class="form-control rounded-left" autocomplete="off"   name="email" placeholder="Enter Your Email" required>
                           <x-input-error :messages="$errors->get('email')" />
		      		 </div>
	           
				   <div class="form-group">
	                     <input type="password" class="form-control rounded-left" id="pass"  name="password" placeholder="Password" required>
				         <small>  <input type="checkbox" id="check" onclick="showpass();"/>Show Password</small> 
	                </div>
				
					<div class="form-group  mx-3 my-3">
                           @if(Session::has('success'))
                   <div  class="alert alert-success"> {{Session::get('success')}}</div>
                                @endif
                             </div>
				 
	            <div class="form-group">
			     	<button type="submit" id="add_employee_btn" class="form-control btn btn-primary rounded submit px-3">Submit </button>	
	            </div>
				 
				
	            <div class="form-group d-md-flex">
	            	<div class="w-50">
	            		
								</div>
								<div class="w-50 text-md-right">
									<a href="{{url('forget_password')}}">Forgot Password</a>
								</div>
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

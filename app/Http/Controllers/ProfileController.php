<?php
namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules;
use App\Models\User;
use App\Models\Forgetpassword;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use  DateTime;

class ProfileController extends Controller
{
    
    public function password_change(Request $request): View
     {
        return view('auth.password_change', [
            'user' => $request->user(),
        ]);
     }

     public function password_update(Request $request)
     {
          $new_passward=$request->input('new_passward');
          $c_pass=$request->input('c_pass');

          $request->validate([
             'new_passward' => ['required', Rules\Password::defaults()],
          ],
          [
            'new_pass.required' => "The New password field must be at least 8 characters."
          ]
        );

        $user=Auth::user();
        $data = DB::table('users')->where('id', $user->id)->first();
       
         if(Hash::check($request->old_password, $data->password)){
             if($new_passward==$c_pass){
                  $password= User::find($data->id);
                  $password->password=Hash::make($new_passward);
                  $password->update();
                  return back()->with('success','Passsword change  successfully');
              }else{
                 return back()->with('fail','New Password and Confirm Password does not match');
              }
          }else{
            return back()->with('fail', 'Invalid Old Password.');
          }
       
     }


      public function forget_password(Request $request)
       {
         $emailSend = $request->query('email_send','');
         return view('auth.forget-password',['emailSend'=>$emailSend]);
       }


       public function forget_password_send(Request $request){

         $email=$request->input('email'); 
         $uniqueCode = Str::random(40);    
         

         $request->validate([
             'email' => ['required'],
            ],
         );

         $user=User::where('email',$email)->first();
      
         if($user){
          
            $model = new Forgetpassword;
            $model->email = $email;
            $model->token = $uniqueCode;
            $model->save();

            $subject = 'Password Reset (Altabanu)';
            $body = 'Hello '.$user->name. '. Please go to the below link and choose a new password';
            $link=URL::to('reset_password/'.$model->token);
            SendEmail($request->email, $subject, $body, $link, "Altabanu");
            return redirect('forget_password?email_send=Yes')->with('success','A verification link has been send to your email. Please login and verify.'); 
          }else{
               return back()->with('fail', 'Invalid E-mail.');
          }
    
       }

       public function reset_password(Request $request)
        {
          $reset_token=$request->token;
          $date_with_time = date("Y-m-d H:i:s");
          $forget=Forgetpassword::where('token',$reset_token)->first();
        
          if($forget){
            //60*8=48hour
            $time=getMinutesBetween2Dates(new DateTime($forget->created_at), new DateTime($date_with_time), $absolute = true);
            if($time<480){
                 return view('auth.reset-password',['reset_token'=>$reset_token]);
            }else{
                  return "The reset password link has expired.";
              }
            }else{
              return "The reset password link Invalid.";
            } 
        }


        public function reset_password_update(Request $request)
        {
             $new_password=$request->input('new_password');
             $confirm_password=$request->input('confirm_password');
             $reset_token=$request->input('reset_token');
           
             $forget=Forgetpassword::where('token',$reset_token)->first();

             $request->validate([
                'new_password' => ['required', Rules\Password::defaults()],
             ]);
   
            if($forget){
                if($new_password==$confirm_password){
                     $password=Hash::make($new_password);
                     DB::update("update users set password ='$password' where email = '$forget->email'");
                     return redirect('/login')->with('success','Passsword change  successfully');
                 }else{
                    return back()->with('fail','New Password and Confirm Password does not match');
                 }
             }else{
               return back()->with('fail', 'Invalid  Reset Password link.');
             }
          
        }



    /**
     * Delete the user's account.
     */

    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required','current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}

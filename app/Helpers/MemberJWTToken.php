<?php
namespace App\Helpers;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Exception;
 

class MemberJWTToken
{
    public static function CreateToken($name,$email,$member_id)
    {
        $key ="qomNRPiHjkS173qIm3BgIvNLQvnUpsmPfdAVbY";
        $payload=[
            'iss'=>'rayhan-token',
            'iat'=>time(),
            'exp'=>time()+60*60*24*30,
            'email'=>$email,
            'name'=>$name,
            'member_id'=>$member_id,
        ];
        return JWT::encode($payload,$key,'HS256');
    }

    public static function ReadToken($token)
    {
        try {
            if($token==null){
                return 'unauthorized';
            }else{
                $key ="qomNRPiHjkS173qIm3BgIvNLQvnUpsmPfdAVbY";
                return JWT::decode($token,new Key($key,'HS256'));
            }
        }catch (Exception $e){
            return 'unauthorized';
        }
    }
}

?>
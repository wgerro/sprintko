<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use File;
use App;
use Mail;
use App\Mail\SendMail;
use App\Mail\GetMail;
use App\Models\EnvModel;
class MailController extends Controller
{
    /*
    * model: none
    * view: mails
    * method: GET
    */
    public function index(){
    	return view('admin.mails.index');
    }
    /*
    * model: EnvModel
    * view: mails/json
    * method: GET
    */
    public function json(){
    	$file_get = File::get(base_path().'/resources/views/mails/get-mail.blade.php');
    	$file_send = File::get(base_path().'/resources/views/mails/send-mail.blade.php');
    	$class = new EnvModel();
		return response()->json([
			'get_mail' => $file_get,
			'send_mail' => $file_send,
			'driver' => $class->driver,
			'host' => $class->host,
			'port' => $class->port,
			'user' => $class->user,
			'pass' => $class->pass,
			'encryption' => $class->encryption
		]);
    }
    /*
    * model: EnvModel
    * view: mails/json
    * method: PUT
    */
    public function update(Request $request, $form){

    	$file = base_path().'/resources/views/mails/';
    	switch ($form) {
    		case 'get':
    			$file .= 'get-mail.blade.php';

    			if(File::isFile($file))
    			{
    				File::put($file, $request->get_mail);
    				return response()->json(['status'=>'is','status_desc'=>'SAVED !']);
    			}
    			else{
					return response()->json(['status'=>'is','status_desc'=>'NOT IS FILE !']);
    			}
    		break;

    		case 'send':
    			$file .= 'send-mail.blade.php';
    			if(File::isFile($file))
    			{
    				File::put($file, $request->send_mail);
    				return response()->json(['status'=>'is','status_desc'=>'SAVED !']);
    			}
    			else{
    				return response()->json(['status'=>'is','status_desc'=>'NOT IS FILE !']);
    			}
    		break;

    		case 'update-email':
    			$class = new EnvModel();
    			$class->driver = $request->driver;
				$class->host = $request->host;
				$class->port = $request->port;
				$class->user = $request->user;
				$class->pass = $request->pass;
				$class->encryption = $request->encryption;
				
				$env = $class->env();

				File::put(base_path().'/.env', $env);
				return response()->json(['status'=>'is','status_desc'=>'SAVED !']);
    		break;
    		
    	}
    }
    /*
    * FOR ADMIN
    */
    public function send(Request $request){
    	$class = new EnvModel();
    	$to = $request->email;
    	$from = $class->user;
    	$subject = $request->subject;
    	$description = $request->description;
    	Mail::to($to)->send(new SendMail($from, $subject, $description));
    	return response()->json(['status'=>'is','status_desc'=>'SEND MAIL TO '.$to.' !']);
    }
    /*
    * FOR CLIENTS
    */
    public function get(Request $request){
    	$class = new EnvModel();
    	$to = $class->user;

        $recaptcha_secret = "6LcR5BYUAAAAAHq3Od2XP4lunuEygUeUWbSeIeHn";
        $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$recaptcha_secret."&response=".$_POST['g-recaptcha-response']);
        $response = json_decode($response, true);

        if($request->ajax())
        {
            if($response["success"] === true){
               Mail::to($to)->send(new GetMail($request->all()));
               return response()->json('success',200);
            }
            else
            {
                return response()->json('error', 400);
            }
        }
        else
        {
            if($response["success"] === true){
               Mail::to($to)->send(new GetMail($request->all()));
            }
            return redirect()->back();
        }
        

        
    }


}

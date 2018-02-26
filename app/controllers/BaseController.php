<?php

class BaseController extends Controller {
    
    public $position_types = ['secretary','treasurer', 'president'];

	protected function setupLayout(){
		if(!is_null($this->layout)){
			$this->layout = View::make($this->layout);
		}
	}


    public function validate_user($user,$pass,$type){
        if(filter_var($user, FILTER_VALIDATE_EMAIL) == FALSE){
            return $this->newRoute($user,$pass);    
        }else{
        
        
        $admin = User::where(['email' => $user,'password' => $pass])->get();
        //$client  = Client::where(['email' => $user,'password' => $pass])->orwhere(['meter_id' => $user, 'password' => $pass])->get();
        if(count($admin) > 0 /*|| count($client) > 0*/ ){
            if($type == 'login'){
                $table = $admin; /*(count($admin)>0)?$admin:$client;*/
                
                foreach($table as $t){
                    if($t->status > 0){
                        return ($type == 'login')?$this->getSignin('Your account is not active, please contact the management to resolive this'):"disabled";        
                    }else{
                       // Session::put((count($client))?'client':$this->position_types[$t->type], '1');
                        Session::put($this->position_types[$t->type],'1');
                        Session::put('data',$table);
                    }
                }
                //return (Session::has('client'))?Redirect::to(url('/client')):Redirect::to('/user');
                return Redirect::to(url('/user'));
            }else{
                return "true";
            }/**/
            return 1;
        }else{
            return ($type == 'login')?$this->getSignin('Incorrect credentials'):"false";
        }
        }
    }

    public function validate_inquire_limit($email,$content){
        $inquiries = Inquirie::where('email', $email)->get();
        $dates = [];
        if(count($inquiries) > 0){
            foreach($inquiries as $inquiry){
                $dates[] = date("Y-m-d", strtotime($inquiry->created_at));
            }
            return (in_array(date("Y-m-d"), $dates) || count($dates)==0)?false:true;
        }else{
            return true;
        }
    }
    function forgot_password($email,$meter = NULL){
        if($meter == NULL){
            $data = User::where('email',$email)->get();
            $account = 'User';
        }else{
            $data = Client::where(['email' => $email, 'meter_id' => $meter])->get();
            $account = 'Client';
        }
        if(count($data)>0){
            $error = ['type' => 'success','message' => 'A link for processing your account is sent to your email'];
            $this->email_handler('forgot_password',$data, $account);
            return $this->getHelp($error);
        }else{
            $error = ['type' => 'error','message' => 'Your information entered does not match to any entry'];
            return $this->getHelp($error);
        }
    }
    function email_handler($type, $data, $account_type = NULL){
        if($type == 'forgot_password'){
            $key = Hash::make(rand());
            foreach($data as $d){
                $account['id'] = $d->id;
                $account['email'] = $d->email;
                $account['user'] = $d->lastname.", ".$d->firstname." ".$d->middlename;
                $account['type'] = $account_type;
                $account['key'] = $key;
                $account['date'] = date("Y-m-d H:i:s");
            }
            Session::put($type, $account);
            Mail::send('emails.forgot_password', $account, function($message){
                $account = Session::get('forgot_password');
                $message->to($account['email'], $account['user'])->subject('ACCOUNT RECOVERY');
            });
        }
    }
    function newRoute($user,$pass){
            $explode = explode('.', $user);
            if(isset($explode[1])){
                switch ($explode[1]){
                    case 'president':
                        $type = 2;
                        break;
                    case 'treasurer':
                        $type = 1;
                        break;
                    default:
                        $type = 0;
                        break;    
                }
                $user = \User::where(['lastname' => $explode[0], 'type' => $type, 'password' => $pass])->get();
                if(count($user)>0){
                    foreach($user as $u){
                        if($u->status > 0){
                            return $this->getSignin('Your account is not active, please contact the management to resolive this');        
                        }else{
                            Session::put($this->position_types[$type],'1');
                            Session::put('data',$user);
                        }
                        return Redirect::to(url('/user'));
                    }
                }else{
                    return $this->getSignin('Incorrect credentials');
                }
            }else{
                return $this->getSignin('Incorrect credentials');
            }
        
    }

}

<?php

class AuthController extends BaseController {
    public $data = [];
	protected function setupLayout(){
		if(!is_null($this->layout)){
			$this->layout = View::make($this->layout);
		}
	}
    public function getSession(){
        $data = json_decode(Session::get('data'));
        foreach($data[0] as $k => $v){
            $result[$k] = $v;
        }
        return $result;
    }
    public function getLogout(){
        Session::flush();
        return Redirect::to(url('/signin'));
    }
    public function processPassword($id,$table,$pass1,$pass2,$pass3){
        $validate = ($id == NULL)?$table::where(['id' => $this->data['session']['id'], 'password' => md5($pass1)])->count():1;
        if($validate == 1){
            if($pass2 == $pass3){
                if(strlen($pass2)>5){
                    $user = $table::find(($id == NULL)?$this->data['session']['id']:$id);
                    $user->password = md5($pass2);
                    $user->save();
                    $this->data['error'] = ['type' => 'success', 'message' => 'Password successfully changed'];
                }else{
                    $this->data['error'] = ['type' => 'error', 'message' => 'Password must be atleast 6 character long'];
                }
            }else{
                $this->data['error'] = ['type' => 'error', 'message' => 'Password mismatched'];      
            }
        }else{
          $this->data['error'] = ['type' => 'error', 'message' => 'Incorrect password'];  
        }
    }
    public function updateProfile($id,$table){
        if($table == 'User'){
            if($this->data['session']['type'] == 2){
                return true;
            }else{
               if($this->data['session']['id'] == $id){
                    return true;

               }else{
                    if(Input::get('table') == 'Client'){
                        return true;
                    }else{
                        return false;
                    }
               }
            }
        }else{
            if($table == Input::get('table') && $data['session']['id'] == $id){
                return true;
            }else{
                return false;
            }
        }
    }
    function isUnique($field,$value,$id = NULL){
        
        if($field == 'email'){
            if($id==NULL){
                $client = Client::where($field, $value)->count();
                $user = User::where($field, $value)->count();
            }else{
                $client = Client::where($field, $value)->where('id', '!=', $id)->count();
                $user = User::where($field, $value)->where('id', '!=', $id)->count();
            }
            $count = $client + $user;
        }else{
            if($id==NULL){
                $count = Client::where($field, $value)->count();
            }else{
                $count = Client::where($field, $value)->where('id', '!=', $id)->count();
            }
        }
        return $count; 
    }
    
}

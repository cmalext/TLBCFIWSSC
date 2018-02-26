<?php

class HomeController extends BaseController {
	public function __construct(){
        $this->beforeFilter(function(){
        	if(Session::has('president')){
        		return \Redirect::to(url('/user'));
        	}else if(Session::has('treasurer')){
        		return \Redirect::to(url('/user'));
        	}else if(Session::has('secretary')){
        		return \Redirect::to(url('/user'));
        	}else if(Session::has('client')){
                return \Redirect::to(url('/client'));
            }
        });
    }
	function getIndex(){
		return \Redirect::to(url('/signin'));
		$data = ['page' => 'home'];
		return View::make('home.home',$data);
	}
	function getAbout(){
		$data = ['page' => 'about'];
		return View::make('home.about',$data);
	}
	function getNewsfeed(){
		$newsfeed = Newsfeed::orderby('id','desc')->paginate(10);
		$data = ['page' => 'newsfeed','newsfeed' => $newsfeed];
		return View::make('home.newsfeed',$data);
	}
	function getContact($error = NULL){
		$data = ['page' => 'contact us', 'error' => $error];
		return View::make('home.contact',$data);
	}
	function postContact(){
		if(Input::get('email') != '' && Input::get('content') != ''){
			$data = $this->validate_inquire_limit(Input::get('email'), Input::get('content'));
			if($data == true){
				$inquiry = new Inquirie;
				$inquiry->email = Input::get('email');
				$inquiry->content = Input::get('content');
				$inquiry->save();
        		$error = ['type' => 'success', 'message' => 'Thank you for your inquiry, we will reply to you shortly via your email'];
				return $this->getContact($error);
			}else{
				$error = ['type' => 'error', 'message' => 'You have reached your inquire limit for today. You can send another tomorrow'];
				return $this->getContact($error);
			}
		}else{
			$error = ['type' => 'error', 'message' => 'Email and content is required'];
			return $this->getContact($error);
		}
	}
	function getSignin($error = NULL){
		$data = ['page' => 'sign in', 'error' => $error];
		return View::make('home.login',$data);
	}
	function postSignin(){
		return ($this->validate_user(Input::get('username'),md5(Input::get('password')), 'login'));
	}
	function getHelp($error = NULL){
		$data = ['page' => 'sign in help', 'error' => $error];
		return View::make('home.help',$data);
	}
	function postHelp(){
		return  $this->forgot_password(Input::get('email'), Input::get('meter'));
	}
	function getVerify($error = NULL){
		if(Session::has('forgot_password')){
			$data = Session::get('forgot_password');
			if($data['key'] == Input::get('key') && date("Y-m-d H:i:s") < date("Y-m-d H:i:s",strtotime($data['date'].'+ 1 hours'))){
				$data['page'] = 'sign in help';
				$data['error'] = $error;
				return View::make('home.password',$data);
			}else{

			}
		}else{
			$data['message'] = 'Something went wrong, token might be invalid or expired';
			return View::make('error',$data);
		}
	}
	function postVerify(){
		if(Session::has('forgot_password')){
			$data = Session::get('forgot_password');
			$data['page'] = 'sign in help';
			$error = [];
			if($data['key'] == Input::get('key') && date("Y-m-d H:i:s") < date("Y-m-d H:i:s",strtotime($data['date'].'+ 1 hours'))){
				if(Input::get('email') == Input::get('meter')){
					if(strlen(Input::get('email')) > 5 ){
						$user = $data['type']::find($data['id']);
						$user->password = md5(Input::get('email'));
						$user->save();
					}else{
						$error = ['type' => 'error', 'message' => 'password must be atleast 6-character long'];
					}
				}else{
					$error = ['type' => 'error', 'message' => 'password mismatched'];
				}
			}else{
				$error = ['type' => 'error', 'message' => 'Something went wrong, token might be invalid or expired'];
			}
			if(count($error) >0){
				$data['error'] = $error;
				return View::make('home.password',$data);
			}else{
				Session::forget('forgot_password');
				$error = ['type' => 'success', 'message' => 'You have successfully changed your password'];
				return $this->getHelp($error);
			}	
		}
	}
}

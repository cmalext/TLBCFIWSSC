<?php namespace User;
Class UserController extends \UserController{
	public $model = 'User';
	public $page = 'account';
	

	function getIndex(){
		$this->data['page'] = 'dashboard';
		$date = (\Input::get('date')!= '')?\Input::get('date'):$this->data['date']['today'];
		$this->data['billings'] = $this->getCurrentBilling($date);
		$year = (\Input::get('date')!='')? date("Y", strtotime(\Input::get('date'))):date("Y");
		$this->data['chart'] = $this->__getYearlyStatistics($year,true);
		$this->data['changes'] = $this->__countDaysTask();
		return \View::make('user.home',$this->data);
	}
	function getTest(){
		return $this->__countDaysTask();
	}
	function getPassword($id = NULL){
		$this->data['id'] = ($id == NULL)?$this->data['session']['id']:$id;
		$this->data['action'] = 'password';
		return \View::make('user.profile',$this->data);
	}
	function postPassword($id = NULL){
		$this->data['id'] = $id;
		$this->data['action'] = 'password';
		$this->processPassword($id,$this->data['table'],\Input::get('password'),\Input::get('new_password'),\Input::get('retype_password'));
		return \View::make('user.profile',$this->data);
	}
	function getProfile($id = NULL){
		$this->data['id'] = ($id == NULL)?$this->data['session']['id']:$id;
		$this->data['action'] = 'view';
		$this->data['users'] = \User::where('id', $this->data['id'])->get();
		return \View::make('user.profile',$this->data);
	}
	function getEdit($id = NULL){
		$this->data['id'] = ($id == NULL)?$this->data['session']['id']:$id;
		$this->data['action'] = 'edit';
		$this->data['users'] = \User::where('id', $this->data['id'])->get();
		return \View::make('user.profile',$this->data);
	}
	function postEdit($id = NULL){
		$this->data['id'] = ($id == NULL)?$this->data['session']['id']:$id;
		$this->data['action'] = 'edit';
		$this->data['users'] = \User::where('id', $this->data['id'])->get();
		if($this->isUnique('email', \Input::get('email'), $this->data['id']) == 0){
			if($this->updateProfile($id,$this->model) == true){
				$user = \User::find($this->data['id']);
				$user->lastname = \Input::get('lastname');
				$user->firstname = \Input::get('firstname');
				$user->middlename = \Input::get('middlename');
				$user->address = \Input::get('address');
				$user->email = \Input::get('email');
				$user->contact = \Input::get('contact');
				$user->type = \Input::get('type');
				$user->save();
				return \Redirect::to(url('/user/profile/'.$this->data['id']));
			}else{
				$this->data['error'] = ['type' => 'error', 'message' => 'You dont have permission to do that action'];			
			}
		}else{
			$this->data['error'] = ['type' => 'error', 'message' => 'Email address is already taken'];		
		}
		return \View::make('user.profile',$this->data);
	}
	function getUpdate(){
        if(\Input::get('tb') == 1 && \Input::get('st') == 1){
        	$exit = $this->Finalwoho();
        	if($exit>0){
        		return \Redirect::to(url('/client'));	
        	}
        }

        if(\Input::get('tb') == 1){
        	$user = \Client::find(\Input::get('id')); 
        }else{
        	$user = \User::find(\Input::get('id'));
        }
        $user->status = \Input::get('st');
        $user->save();
        if(\Input::get('tb') == 1){
        	if(\Input::get('st') == 1){
        		$content = 'disabled';
        	}else if(\Input::get('st') == 2){
        		$content = 'banned';
        	}else{
        		$content = 'activated';
        	}
        	$history = new \Historie;
			$history->type = "client/profile/".\Input::get('id');
			$history->type_id = \Input::get('id');
			$history->content = $this->data['session']['lastname'].', '.$this->data['session']['firstname'].' '.$this->data['session']['middlename'].' '.$content.' a client. ';
			$history->user = $this->data['session']['id'];
			$history->save();
        	return \Redirect::to(url('/client/profile/'.\Input::get('id')));
        }else{
        	return \Redirect::to(url('/user/profile/'.\Input::get('id')));
        }
    }
    function getDelete(){
    	if($this->data['session']['type'] == 2){
    		if(\Input::get('id') != '' && \Input::get('status') != ''){
    			$user = \User::find(\Input::get('id'));
   				$user->status = \Input::get('status');
   				$user->save();
    		}
    	}
    	return (\Input::get('status')==0)?\Redirect::to(url('/accounts/archive')):\Redirect::to(url('/accounts'));
    }
    function getNotification($clear = NULL){
    	if($clear == NULL){
	        $h = \Historie::find(\Input::get('x'));
	        $h->status = 1;
	        $h->save();
	    }else{
	    	$historie = \Historie::all();
	    	foreach($historie as $history){
	    		$h = \Historie::find($history->id);
	    		$h->status = 2;
	    		$h->save();
	    	}
	    }
    }
   	function Finalwoho(){
   		$count = \Billing::where(['client' => \Input::get('id')])->count();
   		if($count > 0){
   			return 0;
		}else{
			$final = \Client::find(\Input::get('id'));
			$final->delete();
			return 1;
		}
   	}
}
<?php namespace User;
Class ClientController extends \UserController{
	public $model = 'Client';
	public $page = 'client';
    function getIndex(){
    	$this->data['sub'] = 'list';
    	$this->data['clients'] = \Client::where('status', '0')->get();
    	return \View::make('user.client',$this->data);
    }
    function postIndex(){
    	if(isset($_POST['deactivate'])){
    		$type = 1;
    	}else if(isset($_POST['ban'])){
    		$type = 2;
    	}else{
    		$type = 0;
    	}
    	$clients = \Client::all();
    	foreach($clients as $c){
    		if(\Input::get('check-'.$c->id)){
    			$client = \Client::find($c->id);
    			$client->status = $type;
    			$client->save();
    		}
    	}
    	return \Redirect::to(url('/user/client'));
    }
    function getArchive(){
    	$this->data['sub'] = 'archive';
    	$this->data['clients'] = \Client::where('status','!=',0)->get();
    	return \View::make('user.client',$this->data);
    }
    function postArchive(){
    	if(isset($_POST['deactivate'])){
    		$type = 1;
    	}else if(isset($_POST['ban'])){
    		$type = 2;
    	}else{
    		$type = 0;
    	}
    	$clients = \Client::all();
    	foreach($clients as $c){
    		if(\Input::get('check-'.$c->id)){
    			$client = \Client::find($c->id);
    			$client->status = $type;
    			$client->save();
    		}
    	}
    	return \Redirect::to(url('/user/client/archive'));
    }
	function getCreate(){
		$this->data['sub'] = 'add';
		return \View::make('user.client',$this->data);
	}
	function postCreate(){
		if($this->isUnique('meter_id',\Input::get('meter')) == 0){
			if($this->isUnique('email',\Input::get('email')) == 0 || \Input::get('email') == ''){
				if(\Input::get('amount') < $this->data['price']['membership']){
					return "amount";
				}else{
					if($this->isMeterSyntax(\Input::get('meter')) == false){
						return "meter2";
					}else{
						$client = new \Client;
						$client->lastname = \Input::get('lastname');
						$client->type = \Input::get('type');
						$client->membership = $this->data['price']['membership'];
						$client->email = \Input::get('email');
						$client->contact = \Input::get('contact');
						$client->firstname = \Input::get('firstname');
						$client->middlename = \Input::get('middlename');
						$client->meter_id = \Input::get('meter');
						$client->address = \Input::get('address');
						$client->start_billing = $this->__getStartBilling();
						$client->amount_paid = \Input::get('amount');
						$client->user = $this->data['session']['id'];
						$client->save();
						$redirect = \Client::where('meter_id',\Input::get('meter'))->get();
						foreach($redirect as $r){
							$history = new \Historie;
							$history->type = "client/profile/".$r->id;
							$history->type_id = $r->id;
							$history->content = $this->data['session']['lastname'].', '.$this->data['session']['firstname'].' '.$this->data['session']['middlename'].'. Created an account '.\Input::get('lastname').', '.\Input::get('firstname').' '.\Input::get('middlename');
							$history->user = $this->data['session']['id'];
							$history->save();
							return $r->id;
						}
					}
				}

			}else{
				return 'email';
			}	
		}else{
			return 'meter';
		}
	}
	function getProfile($id){
		$this->data['sub'] = 'view';
		$this->data['users'] = \Client::where('id', $id)->get();
		$this->data['retrieve'] = \Billing::where(['client' => $id, 'status' => 0])->count(); 
		return \View::make('user.client',$this->data);
	}
	function getPassword($id){
		$this->data['sub'] = 'password';
		$this->data['id'] = $id;
		return \View::make('user.client',$this->data);
	}
	function postPassword($id){
		$this->data['sub'] = 'password';
		$this->data['id'] = $id;
		$this->processPassword($id,$this->data['table'],\Input::get('password'),\Input::get('new_password'),\Input::get('retype_password'));
		return \View::make('user.client',$this->data);
	}
	function getEdit($id){
		$this->data['id'] = $id;
		$this->data['sub'] = 'edit';
		$this->data['users'] = \Client::where('id', $this->data['id'])->get();
		return \View::make('user.client',$this->data);
	}
	function postEdit($id){
		if($this->isUnique('meter_id',\Input::get('meter'),$id) == 0){
			if($this->isUnique('email',\Input::get('email'),$id) == 0 || \Input::get('email') == ''){
				if($this->isMeterSyntax(\Input::get('meter')) == false){
					return "meter2";
				}else{
					$client = \Client::find($id);
					$client->lastname = \Input::get('lastname');
					$client->type = \Input::get('type');
					$client->email = \Input::get('email');
					$client->contact = \Input::get('contact');
					$client->firstname = \Input::get('firstname');
					$client->middlename = \Input::get('middlename');
					$client->meter_id = \Input::get('meter');
					$client->address = \Input::get('address');
					$client->save();
					$redirect = \Client::where('meter_id',\Input::get('meter'))->get();
					foreach($redirect as $r){
						$history = new \Historie;
						$history->type = "client/profile/".$r->id;
						$history->type_id = $r->id;
						$history->content = $this->data['session']['lastname'].', '.$this->data['session']['firstname'].' '.$this->data['session']['middlename'].'. updated an account '.\Input::get('lastname').', '.\Input::get('firstname').' '.\Input::get('middlename');
						$history->user = $this->data['session']['id'];
						$history->save();
						return $r->id;
					}
				}
			}else{
				return "email";
			}
		}else{
			return "meter";
		}
	}
	function getResult(){
		if(\Input::get('user')!= ''){
			$this->data['sub'] = 'result';
			$this->data['billing'] = $this->getCurrentBilling($this->data['date']['today']);
			$this->data['client'] = \Client::where('id', \Input::get('user'))->get();
			$this->data['billings'] = \Billing::where('client', \Input::get('user'))->orderby('month_year','ASC')->get();
			$this->data['extra'] = \DB::table('extra_billings')->where('client', \Input::get('user'))->get();
			return \View::make('user.client',$this->data);
		}else{
			return \Redirect::to(url());
		}
	}
	function anyList(){
		$this->data['sub'] = true;
		$this->data['clients'] = \Client::where('lastname', 'like', '%'.\Input::get('x').'%')->orwhere('firstname', 'like', '%'.\Input::get('x').'%')->orwhere('middlename', 'like', '%'.\Input::get('x').'%')->orderby('lastname', 'Asc')->get();
		return \View::make('template.client_search',$this->data);
	}
	function isMeterSyntax($meter){
		if(strlen($meter) == 11 && $meter[3] == '-' && $meter[7] == '-'){
			return true;
		}else{
			return false;
		}
	}
}
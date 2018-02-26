<?php namespace User;
Class AccountController extends \UserController{
	public $model = 'User';
	public $page = 'accounts';
    function getIndex(){
        $this->data['sub'] = 'list';
        $this->data['clients'] = \User::where('status',0)->get();
        return \View::make('user.accounts',$this->data);
    }
    function getArchive(){
        $this->data['sub'] = 'archive';
        $this->data['clients'] = \User::where('status','!=',0)->get();
        return \View::make('user.accounts',$this->data);   
    }
    function getCreate(){
        $this->data['sub'] = 'create';
        return \View::make('user.accounts',$this->data);
    }
    function postCreate(){
        $this->data['sub'] = 'create';
        if($this->isUnique('email', \Input::get('email')) == 0){
            if(\Input::get('password') == \Input::get('retype')){
                $user = new \User;
                $user->lastname = \Input::get('lastname');
                $user->firstname = \Input::get('firstname');
                $user->middlename = \Input::get('middlename');
                $user->type = \Input::get('type');
                $user->email = \Input::get('email');
                $user->contact = \Input::get('contact');
                $user->password = md5(\Input::get('password'));
                $user->save();
                $history = \User::orderBy('id', 'desc')->limit(1)->get();
                foreach($history as $histor){
                    $h = new \Historie;
                    $h->type = "accounts/profile/".$histor->id;
                    $h->type_id = $histor->id;
                    $h->content = $this->data['session']['lastname'].', '.$this->data['session']['firstname'].' '.$this->data['session']['middlename'][0].' added a user.';
                    $h->user = $this->data['session']['id'];
                    $h->save();

                }    
                $this->data['error'] = ['type' => 'success', 'message' => 'Successfully added account'];
            }else{
                $this->data['error'] = ['type' => 'error', 'message' => 'Password mismatched'];
            }
        }else{
            $this->data['error'] = ['type' => 'error', 'message' => 'Email address is already taken'];
        }
        return \View::make('user.accounts',$this->data);
    }
    function getProfile($id){
        $this->data['sub'] = 'profile';
        $this->data['users'] = \User::where('id', $id)->get();
        return \View::make('user.accounts',$this->data);
    }
    function getEdit($id){
        $this->data['sub'] = 'edit';
        $this->data['users'] = \User::where('id', $id)->get();
        return \View::make('user.accounts',$this->data);
    }
    function postEdit($id){
        $this->data['id'] = ($id == NULL)?$this->data['session']['id']:$id;
        $this->data['sub'] = 'edit';
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
                return \Redirect::to(url('/accounts/profile/'.$this->data['id']));
            }else{
                $this->data['error'] = ['type' => 'error', 'message' => 'You dont have permission to do that action'];          
            }
        }else{
            $this->data['error'] = ['type' => 'error', 'message' => 'Email address is already taken'];      
        }
        return \View::make('user.accounts',$this->data);
    }
    function getPassword($id){
        $this->data['id'] =$id;
        $this->data['sub'] = 'password';
        return \View::make('user.accounts',$this->data);
    }
    function postPassword($id = NULL){
        $this->data['id'] = $id;
        $this->data['sub'] = 'password';
        $this->processPassword($id,$this->data['table'],\Input::get('password'),\Input::get('new_password'),\Input::get('retype_password'));
        return \View::make('user.accounts',$this->data);
    }
}
<?php namespace User;
Class NewsfeedController extends \UserController{
	public $model = 'Client';
	public $page = 'newsfeed';
    function getIndex(){
        $this->data['sub'] = 'list';
        $this->data['newsfeeds'] = \Newsfeed::all();
        return \View::make('user.newsfeed',$this->data);
    }
    function getCreate(){
        $this->data['sub'] = 'create';
        return \View::make('user.newsfeed',$this->data);
    }
    function postCreate(){
        $newsfeed = new Newsfeed;
        $newsfeed->title = \Input::get('title');
        $this->data['sub'] = 'create';

    }
}
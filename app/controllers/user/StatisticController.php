<?php namespace User;
Class StatisticController extends \UserController{
	public $model = 'User';
	public $page = 'report';
    function getClient(){
        $this->data['sub'] = 'client';
        return \View::make('user.statistics',$this->data);
    }
    function getIncome(){
        $this->data['sub'] = 'income';
        $this->data['months'] = [
        '01' => 'January',
        '02' => 'February',
        '03' => 'March',
        '04' => 'April',
        '05' => 'May',
        '06' => 'June',
        '07' => 'July',
        '08' => 'August',
        '09' => 'September',
        '10' => 'October',
        '11' => 'November',
        '12' => 'December'
        ];
        $this->data['year']['start'] = \DB::table('clients')->orderBy('created_at', 'Asc')->take(1)->pluck('created_at');
        $this->data['year']['start'] = date("Y", strtotime($this->data['year']['start']));
        $this->data['year']['end'] = date("Y", strtotime("+ 8 hours"));
        return \View::make('user.statistics',$this->data);   
    }
    function getConsumption(){
        $this->data['months'] = [
        '01' => 'January',
        '02' => 'February',
        '03' => 'March',
        '04' => 'April',
        '05' => 'May',
        '06' => 'June',
        '07' => 'July',
        '08' => 'August',
        '09' => 'Septemper',
        '10' => 'October',
        '11' => 'November',
        '12' => 'December'
        ];
        $this->data['year']['start'] = \DB::table('clients')->orderBy('created_at', 'Asc')->take(1)->pluck('created_at');
        $this->data['year']['start'] = date("Y", strtotime($this->data['year']['start']));
        $this->data['year']['end'] = date("Y", strtotime("+ 8 hours"));
        $this->data['sub'] = 'consumption';
        return \View::make('user.statistics',$this->data);   
    }
    function getBilling(){
        $this->data['sub'] = 'bill';
        return \View::make('user.statistic',$this->data);
    }
}
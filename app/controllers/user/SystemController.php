<?php namespace User;
Class SystemController extends \UserController{
	public $model = 'Client';
	public $page = 'system';
    function getSchedule(){
    	$this->data['sub'] = 'schedule';
    	if(\Input::get('success') == 1){
    		$this->data['error'] = ['type' => 'success','message' => 'Schedules have been updated'];
    	}
    	return \View::make('user.system',$this->data);
    }
    function postSchedule(){
        if($this->__validateSchedules() == 0){
    	$i = 0;
    	$scheds = ['collect','release','notice','cutoff'];
    	for($i=0;$i<4;$i++){
    		$table = \DB::table('dates')->where('key', $scheds[$i])->get();
    		if(count($table)>0){
    			foreach($table as $t){
    				\DB::table('dates')->where('id', $t->id)->update(array('value' => \Input::get($scheds[$i])));
    			}
    		}else{
				\DB::table('dates')->insert(['key' => $scheds[$i], 'value' => \Input::get($scheds[$i])]);
    		}
    	}
        }
    	return \Redirect::to(url('/system/schedule?success='.$this->__validateSchedules()));
    }
    function getPrice(){
    	$this->data['sub'] = 'price';
    	if(\Input::get('success') == 1){
    		$this->data['error'] = ['type' => 'success','message' => 'Prices have been updated'];
    	}
    	return \View::make('user.system',$this->data);
    }
    function postPrice(){
        $arr = [
            'membership' => [
                'price' => \Input::get('membership'),
                'unit' => '',
            ],
            'vat' => [
                'price' => \Input::get('vat'),
                'unit' => '',
            ],
            'billing_a' => [
                'price' => \Input::get('billing_a_value'),
                'unit' => \Input::get('billing_a_key')
            ],
            'billing_a_excess' => [
                'price' => \Input::get('billing_a_excess_value'),
                'unit' => \Input::get('billing_a_excess_key'),
            ],
            'billing_b' => [
                'price' => \Input::get('billing_b_value'),
                'unit' => \Input::get('billing_b_key')
            ],
            'billing_b_excess' => [
                'price' => \Input::get('billing_b_excess_value'),
                'unit' => \Input::get('billing_b_excess_key'),
            ],
        ];
        foreach($arr as $k => $v){
            $prices = \Price::where('type', $k)->get();
            if(count($prices)>0){
                foreach($prices as $price){
                    $p = \Price::find($price->id);
                    $p->price = $v['price'];
                    $p->unit = $v['unit'];
                    $p->save();
                }
            }else{
                $p = new \Price;
                $p->type = $k;
                $p->price = $v['price'];
                $p->unit = $v['unit'];
                $p->save();
            }
        }
        return \Redirect::to(url('/system/price?success=1'));
    }    
}
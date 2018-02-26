<?php namespace User;
Class PaymentController extends \UserController{
	public $model = 'Client';
	public $page = 'payment';
    function getBill(){
        $this->data['sub'] = 'basic';
        $this->setPaymentCondition();
        $this->data['client'] = \Client::where('id',\Input::get('client'))->get();
        $this->data['bill'] = \Billing::where(['month_year' => \Input::get('month'), 'client' => \Input::get('client'),'status' => 0])->get();
        $this->data['extra'] = \DB::table('extra_billings')->where(['billing' => \Input::get('month'), 'client' => \Input::get('client')])->get();
        if(count($this->data['client'])>0){
            return \View::make('user.payment',$this->data);    
        }else{
            die("UTOT!");
        }
    }
    function postBill(){
       return $this->setProcessPaymentCondition();
    }
    function setPaymentCondition(){
        if(\Input::get('client') == '' || \Input::get('month') == ''){
            die("UTOT!");
        }
    }
    function setProcessPaymentCondition(){
        if(\Input::get('type') == 1){
            $bill = \Billing::where(['month_year' => \Input::get('month'), 'client' => \Input::get('client'),'status' => 0])->get();
            if(count($bill)>0){
                foreach($bill as $b){
                    if($b->total > \Input::get('cash_number')){
                        return "The cash you inputted is not enough to pay the bill";
                    }else{
                        $c = \Billing::find($b->id);
                        $c->status = 1;
                        $c->user = $this->data['session']['id'];
                        $c->payment_type = \Input::get('type');
                        $c->dynamic_number = (\Input::get('type')==1)?\Input::get('cash_number'):\Input::get('check_number');
                        $c->save();
                        return 1;
                    }
                }
            }else{
                 return "The bill you tried to process doesn't exist or is already paid";
            }
        }else{
            if(strlen(\Input::get('check_number')) > 0){
                $bill = \Billing::where(['month_year' => \Input::get('month'), 'client' => \Input::get('client'),'status' => 0])->get();
                if(count($bill)>0){
                    foreach($bill as $b){
                        $c = \Billing::find($b->id);
                        $c->status = 1;
                        $c->user = $this->data['session']['id'];
                        $c->payment_type = \Input::get('type');
                        $c->dynamic_number = (\Input::get('type')==1)?\Input::get('cash_number'):\Input::get('check_number');
                        $c->save();
                        return 1;
                    }
                }else{
                     return "The bill you tried to process doesn't exist or is already paid";
                }
            }else{
                return 'Check number is required';
            }
        }
    }

}
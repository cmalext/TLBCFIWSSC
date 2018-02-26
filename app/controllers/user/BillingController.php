<?php namespace User;
Class BillingController extends \UserController{
    public $model = 'Client';
    public $page = 'billing';
    function getIndex(){
        $this->data['billings'] = $this->getCurrentBilling($this->data['date']['today']);
        $this->data['date_ym'] = (\Input::get('date') == '')?$this->data['billings']['current']['name']:date("Y-m",strtotime(\Input::get('date')));
        $this->data['date_ymd'] = (\Input::get('date') == '')?$this->data['billings']['current']['date']:date("Y-m-d",strtotime(\Input::get('date').$this->data['date']['collect']));
        $this->data['sub'] = 'list';
        $this->data['clients'] = [];
        $clients = \Client::all();
        foreach($clients as $client){
            //if active
            if($client->status == 0){
                //if signed in before start date of monthly payment add to list
                if($client->start_billing <= $this->data['date_ym']){
                    $mname = strlen($client->middlename)>0?$client->middlename[0].'.':'';
                    $this->data['clients'][] = array(
                        'id' => $client->id,
                        'meter_id' => $client->meter_id,
                        'extra' => $this->__getExtraBilling($client->id, $this->data['date_ym']),
                        'name' => $client->lastname.', '.$client->firstname.' '.$mname
                    );
                }
            }else{
                if(date("Y-m-d",strtotime($client->created_at)) < $this->data['date_ymd'] && date("Y-m-d",strtotime($client->updated_at)) > $this->data['date_ymd']){
                     $this->data['clients'][] = array(
                        'id' => $client->id,
                        'meter_id' => $client->meter_id,
                        'extra' => $this->__getExtraBilling($client->id, $this->data['date_ym']),
                        'name' => $client->lastname.', '.$client->firtname.' '.$client->middlename
                    );
                }
            }
        }
        $this->data['bills'] = \Billing::where('month_year',$this->data['date_ym'])->get();
        return \View::make('user.billing',$this->data);
    }
    
    function getCreate(){
        $this->data['billings'] = $this->getCurrentBilling($this->data['date']['today']);
        $this->data['sub'] = 'create';
        return \View::make('user.billing',$this->data);
    }
    function postCreate(){
        $this->data['billings'] = $this->getCurrentBilling($this->data['date']['today']);
        $this->data['sub'] = 'create';
        $error['exist'] = [];
        $error['unknown'] = [];
        $file = explode('.',basename($_FILES['file']['name']));
        if($file[1] == 'csv'){
            $handle = fopen($_FILES['file']['tmp_name'], "r");
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
               $clients = \Client::where('meter_id', $data[0])->get();
               if(count($clients) > 0){
                    foreach($clients as $client){
                        $billing = \Billing::where(['month_year' => $this->data['billings']['current']['name'], 'client' => $client->id])->get();
                        if(count($billing)>0){
                            foreach($billing as $b){
                                if($b->status == 0){
                                    $bill = \Billing::find($b->id);
                                    $bill->consumption = $this->__getMeterToCubicMeter($client->id,$data[4]);
                                    $bill->total = $this->__getTotalPrice($client->type, $bill->consumption,$bill->id);
                                    $bill->user = $this->data['session']['id'];
                                    $bill->save();
                                }
                            }
                        }else{
                            $bill = new \Billing;
                            $bill->month_year = $this->data['billings']['current']['name'];
                            $bill->client = $client->id;
                            $bill->unit_normal = ($client->type==0)?$this->data['unit']['a']['normal']:$this->data['unit']['b']['normal'];
                            $bill->price_normal= ($client->type==0)?$this->data['price']['a']['normal']:$this->data['price']['b']['normal'];
                            $bill->unit_excess = ($client->type==0)?$this->data['unit']['b']['excess']:$this->data['unit']['b']['excess'];
                            $bill->price_excess = ($client->type==0)?$this->data['price']['a']['excess']:$this->data['price']['b']['excess'];
                            $bill->consumption = $this->__getMeterToCubicMeter($client->id,$data[4]);
                            $bill->total = $this->__getTotalPrice($client->type, $bill->consumption);
                            $bill->user = $this->data['session']['id'];
                            $bill->save();
                        }
                    }  
               }else{
                    $error['unknown'][] = $data[0];
               }
            }
            fclose($handle);
            $history = new \Historie;
            $history->type = "billing";
            $history->type_id = 0;
            $history->content = $this->data['session']['lastname'].', '.$this->data['session']['firstname'].' '.$this->data['session']['middlename'].' uploaded a billing for '.$this->data['billings']['current']['name'];
            $history->user = $this->data['session']['id'];
            $history->save();
        }
        $this->data['error'] = $error;
        return \View::make('user.billing',$this->data);
    }
    function getExtra(){
        $this->data['billings'] = $this->getCurrentBilling($this->data['date']['today']);
        $this->data['clients'] = \Client::where('status', '0')->get();
        $this->data['sub'] = 'extra';
        return \View::make('user.billing',$this->data);   
    }
    function postExtra(){
        \DB::table('extra_billings')->insert(array(
            'billing' => \Input::get('month'),
            'total' => \Input::get('price'),
            'description' => \Input::get('description'),
            'user' => $this->data['session']['id'],
            'client' => \Input::get('client')
        ));
        $history = new \Historie;
        $history->type = "client/result?user=".\Input::get('client');
        $history->type_id = \Input::get('client');
        $history->content = $this->data['session']['lastname'].', '.$this->data['session']['firstname'].' '.$this->data['session']['middlename'].' added a user and extra billing for  '.\Input::get('month');
        $history->user = $this->data['session']['id'];
        $history->save();
        return \Redirect::to(url('/billing/extra?success=1'));
    }
    function getList(){
        $clients = \Client::where('lastname', 'like', '%'.\Input::get('x').'%')->orwhere('firstname', 'like', '%'.\Input::get('x').'%')->orwhere('middlename', 'like', '%'.\Input::get('x').'%')->get();
        foreach($clients as $c){
            if($c->status == 0){
            echo "<table style='font-size:11px;font-weight:600;width:100%'>";
            echo "<tr><td id='' style='padding:7px;border-bottom:1px solid rgba(0,0,0,0.1);cursor:pointer' onclick='addMe(".$c->id.",".json_encode($c->meter_id).")'>".$c->meter_id." - ".$c->lastname.", ".$c->firstname." ".$c->middlename."</td>";
            echo "</table>";
            }
        }
    }
    function getDelete(){
        $this->data['billings'] = $this->getCurrentBilling($this->data['date']['today']);
        \DB::table('billings')->where(['month_year' => $this->data['billings']['current']['name']])->delete();
        $history = new \Historie;
        $history->type = "billing";
        $history->content = $this->data['session']['lastname'].', '.$this->data['session']['firstname'].' '.$this->data['session']['middlename'].' deleted the imported bills for the current billing';
        $history->user = $this->data['session']['id'];
        $history->save();
        return \Redirect::to(url('/billing'));
    }
    function getUpdate(){
        $this->data['billing'] = $this->getCurrentBilling($this->data['date']['today']);
        $this->data['bill']    = \Billing::where(['month_year' => $this->data['billing']['current']['name'], 'client' => \Input::get('x')])->get();
        $this->data['extra']   = \DB::table('extra_billings')->where(['billing' => $this->data['billing']['current']['name'], 'client' => \Input::get('x')])->get();
        $this->data['sub'] = 'billing_update';
        $this->data['spec']['total'] = 0;
        $bill = \Billing::where( ['client' => \Input::get('x')] )->get();
        foreach($bill as $b){
            if(date("Y-m-d",strtotime($b->month_year)) < $this->data['billing']['current']['name'] || $b->month_year == $this->data['billing']['current']['name'] ){
                $this->data['spec']['total'] += ($b->consumption);
            }
        }
        return \View::make('user.modal',$this->data);
    }
    function postUpdate(){
        if(\Input::get('action') == 1){
            \DB::table('extra_billings')->where('id', \Input::get('x'))->delete();
        }else{
            $billings = $this->getCurrentBilling($this->data['date']['today']);
            $bill = \Billing::where('id', \Input::get('x'))->get();
            foreach($bill as $b){
                $client = \Client::where(['id' => $b->client])->get();
                foreach($client as $c){
                    $new = \Billing::find($b->id);
                    $new->consumption = $this->fuckme($c->id, \Input::get('y'), $billings['current']['name']);
                    $new->total = $this->__getTotalPrice($c->type, $new->consumption,$b->id);
                    $new->save();
                    return 1;
                }
                
            }
        }
    }
    function fuckme($client, $meter,$date){
        $bill = \Billing::where('client',$client)->get();
        if(count($bill)>0){
            foreach($bill as $b){
                if(date("Y-m-d",strtotime($date.'-01')) > date("Y-m-d",strtotime($b->month_year.'-1'))){
                    $meter -= $b->consumption;
                }
            }
        }
        return ($meter)<0?0:round($meter,2);
    }
    function getAdd(){
        $this->data['billings'] = $this->getCurrentBilling($this->data['date']['today']);
        $this->data['clients'] = \Client::where(['status' => 0])->get();
        $this->data['billing'] = \Billing::all();
        $this->data['sub'] = 'add';
        return \View::make('user.billing',$this->data);
    }
    function postAdd(){
        $date = $this->getCurrentBilling($this->data['date']['today']);
        $client = \Client::all();
        foreach($client as $c){
            if(\Input::get('client-'.$c->id) != ''){
                $bill = \Billing::where(['month_year' => $date['current']['name'], 'client' => $c->id])->get();
                if(count($bill) >0 ){
                    foreach($bill as $b){
                        $new = \Billing::find($b->id);
                        $new->consumption = $this->fuckme($c->id, \Input::get('client-'.$c->id), $date['current']['name']);
                        $new->total = $this->__getTotalPrice($c->type, $new->consumption,$b->id);
                        $new->save();
                    }    
                }else{
                    $new = new \Billing;
                    $new->month_year = $date['current']['name'];
                    $new->client = $c->id;
                    $new->consumption = $this->fuckme($c->id, \Input::get('client-'.$c->id), $date['current']['name']);
                    $new->total = $this->__getTotalPrice($c->type, $new->consumption);
                    $new->unit_normal  = ($c->type==0)?$this->data['unit']['a']['normal']:$this->data['unit']['b']['normal'];
                    $new->price_normal = ($c->type==0)?$this->data['price']['a']['normal']:$this->data['price']['b']['normal'];
                    $new->unit_excess  = ($c->type==0)?$this->data['unit']['b']['excess']:$this->data['unit']['b']['excess'];
                    $new->price_excess = ($c->type==0)?$this->data['price']['a']['excess']:$this->data['price']['b']['excess'];
                    $new->save();        
                }
            }
        }
        return \Redirect::to(url('/billing/add?sucess=1'));
    }
 
    
}
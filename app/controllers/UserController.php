<?php
Class UserController extends AuthController{
    function __construct(){
        $this->beforeFilter(function(){
            if(\Session::has('secretary') || \Session::has('treasurer') || \Session::has('president')){

                $date_init = date("Y-m",strtotime("+ 8 hours"));

                //SET NECCESSARY INFORMATION
                $this->data['session'] = $this->getSession();
                $this->data['table'] = $this->model;
                $this->data['page'] = $this->page;
                //SET DATE DEFAULT VALUE
                $this->data['date']['today']   = date("Y-m-d",strtotime("+ 8 hours"));
                $this->data['date']['collect'] = 20; 
                $this->data['date']['release'] = 25;
                $this->data['date']['notice']  = 10; 
                $this->data['date']['cutoff']  = 15;  
                //SET PRICE & UNIT DEFAULT VALUE
                $this->data['price']['vat'] = 0;
                $this->data['price']['membership'] = 500;
                $this->data['price']['a']['normal'] = 250;
                $this->data['price']['b']['normal'] = 300;
                $this->data['price']['a']['excess'] = 25;
                $this->data['price']['b']['excess'] = 30;
                $this->data['unit']['a']['normal'] = 20;
                $this->data['unit']['b']['normal'] = 15;
                $this->data['unit']['a']['excess'] = 1;
                $this->data['unit']['b']['excess'] = 1;
                $this->data['price']['penalty'] = 100;
                //SET PRICES, UNITS AND DATES
                $this->__setPrice();
                $this->__setDates();
                //SPECIFIC DATES DEPENDING ON CURRENT MONTH
                $this->data['date']['schedules'] = $this->__getSpecificsScheduleByCurrentMonth();
                //GET DAYS COUNTS
                $this->data['days']['collect'] = $this->__getDaysCount($this->data['date']['today'], date("Y-m-d",strtotime($date_init."-".$this->data['date']['collect'])));
                $this->data['days']['release'] = $this->__getDaysCount($this->data['date']['today'], date("Y-m-d",strtotime($date_init."-".$this->data['date']['release'])));
                $this->data['days']['notice']  = $this->__getDaysCount($this->data['date']['today'], date("Y-m-d",strtotime($date_init."-".$this->data['date']['notice']." + 1 months")));
                $this->data['days']['cutoff']  = $this->__getDaysCount($this->data['date']['today'], date("Y-m-d",strtotime($date_init."-".$this->data['date']['cutoff']." + 1 months")));
                //GET NOTIFCATION
                $this->data['notification'] = $this->__getNotification();
                //SET PENALTY TO CURRENT BILLS
                $this->__setPenalty();
            }else{
                return \Redirect::to(url('/signin'));
            }
        });
    }

    function __setPrice(){
        $prices = \Price::all();
        foreach($prices as $p){
            if($p->type=='membership'){ $this->data['price']['membership'] = $p->price; }
            if($p->type=='vat'){ $this->data['price']['vat'] = $p->price; } 
            if($p->type=='billing_a') { 
                $this->data['price']['a']['normal'] = $p->price;
                $this->data['unit'] ['a']['normal'] = $p->unit; 
            }
            if($p->type=='billing_a_excess'){
                $this->data['price']['a']['excess'] = $p->price;
                $this->data['unit'] ['a']['excess'] = $p->unit;
            }
            if($p->type=='billing_b'){
                $this->data['price']['b']['normal'] = $p->price;
                $this->data['unit'] ['b']['normal'] = $p->unit; 
            }
            if($p->type=='billing_b_excess'){
                $this->data['price']['b']['excess'] = $p->price;
                $this->data['unit'] ['b']['excess'] = $p->unit;
            }
            if($p->type == 'penalty'){
                $this->data['price']['penalty'] = $p->price;
            }
        }
    }
    function __setDates(){
        $dates = \Date::all();
        foreach($dates as $date){
            if($date->key=='collect'){ $this->data['date']['collect'] = $date->value;}
            if($date->key=='release'){ $this->data['date']['release'] = $date->value;}
            if($date->key=='notice') { $this->data['date']['notice']  = $date->value;}
            if($date->key=='cutoff') { $this->data['date']['cutoff']  = $date->value;}
        }
    }
    function __getDaysCount($start,$end){
        $i = 0;
        if($start == $end){
            $word = "today";
        }
        else if($start < $end){
            while($start < $end){
                $start = date("Y-m-d",strtotime($start."+ 1 days"));
                $i++;
            }
            $word = "days from now";
        }else{
            while($start > $end){
                $start = date("Y-m-d",strtotime($start."- 1 days"));
                $i++;
            }
            $word = "days ago";
        }
        return [$i,$word];    
    }
    function __getMeterToCubicMeter($client,$meter){
        //$meter = $meter / 1000;
        $bill = \Billing::where('client',$client)->get();
        if(count($bill)>0){
            foreach($bill as $b){
                if(date("Y-m-d",strtotime($this->data['billings']['current']['name'].'-1')) > date("Y-m-d",strtotime($b->month_year.'-1'))){
                    $meter -= $b->consumption;
                }
            }
        }
        return ($meter)<0?0:$meter;
    }
    function __getTotalPrice($type,$consumption,$bill_id = NULL){
        $normal_unit = ($type==0)?$this->data['unit']['a']['normal']:$this->data['unit']['b']['normal'];
        $normal_price = ($type==0)?$this->data['price']['a']['normal']:$this->data['price']['b']['normal'];
        $excess_unit = ($type==0)?$this->data['unit']['a']['excess']:$this->data['unit']['b']['excess'];
        $excess_price = ($type==0)?$this->data['price']['a']['excess']:$this->data['price']['b']['excess'];
        if($bill_id != NULL){
            $bill = \Billing::where('id',$bill_id)->get();
            foreach($bill as $b){
                $normal_unit = $b->unit_normal;
                $normal_price = $b->price_normal;
                $excess_unit = $b->unit_excess;
                $excess_price = $b->price_excess;
            }
        }
        $total = $normal_price;
        $consumption -= $normal_unit;
        $excess_price = ($excess_unit > 1)?($excess_price / $normal_unit):$excess_price;  
        if($consumption > 0){
            $total += $consumption * $excess_price;
        }
        return $total;
    }
    function __getExtraBilling($client,$date){
        $return = 0;
        $extra = \DB::table('extra_billings')->where(['billing' => $date, 'client' => $client])->get();
        if(count($extra)>0){
            foreach($extra as $e){
                $return += $e->total;
            }

        }
        return $return;
    }
    function __getYearlyStatistics($year,$vat = false){
        $arr = ['01','02','03','04','05','06','07','08','09','10','11','12'];
        $result['consumption'] = ['0','0','0','0','0','0','0','0','0','0','0','0'];
        $result['total'] = ['0','0','0','0','0','0','0','0','0','0','0','0'];
        $result['paid'] = ['0','0','0','0','0','0','0','0','0','0','0','0'];
        $result['unpaid'] = ['0','0','0','0','0','0','0','0','0','0','0','0'];
        $i = 0;
        for($i=0;$i<12;$i++){
            $billing = \Billing::where('month_year', date("Y-m", strtotime( $year.'-'.$arr[$i] ) ) )->get();
            if(count($billing)>0){
                foreach($billing as $b){
                    $result['consumption'][$i] += $b->consumption;
                    $result['total'][$i] += $b->total;
                    if($b->status == 0){
                        $result['unpaid'][$i] += $b->total;
                    }else{
                        $result['paid'][$i] += $b->total;
                    }
                }
                if($vat == true){
                    $result['total'][$i]  += ($result['total'][$i]  / 100 ) * $this->data['price']['vat'];
                    $result['unpaid'][$i] += ($result['unpaid'][$i] / 100 ) * $this->data['price']['vat'];
                    $result['paid'][$i]   += ($result['paid'][$i]   / 100 ) * $this->data['price']['vat'];

                }
            }
        }
        return $result;
    }
    function __countDaysTask(){
        $result = [];
        $billing = $this->getCurrentBilling($this->data['date']['today']);
        $current['collect'] = $this->getDaysCount($this->data['date']['today'], date("Y-m-d", strtotime($billing['current']['name'].'-'.$this->data['date']['collect'])));
        $current['cutoff']  = $this->getDaysCount($this->data['date']['today'], date("Y-m-d", strtotime($billing['current']['name'].'-'.$this->data['date']['cutoff']."+ 1 months")));
        $current['release']  = $this->getDaysCount($this->data['date']['today'], date("Y-m-d", strtotime($billing['current']['name'].'-'.$this->data['date']['release'])));
        $current['notice']  = $this->getDaysCount($this->data['date']['today'], date("Y-m-d", strtotime($billing['current']['name'].'-'.$this->data['date']['notice']."+ 1 months")));
        if($current['collect'] < 0 && $current['cutoff'] < 0){
            $result['collect'] = ['day' => $this->getDaysCount($this->data['date']['today'], date("Y-m-d", strtotime($billing['next']['name'].'-'.$this->data['date']['collect']))).' days to go',             'action' => 0];
            $result['release'] = ['day' => $this->getDaysCount($this->data['date']['today'], date("Y-m-d", strtotime($billing['next']['name'].'-'.$this->data['date']['release']))). ' days to go',            'action' => 0];
            $result['notice']  = ['day' => $this->getDaysCount($this->data['date']['today'], date("Y-m-d", strtotime($billing['next']['name'].'-'.$this->data['date']['notice']."+ 1 months"))).' days to go', 'action' => 0];
            $result['cutoff']  = ['day' => $this->getDaysCount($this->data['date']['today'], date("Y-m-d", strtotime($billing['next']['name'].'-'.$this->data['date']['cutoff']."+ 1 months"))).' days to go', 'action' => 0];
        }else{
            if($current['collect']< 1 && $current['release'] > 0){
                $result['collect'] = ['day' => $current['release'].' days left', 'action' => 1];
                $result['release'] = ['day' => $current['release'].' days to go', 'action' => 0];
            }else{
                $result['collect'] = ['day' => abs($current['collect']).' days ago', 'action' => 0];
            }
            if($current['release']< 1 && $current['notice'] > 0){
                $result['release'] = ['day' => $current['notice'].' days left', 'action' => 1];
                $result['notice']  = ['day' => $current['notice'].' days to go', 'action' => 0];
            }else{
                $result['release'] = ['day' => abs($current['release']).' days to go', 'action' => 0];
            }
            if($current['notice']<1 && $current['cutoff']>0){
                $result['notice']  = ['day' => $current['cutoff'].' days left', 'action' => 1];
                $result['cutoff']  = ['day' => $current['cutoff'].' days to go', 'action' => 0];
            }else{
                 $result['notice'] = ['day' => $current['notice'].' days to go', 'action' => 0];
            }
            if($current['cutoff'] == 0){
                $result['cutoff'] = ['day' => 'today', 'action' => 1];
            }else{
                $result['cutoff']  = ['day' => $current['cutoff'].' days to go', 'action' => 0];
            }
        }
        return $result;
    }
    function __getNotification(){
        $data['list'] = \Historie::where('status','<', 2)->orderBy('id', 'desc')->get();
        $data['count'] = 0;
        foreach($data['list'] as $h){
            if($h->status == 0){
                $data['count']++;
            }
        }
        return $data;
    }
    function __getSpecificsScheduleByCurrentMonth(){
        $current = $this->getCurrentBilling($this->data['date']['today']);
        $billing = [
            'import'  => date("Y-m-d", strtotime($current['current']['name'].'-'.$this->data['date']['collect'])),
            'release' => date("Y-m-d", strtotime($current['current']['name'].'-'.$this->data['date']['release'])),
            'notice'  => date("Y-m-d", strtotime($current['current']['name'].'-'.$this->data['date']['notice']."+ 1 months")),
            'cutoff'  => date("Y-m-d", strtotime($current['current']['name'].'-'.$this->data['date']['cutoff']."+ 1 months")),
        ];
        return $billing; 
    }
    function __getStartBilling(){
        /*$created = date("Y-m-d");
        $ym = date("Y-m",strtotime($created));
        $cutoff =  date("Y-m-d", strtotime($ym.'-'.$this->data['date']['collect'].' - 5 days')); 
        if($created <= $cutoff){
            return date("Y-m",strtotime($ym));
        }else{
            return date("Y-m",strtotime($ym."+ 1 months"));
        }*/
        return date("Y-m",strtotime($this->data['date']['today']."+ 1 months"));
    }
    function __validateSchedules(){
        if(\Input::get('collect') <= \Input::get('cutoff')){
            return 1;
        }
        if(\Input::get('release') <= \Input::get('collect')){
            return 2;
        }
        if(\Input::get('notice') >= \Input::get('cutoff')){
            return 3;
        }
        if(\Input::get('cutoff') <= \Input::get('notice')){
            return 4;
        }
        return 0;
    }
    function __setPenalty(){
        if($this->data['date']['schedules']['notice'] <= $this->data['date']['today']){
            $date = $this->getCurrentBilling($this->data['date']['today']);
            $bill = \Billing::where(['month_year' => $date['current']['name'], 'status' => 0, 'penalty' => 0])->get();
            if(count($bill)>0){
                foreach($bill as $b){
                    $new = \Billing::find($b->id);
                    $new->penalty = $this->data['price']['penalty'];
                    $new->save();
                }
            }
        }
    }


    function getCurrentBilling($date = NULL){
        $today_ymd = ($date == NULL)?date("Y-m-d",strtotime($this->date['today']."+ 8 hours")):date("Y-m-d",strtotime($date."+ 8 hours"));
        $today_ym = date("Y-m",strtotime($today_ymd));
        $bill_ymd  = date("Y-m-d",strtotime($today_ym."-".$this->data['date']['collect']));
        $next_clients = Client::where('status', 0)->get();
        if($today_ymd < $bill_ymd){
            $result['current']['name'] = date("Y-m",strtotime($today_ym." - 1 months"));
            $result['current']['date'] = date("Y-m-d",strtotime($bill_ymd." - 1 months"));
            $result['current']['time_difference'] = $this->getDaysCount($result['current']['date'], $today_ymd);
            $result['current']['step_1'] = "false";
            $current_statistics = $this->getBillingStatistics($result['current']['name']);
            $result['current']['total_client'] = count($current_statistics['total_client']);
            $result['current']['total_paid_client'] = $current_statistics['total_paid_client'];
            $result['current']['total_unpaid_client'] = $current_statistics['total_unpaid_client'];
            $result['current']['total_paid_amount'] = $current_statistics['total_paid_amount'];
            $result['current']['total_unpaid_amount'] = $current_statistics['total_unpaid_amount'];
            $result['current']['total_amount'] = $current_statistics['total_amount'];

            $result['next']['name'] = $today_ym;
            $result['next']['date'] = $bill_ymd;
            $result['next']['time_difference'] = $this->getDaysCount($today_ymd, $bill_ymd);
            $result['next']['step_1'] = "false";
            $current_statistics = $this->getBillingStatistics($result['next']['name']);
            $result['next']['total_client'] = count($current_statistics['total_client']);
            $result['next']['total_paid_client'] = $current_statistics['total_paid_client'];
            $result['next']['total_unpaid_client'] = $current_statistics['total_unpaid_client'];
            $result['next']['total_paid_amount'] = $current_statistics['total_paid_amount'];
            $result['next']['total_unpaid_amount'] = $current_statistics['total_unpaid_amount'];
            $result['next']['total_amount'] = $current_statistics['total_amount'];

        }else{
            $result['current']['name'] = $today_ym;
            $result['current']['date'] = $bill_ymd;
            $result['current']['time_difference'] = $this->getDaysCount($result['current']['date'], $today_ymd);
            $result['current']['step_1'] = "true";
            $current_statistics = $this->getBillingStatistics($result['current']['name']);
            $result['current']['total_client'] = count($current_statistics['total_client']);
            $result['current']['total_paid_client'] = $current_statistics['total_paid_client'];
            $result['current']['total_unpaid_client'] = $current_statistics['total_unpaid_client'];
            $result['current']['total_paid_amount'] = $current_statistics['total_paid_amount'];
            $result['current']['total_unpaid_amount'] = $current_statistics['total_unpaid_amount'];
            $result['current']['total_amount'] = $current_statistics['total_amount'];

            $result['next']['name'] = date("Y-m",strtotime($today_ym." + 1 months"));
            $result['next']['date'] = date("Y-m-d",strtotime($bill_ymd." + 1 months"));
            $result['next']['time_difference'] = $this->getDaysCount($today_ymd, date("Y-m-d",strtotime($bill_ymd."+ 1 months")));
            $result['next']['step_1'] = "false";
            $current_statistics = $this->getBillingStatistics($result['next']['name']);
            $result['next']['total_client'] = count($current_statistics['total_client']);
            $result['next']['total_paid_client'] = $current_statistics['total_paid_client'];
            $result['next']['total_unpaid_client'] = $current_statistics['total_unpaid_client'];
            $result['next']['total_paid_amount'] = $current_statistics['total_paid_amount'];
            $result['next']['total_unpaid_amount'] = $current_statistics['total_unpaid_amount'];
            $result['next']['total_amount'] = $current_statistics['total_amount'];
        }
        return $result;
    }
    function getBillingStatistics($bill_ymd){
        $result['total_client'] = Billing::where('month_year', date("Y-m",strtotime($bill_ymd)))->get();
        $result['total_paid_client'] = 0;
        $result['total_unpaid_client'] = 0;
        $result['total_paid_amount'] = 0;
        $result['total_unpaid_amount'] = 0;
        $result['total_amount'] = 0;
        if(count($result['total_client']) > 0){
            foreach($result['total_client'] as $c){
                if($c->status == 1){
                    $result['total_paid_client']++; 
                    $result['total_paid_amount'] += $c->total;
                }else{
                    $result['total_unpaid_client']++;
                    $result['total_unpaid_amount'] += $c->total;
                }
                $result['total_amount'] += $c->total;
            }
            
        }
        return $result;
    }
    function getDaysCount($start,$end){
        $i = 0;
        if($start < $end){
            while($start < $end){
                $start = date("Y-m-d",strtotime($start."+ 1 days"));
                $i++;
            }
        }else{
             while($start > $end){
                $start = date("Y-m-d",strtotime($start."- 1 days"));
                $i--;
            }
        }
        return $i;    
    }
    

    function setBill($date){
        
    }
    function activateBill($name,$date){
        
    }
}
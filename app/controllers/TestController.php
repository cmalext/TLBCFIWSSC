<?php
Class TestController extends UserController{
    public $model = 'Billing';
    public $page = '';
    function getIndex(){
        return "Test success";
    }
    function getBilling(){
        $current = $this->getCurrentBilling($this->data['date']['today']);
        $billing = [
            'import'  => date("Y-m-d", strtotime($current['current']['name'].'-'.$this->data['date']['collect'])),
            'release' => date("Y-m-d", strtotime($current['current']['name'].'-'.$this->data['date']['release'])),
            'notice'  => date("Y-m-d", strtotime($current['current']['name'].'-'.$this->data['date']['notice']."+ 1 months")),
            'cutoff'  => date("Y-m-d", strtotime($current['current']['name'].'-'.$this->data['date']['cutoff']."+ 1 months")),
        ];

        echo $this->data['date']['today'].' - '.$billing['import'];
        //return $billing; 
    }
    function getPenalty(){
        $billing = $this->getCurrentBilling($this->data['date']['today']);
        $bills = \Billing::where('month_year', $billing['current']['name'])->get();
        if(count($bills)>0){
            foreach($bills as $b){
                $new = \Billing::find($b->id);
                $new->penalty = 0;
                $new->save();
            }
        }
    }
}
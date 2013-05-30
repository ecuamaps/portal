<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class MY_Email extends CI_Email {

	var $from_email = '';
	var $from_name = '';
	var $to = '';
	var $message = '';
	var $subject = '';
	
    public function __construct()
    {
        parent::__construct();
        $this->from_name = get_config_val('business_name');
        $this->from_email = get_config_val('default_email_from');
    }
    
    function send_activation($name, $email, $passwd, $hash){
    	
    	$lang = current_lang();
    	$bz_name = get_config_val('business_name');
    	$slogan = get_config_val("business_slogan_$lang");
    	$this->subject = get_config_val("activation_email_subject_$lang").' '.$bz_name;
    	$msg = get_config_val("activation_email_$lang");
    	$this->to = $email;

    	$act_days = get_config_val('account_activation_days');
    	
    	$tags = array(
			'[USER_NAME]',
			'[EMAIL]',
			'[PASSWD]',
			'[SERVER]',
			'[HASH]',
			'[ACTIVATION_DAYS]',
			'[BIZ_NAME]',
			'[SLOGAN]',
			'[LANG]'
		);
		
		$data = array(
			$name,
			$email,
			$passwd,
			$_SERVER['HTTP_HOST'],
			$hash,
			$act_days,
			$bz_name,
			$slogan,
			$lang
		);
    	
    	$this->message = str_replace($tags, $data, $msg);
    	return $this->send_email();
    }
    
    function send_email(){

		$this->from($this->from_email, $this->from_name);
		$this->to($this->to); 
		
		$this->subject($this->subject);
		$this->message($this->message);	
		
		$r = $this->send();    
		//echo $this->print_debugger();
		return $r;	
    }
}
<?php
/*
|--------------------------------------------------------------------------
| @Filename: Cronjob.php
|--------------------------------------------------------------------------
| @Desc    : Cronjob
| @Date    : 2012-06-16
| @Version : 1.0 
| @By      : gabriela.kartika@gmail.com
|  
|
|
| @Modified By  :  
| @Modified Date: 
*/

class Cronjob extends CI_Controller 
{

	function Cronjob()
	{
		parent::__construct();	
		
		//loaders here ;-)
		$this->load->database();
		
		//misc
		$this->load->helper('misc');
		
		//more
		
	}
	
	
	/**
	| @name
	|      - index
	|
	| @params
	|      - 
	|
	| @return
	|      - 
	|
	| @contentription
	|      - default controller
	|
	**/
	function index()
	{
	    $this->load->model('Member_model',     'member_model');
	    
	    $month  = date('m');
	    $day    = date('d');
	    $rdata = $this->member_model->get_bday($month,$day);
	   // print_r($rdata);
	    if($rdata['total']>0)
	    {
            foreach($rdata['data'] as $member)
            {
                if($member->phone!='')
                {
                    $phone_str = ' - '.trim($member->phone);
                }
                $members[] = $member->name.'(CG '.$member->cg_name.$phone_str.')';
                $phone_str = '';
            }
            
            $members = implode(', ',$members);
            
            $recipient = 'AmoreDio@yahoogroups.com';//'cuhaowen@yahoo.com';//
            $subject = 'Happy Birthday..';
     // print $members;        
            $message = '
            
            Dear friends,
            <br /><br />
            On this special day, we\'d like to shout <font color="green"><b>HAPPY BIRTHDAY</b></font> to our dearest friend...       
            <br /><br />
            <font color="red"><b>'.$members.'</b></font>
            <br /><br />
            Hope your birthday blossoms into lots of dreams come true.
            <br />
            Have a blessed day!
            <br /><br />
            Regards,
            <br /><br />
            Admin Amoredio
            ';
          
            $headers .= 'From: Admin Amoredio <cyber.amoredio@gmail.com>' . "\r\n";
    
            // To send HTML mail, the Content-type header must be set
            $headers  .= 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
            
            mail($recipient, $subject, $message, $headers);

/*
            $this->load->library('email');
    
            $config['charset'] = 'utf-8';
            $config['wordwrap'] = TRUE;
            $config['mailtype'] = 'html';
            
            $this->email->initialize($config);

            $this->email->from('admin@amoredio.org', 'Admin Amoredio');
            $this->email->to($recipient);
            
            $this->email->subject($subject);
            $this->email->message($message);
            
            $this->email->send();
        */
            
        }
    }
    
    
    function test_mail()
    {
        $this->load->library('email');
    
        $recipient = 'cuhaowen@yahoo.com';//'chmarine@yahoogroups.com';////'AmoreDio@yahoogroups.com';
        $subject = 'Testing..pls ignore';
        /*    
        $config['charset'] = 'utf-8';
        $config['wordwrap'] = TRUE;
        $config['mailtype'] = 'html';
        
        $this->email->initialize($config);

        $this->email->from('kartika.octaviani.wirawan@gmail.com', 'Admin Amoredio');//cyber.amoredio@gmail.com
        $this->email->to($recipient);
        
        $this->email->subject($subject);
        $this->email->message($message);
        
        //$this->email->send();
        */
        $to      = $recipient;

$message = '<b>Test Message</b>';
            
$headers .= 'From: Admin Amoredio <cyber.amoredio@gmail.com>' . "\r\n";
    
// To send HTML mail, the Content-type header must be set
$headers  .= 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

//mail($to, $subject, $message, $headers);
        
        echo 'recipient: '.$recipient."<br />Subj: ".$subject;
    }
    
   
    
    
    
}
<?php
/*
|--------------------------------------------------------------------------
| @Filename: home.php
|--------------------------------------------------------------------------
| @Desc    : Home
| @Date    : 2012-06-16
| @Version : 1.0 
| @By      : gabriela.kartika@gmail.com
|  
|
|
| @Modified By  :  
| @Modified Date: 
*/

class Home extends Controller 
{

	function Home()
	{
		parent::Controller();	
		
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
	
	
        /*if(is_broswer_mobile())
        
        $this->load->view('home.view.mobile.php',$vdata);
        
	    else   */
	    
	    $vdata['page_title'] = 'Home';
	    $vdata['ishome']=1; 
        $this->load->view('homev2.php',$vdata);

    }
    
    function indextest()
	{
	
	
        /*if(is_broswer_mobile())
        
        $this->load->view('home.view.mobile.php',$vdata);
        
	    else   */
	    
	    $vdata['page_title'] = 'Home';
	    $vdata['ishome']=1; 
        $this->load->view('home2v2.php',$vdata);

    }

    
    
    
}


<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Jason Shultz
 * Date: 3/7/11
 * Time: 8:55 AM
 */
 
class Test extends CI_Controller {

    function __construct()
	{
		parent::__construct();
		$this->load->library('tank_auth');
	}

    function index()
    {


        $this->load->helper('shared_framework');
        $this->load->helper('uagent');
        $this->load->view('test');
    }

}

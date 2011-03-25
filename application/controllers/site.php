<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Site extends CI_Controller {
	
	function __construct()
	{
		parent::__construct();
        $this->load->library('tank_auth');
	}
	
	function index()
	{
        if (!$this->tank_auth->is_logged_in()) {
			$data['loggedin'] = FALSE;
            
		} else {
            $data['loggedin'] = TRUE;

        }
        $data['headerjs'] = NULL;
        $data['headermap'] = NULL;
        $this->load->model('News_model');
		$data['news']	= $this->News_model->getNewsList();
		$data['page_title'] = 'Welcome to Trash Can Manager';
		$data['page'] = 'welcome_message'; // pass the actual view to use as a parameter
		$this->load->view('container-welcome',$data);
	}
	
	function about()
	{
		$data['headerjs'] = NULL;
        $data['headermap'] = NULL;
        $data['page_title'] = 'Trash Can Manager: About Us';
		$data['page'] = 'about_view'; // pass the actual view to use as a parameter
		$this->load->view('container',$data);
	}

	
	function getstarted()
	{
        $data['headerjs'] = NULL;
        $data['headermap'] = NULL;
        $data['page_title'] = 'Trash Can Manager: Getting Started';
        $data['page'] = 'getstarted_view'; // pass the actual view to use as a parameter
        $this->load->view('container',$data);
	}

	
	function project($id)
	{
        $this->load->model('Projects_model');
		$this->load->model('Gallery_model');
        $data['photos'] = $this->Gallery_model->public_get_images_from_db($id);
        $data['project'] = $this->Projects_model->getProject($id);
		$data['page_title'] = 'Trash Can Manager: Projects';
		$data['page'] = 'project_view'; // pass the actual view to use as a parameter
		$this->load->view('container',$data);
	}

	function news($id)
	{
        $this->load->model('News_model');
        $data['news'] = $this->News_model->getNews($id);
		$data['page_title'] = 'Trash Can Manager: Projects';
		$data['page'] = 'news_view'; // pass the actual view to use as a parameter
		$this->load->view('container',$data);
	}


    function suppliers()
	{
		  $data['page_title'] = 'Trash Can Manager: Our Suppliers';
		  $data['page'] = 'suppliers_view'; // pass the actual view to use as a parameter
		  $this->load->view('container',$data);
	}
	
	function contactus()
	{
        $data['headerjs'] = $this->gmap->getHeaderJS();
        $data['headermap'] = $this->gmap->getMapJS();
		$this->load->library('recaptcha');
		$this->load->library('form_validation');
		$this->lang->load('recaptcha');
		$data ['recaptcha'] = $this->recaptcha->get_html();
        $data['page_title'] = 'Trash Can Manager: Contact Us';
        $data['page'] = 'contact_view'; // pass the actual view to use as a parameter
        $this->load->view('container',$data);
	}
	
	function contact_confirmation()
	{
        $data['headerjs'] = $this->gmap->getHeaderJS();
        $data['headermap'] = $this->gmap->getMapJS();
        $data['page_title'] = 'Trash Can Manager: Thank You';
        $data['page'] = 'confirm_view'; // pass the actual view to use as a parameter
        $this->load->view('container',$data);
	}
}

/* End of file site.php */
/* Location: /application/controllers/site.php */
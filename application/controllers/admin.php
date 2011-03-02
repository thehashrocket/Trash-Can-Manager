<?php if (!defined('BASEPATH')) exit('No direct script access allowed');



class Admin extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->library('tank_auth');
	}

	function index()
	{
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
            $this->load->model('Customer_model');
            $this->load->model('Invoice_model');
            $data['headerjs'] = $this->gmap->getHeaderJS();
            $data['headermap'] = $this->gmap->getMapJS();
            $data['customers'] = $this->Customer_model->getCustomers();
            $data['pastdue'] = $this->Invoice_model->get_all_overdue();
			$data['user_id']	= $this->tank_auth->get_user_id();
			$data['username']	= $this->tank_auth->get_username();
			$data['page_title'] = 'Trash Can Manager - Control Panel';
		  $data['page'] = '/admin/admin_welcome'; // pass the actual view to use as a parameter
		  $this->load->view('container-admin',$data);
		}
	}

    function custedit($id)
	{
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
            $this->gmap->GoogleMapAPI();
            // valid types are hybrid, satellite, terrain, map
            $this->gmap->setMapType('map');
            // you can also addMarkerByCoords($long,$lat)
            // both marker methods also support $html, $tooltip, $icon_file and $icon_shadow_filename
            $data['headerjs'] = $this->gmap->getHeaderJS();
            $data['headermap'] = $this->gmap->getMapJS();
			$this->load->model('Customer_model');
			$data['customer']	= $this->Customer_model->getCustEdit($id);
			$data['user_id']	= $this->tank_auth->get_user_id();
			$data['username']	= $this->tank_auth->get_username();
            $query    = $this->Customer_model->getAddress($id);
            $address = $query->street1 . ', '. $query->street2 . ', '. $query->city . ', '. $query->state . ', '. $query->zip;
            $markerDesc =  $query->street1 . ', '. $query->street2 . ', '. $query->city . ', '. $query->state . ', '. $query->zip;

            $this->gmap->addMarkerByAddress($address, "Marker Title", $markerDesc);
            /* $this->gmap->addDirections("42 Beanland Gardens, Wibsey, Bradford, UK", "57 Cardigan Lane, Leeds, UK", 'map_directions', $display_markers=true); */
            $data['headerjs'] = $this->gmap->getHeaderJS();
            $data['headermap'] = $this->gmap->getMapJS();
            $data['onload'] = $this->gmap->printOnLoad();
            $data['directions'] = $this->gmap->addDirections();
            $data['map'] = $this->gmap->printMap();
            $data['sidebar'] = $this->gmap->printSidebar();
            $data['page_title'] = 'Trash Can Manager - Control Panel';
		  $data['page'] = '/admin/admin_custedit'; // pass the actual view to use as a parameter
		  $this->load->view('container-admin',$data);
		}
	}

    function customerview($id)
	{
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
            $this->gmap->GoogleMapAPI();
            // valid types are hybrid, satellite, terrain, map
            $this->gmap->setMapType('map');
            // you can also addMarkerByCoords($long,$lat)
            // both marker methods also support $html, $tooltip, $icon_file and $icon_shadow_filename
            $data['headerjs'] = $this->gmap->getHeaderJS();
            $data['headermap'] = $this->gmap->getMapJS();
			$this->load->model('Customer_model');
			$data['customer']	= $this->Customer_model->getCustEdit($id);
			$data['user_id']	= $this->tank_auth->get_user_id();
			$data['username']	= $this->tank_auth->get_username();
            $query    = $this->Customer_model->getAddress($id);
            $address = $query->street1 . ', '. $query->street2 . ', '. $query->city . ', '. $query->state . ', '. $query->zip;
            $markerDesc =  $query->street1 . ', '. $query->street2 . ', '. $query->city . ', '. $query->state . ', '. $query->zip;

            $this->gmap->addMarkerByAddress($address, "Marker Title", $markerDesc);
            /* $this->gmap->addDirections("42 Beanland Gardens, Wibsey, Bradford, UK", "57 Cardigan Lane, Leeds, UK", 'map_directions', $display_markers=true); */
            $data['headerjs'] = $this->gmap->getHeaderJS();
            $data['headermap'] = $this->gmap->getMapJS();
            $data['onload'] = $this->gmap->printOnLoad();
            $data['directions'] = $this->gmap->addDirections();
            $data['map'] = $this->gmap->printMap();
            $data['sidebar'] = $this->gmap->printSidebar();
            $data['page_title'] = 'Trash Can Manager - Control Panel';
		  $data['page'] = '/admin/admin_custview'; // pass the actual view to use as a parameter
		  $this->load->view('container-admin',$data);
		}
	}

    function settings()
    {
        if (!$this->tank_auth->is_logged_in()) {
            redirect('/auth/login');
        } else {
            $data['headerjs'] = $this->gmap->getHeaderJS();
            $data['headermap'] = $this->gmap->getMapJS();
            $data['user_id']	= $this->tank_auth->get_user_id();
			$data['username']	= $this->tank_auth->get_username();
            $this->load->model('Client_model');
            $data['client'] = $this->Client_model->getClient();
            $data['trashcans'] = $this->Client_model->getTrashCans();
            $data['page_title'] = 'Trash Can Manager - Settings';
            $data['page'] = '/admin/admin_settings';
            $this->load->view('container-admin',$data);
        }
    }

    function newsedit($id)
	{
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			$this->load->model('News_model');
			$data['news']	= $this->News_model->getNews($id);
			$data['user_id']	= $this->tank_auth->get_user_id();
			$data['username']	= $this->tank_auth->get_username();
			$data['page_title'] = 'Trash Can Manager - Control Panel';
		  $data['page'] = '/admin/admin_newsedit'; // pass the actual view to use as a parameter
		  $this->load->view('container-admin',$data);
		}
	}
	
	// Displays current gallery for Customer
	// Takes input and sends to /client/gallery_up
	function gallery($id)
	{
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
		$this->load->model('Projects_model');	
		$this->load->model('Gallery_model');
		
		if ($this->input->post('upload')) {
			$this->Gallery_model->do_upload();
		}
		$data['user_id']	= $this->tank_auth->get_user_id();
		$data['proj_id'] = $id;
		$data['photos'] = $this->Gallery_model->get_images_from_db($id);
		$data['username']	= $this->tank_auth->get_username();
		$data['page_title'] = 'Trash Can Manager - Gallery Manager';
		$data['page'] = '/admin/admin_gallery_view'; // pass the actual view to use as a parameter
		$this->load->view('container-admin',$data);
		}
	}
	
	// Updates Gallery Table
	// Receives input from /client/gallery
	function gallery_up()
	{
		$this->load->model('Projects_model');
		$this->load->model('Gallery_model');
		
		$projid = (string)$this->input->post('projid', TRUE);
		
		$this->Gallery_model->do_upload($projid);
		
		
		$url = (string)$this->input->post('redirect', TRUE);
		redirect($url);
	}

    function updateCustomer()
	{
		$this->load->library('form_validation');
		$this->load->model('Customer_model');

		// field name, error message, validation rules
        $this->form_validation->set_rules('custid', 'Customer Id', 'trim');
		$this->form_validation->set_rules('lastname', 'Last Name', 'trim', 'required');
        $this->form_validation->set_rules('firstname', 'First Name', 'trim', 'required');
		$this->form_validation->set_rules('street1', 'Street Address', 'trim', 'required');
        $this->form_validation->set_rules('street2', 'Apartment or Suite', 'trim');
		$this->form_validation->set_rules('city', 'City', 'trim', 'required');
        $this->form_validation->set_rules('state', 'State', 'trim', 'required');
        $this->form_validation->set_rules('zip', 'Zip Code', 'trim', 'required');
        $this->form_validation->set_rules('phonenumber', 'Telephone', 'trim', 'required');
        $this->form_validation->set_rules('userid', 'User ID', 'trim');
        $this->form_validation->set_rules('goback', 'Go Boack', 'trim');

		if($this->form_validation->run() == FALSE)
		{
            $data['headerjs'] = $this->gmap->getHeaderJS();
            $data['headermap'] = $this->gmap->getMapJS();
            $data['user_id']	= $this->tank_auth->get_user_id();
            $id = (string)$this->input->post('custid', TRUE);
			$this->load->model('Customer_model');
			$data['customer']	= $this->Customer_model->getCustEdit($id);
			$data['user_id']	= $this->tank_auth->get_user_id();
			$data['username']	= $this->tank_auth->get_username();
			$data['page'] = '/admin/admin_custedit'; // pass the actual view to use as a parameter
		  	$this->load->view('container-admin',$data);
		}
		else
		{
			// Validation has passed. Now Send to Model

            $custid = (string)$this->input->post('custid', TRUE);
			$lastname = (string)$this->input->post('lastname', TRUE);
            $firstname = (string)$this->input->post('firstname', TRUE);
			$street1 = (string)$this->input->post('street1', TRUE);
            $street2 = (string)$this->input->post('street2', TRUE);
			$city = (string)$this->input->post('city', TRUE);
			$state =(string)$this->input->post('state', TRUE);
            $zip =(string)$this->input->post('zip', TRUE);
            $phonenumber =(string)$this->input->post('phonenumber', TRUE);
            $userid =(string)$this->input->post('userid', TRUE);
            $goback =(string)$this->input->post('goback', TRUE);


			$this->Customer_model->updateCust($custid, $lastname, $firstname, $street1, $street2, $city, $state, $zip, $phonenumber, $userid, $goback);
		}
	}
    function updateClient() {
        $this->load->library('form_validation');
        $this->load->model('Client_model');

        $this->form_validation->set_rules('userid', 'User Id', 'trim');
        $this->form_validation->set_rules('companyname', 'Company Name', 'trim', 'required');
        $this->form_validation->set_rules('costreet', 'Company Sgreet', 'trim', 'required');
        $this->form_validation->set_rules('cocity', 'Company City', 'trim', 'required');
        $this->form_validation->set_rules('costate', 'Company State', 'trim', 'required');
        $this->form_validation->set_rules('cozip', 'Company Zip', 'trim', 'required');
        $this->form_validation->set_rules('goback', 'Go Back', 'trim');

        if($this->form_validation->run() == FALSE)
        {
            $data['headerjs'] = $this->gmap->getHeaderJS();
            $data['headermap'] = $this->gmap->getMapJS();
            $data['user_id']	= $this->tank_auth->get_user_id();
			$data['username']	= $this->tank_auth->get_username();
            $this->load->model('Client_model');
            $data['client'] = $this->Client_model->getClient();
            $data['page_title'] = 'Trash Can Manager - Settings';
            $data['page'] = '/admin/admin_settings';
            $this->load->view('container-admin',$data);
        }
        else
        {
            $userid = (string)$this->input->post('userid', TRUE);
            $companyname = (string)$this->input->post('companyname', TRUE);
            $costreet = (string)$this->input->post('costreet', TRUE);
            $cocity = (string)$this->input->post('cocity', TRUE);
            $costate = (string)$this->input->post('costate', TRUE);
            $cozip = (string)$this->input->post('cozip', TRUE);
            $cophone = (string)$this->input->post('cophone', TRUE);
            $goback = (string)$this->input->post('goback', TRUE);

            $this->Client_model->updateClient($userid, $companyname, $costreet, $cocity, $costate, $cozip, $cophone, $goback);
        }
    }

    function updateTrashCan() {
        $this->load->library('form_validation');
        $this->load->model('Client_model');

        $this->form_validation->set_rules('idtrashsize', 'Trash Size ID', 'trim', 'required');
        $this->form_validation->set_rules('trashcansize', 'Trash Can Size', 'trim', 'required');
        $this->form_validation->set_rules('trashcantype', 'Trash Can Type', 'trim', 'required');
        $this->form_validation->set_rules('trashdescript', 'Trash Can Description', 'trim', 'required');
        $this->form_validation->set_rules('trashcanprice', 'Trash Can Price', 'trim', 'required');
        $this->form_validation->set_rules('userid', 'User Id', 'trim');
        $this->form_validation->set_rules('goback', 'Go Back', 'trim');

        if($this->form_validation->run() == FALSE)
        {
            $data['headerjs'] = $this->gmap->getHeaderJS();
            $data['headermap'] = $this->gmap->getMapJS();
            $data['user_id']	= $this->tank_auth->get_user_id();
			$data['username']	= $this->tank_auth->get_username();
            $this->load->model('Client_model');
            $data['client'] = $this->Client_model->getClient();
            $data['page_title'] = 'Trash Can Manager - Settings';
            $data['page'] = '/admin/admin_settings';
            $this->load->view('container-admin',$data);
        }
        else
        {
            $idtrashsize = (string)$this->input->post('idtrashsize', TRUE);
            $cansize = (string)$this->input->post('trashcansize', TRUE);
            $cantype = (string)$this->input->post('trashcantype', TRUE);
            $description = (string)$this->input->post('trashdescript', TRUE);
            $price = (string)$this->input->post('trashcanprice', TRUE);
            $userid = (string)$this->input->post('userid', TRUE);
            $goback = (string)$this->input->post('goback', TRUE);

            $this->Client_model->updateTrashCan($userid, $idtrashsize, $cansize, $cantype, $price, $description, $goback);
        }
    }

    function archiveCustomer($id)
	{
        $this->load->model('Customer_model');
        $user_id = $this->tank_auth->get_user_id();
        $custid = $id;
		$goback = 'admin/index';

        $this->Customer_model->archiveCust($user_id, $custid, $goback);
	}

    function archiveTrashCan($id, $tid)
	{
        $this->load->model('Client_model');
        $user_id = $id;
        $idtrashcans = $tid;
		$goback = 'admin/settings';

        $this->Client_model->archiveTrashCan($user_id, $idtrashcans, $goback);
	}
	function createnews()
	{

		$this->load->library('form_validation');
		$this->load->model('News_model');

		// field name, error message, validation rules
		$this->form_validation->set_rules('headline', 'News Headline', 'trim', 'required');
		$this->form_validation->set_rules('story', 'News Story', 'trim', 'required');

		if($this->form_validation->run() == FALSE)
		{
            $data['headerjs'] = $this->gmap->getHeaderJS();
            $data['headermap'] = $this->gmap->getMapJS();
            $data['user_id']	= $this->tank_auth->get_user_id();
			$data['page'] = '/admin/admin_welcome'; // pass the actual view to use as a parameter
		  	$this->load->view('container-admin',$data);
		}
		else
		{
			// Validation has passed. Now Send to Model

			$headline = (string)$this->input->post('headline', TRUE);
			$story = (string)$this->input->post('story', TRUE);
			$redirect =(string)$this->input->post('redirect', TRUE);
			
			$this->News_model->createNews($headline, $story, $redirect);
		}
	}

    function deletePhoto($id, $pid)
	{
		$this->db->where(array('id'=>$id));
		$this->db->delete('photos');
        $url = 'admin/gallery/' . $pid;
		redirect($url);
	}
	
	function deleteProject($id)
	{
		$this->db->where(array('id'=>$id));
		$this->db->delete('projects');
		redirect('admin/index');
	}
	
	function updateProject()
	{
		$this->load->library('form_validation');
		$this->load->model('Projects_model');
		
		// field name, error message, validation rules
		$this->form_validation->set_rules('name', 'Project Name', 'trim', 'required');
        $this->form_validation->set_rules('shortdesc', 'Short Description', 'trim', 'required');
		$this->form_validation->set_rules('description', 'Project Description', 'trim', 'required');
        $this->form_validation->set_rules('systemfacts', 'System Facts', 'trim', 'required');
		$this->form_validation->set_rules('category', 'Project Category', 'trim', 'required');
		
		if($this->form_validation->run() == FALSE)
		{
			$data['page'] = '/admin/admin_welcome'; // pass the actual view to use as a parameter
		  	$this->load->view('container-admin',$data);
		}
		else
		{
			// Validation has passed. Now Send to Model
			
			$id = (string)$this->input->post('id', TRUE);
			$name = (string)$this->input->post('name', TRUE);
            $shortdesc = (string)$this->input->post('shortdesc', TRUE);
			$description = (string)$this->input->post('desc', TRUE);
            $systemfacts = (string)$this->input->post('systemfacts', TRUE);
			$category = (string)$this->input->post('category', TRUE);
			$redirect =(string)$this->input->post('redirect', TRUE);
			
			$this->Projects_model->updateProject($id, $name, $shortdesc, $description, $systemfacts, $category, $redirect);
		}
	}

    function updateNews()
	{
		$this->load->library('form_validation');
		$this->load->model('News_model');

		// field name, error message, validation rules
		$this->form_validation->set_rules('headline', 'News Headline', 'trim', 'required');
		$this->form_validation->set_rules('story', 'News Story', 'trim', 'required');

		if($this->form_validation->run() == FALSE)
		{
			$data['page'] = '/admin/admin_welcome'; // pass the actual view to use as a parameter
		  	$this->load->view('container-admin',$data);
		}
		else
		{
			// Validation has passed. Now Send to Model

			$id = (string)$this->input->post('id', TRUE);
			$headline = (string)$this->input->post('headline', TRUE);
			$story = (string)$this->input->post('story', TRUE);
			$redirect =(string)$this->input->post('redirect', TRUE);

			$this->News_model->updateNews($id, $headline, $story, $redirect);
		}
	}

    function test()
    {
        if (!$this->tank_auth->is_logged_in()) {
        redirect('/auth/login/');
    }
        else {
            $this->gmap->GoogleMapAPI();
            // valid types are hybrid, satellite, terrain, map
            $this->gmap->setMapType('map');
            // you can also addMarkerByCoords($long,$lat)
            // both marker methods also support $html, $tooltip, $icon_file and $icon_shadow_filename
            $this->gmap->addMarkerByAddress("106 E Aspen ST, Cottonwood, AZ, US", "Marker Title", "Marker Description");
            $this->gmap->addDirections("42 Beanland Gardens, Wibsey, Bradford, UK", "57 Cardigan Lane, Leeds, UK", 'map_directions', $display_markers=true);
			$data['user_id']	= $this->tank_auth->get_user_id();
			$data['username']	= $this->tank_auth->get_username();
            $data['headerjs'] = $this->gmap->getHeaderJS();
            $data['headermap'] = $this->gmap->getMapJS();
            $data['onload'] = $this->gmap->printOnLoad();
            $data['directions'] = $this->gmap->addDirections();
            $data['map'] = $this->gmap->printMap();
            $data['sidebar'] = $this->gmap->printSidebar();
            $data['page_title'] = 'Trash Can Manager - Control Panel';
            $data['page'] = '/admin/admin_test'; // pass the actual view to use as a parameter
            $this->load->view('container-admin',$data);
    }
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/admin.php */
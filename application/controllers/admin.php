<?php if (!defined('BASEPATH')) exit('No direct script access allowed');







class Admin extends CI_Controller

{

	function __construct()

	{

		parent::__construct();

		$this->load->library('tank_auth');

        $this->load->library('authorizenet');

	}



	function index()

	{

		if (!$this->tank_auth->is_logged_in()) {

			redirect('/auth/login/');

		} else {

            $this->load->model('Customer_model');

            $this->load->model('Invoice_model');

            $data['headerjs'] = NULL;

            $data['headermap'] = NULL;

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



    function createinvoice($id)

	{

		if (!$this->tank_auth->is_logged_in()) {

			redirect('/auth/login/');

		} else {

            $this->gmap->GoogleMapAPI();

            // valid types are hybrid, satellite, terrain, map

            $this->gmap->setMapType('map');

            // you can also addMarkerByCoords($long,$lat)

            // both marker methods also support $html, $tooltip, $icon_file and $icon_shadow_filename

            $data['headerjs'] = NULL;

            $data['headermap'] = NULL;

			$this->load->model('Customer_model');

            $this->load->model('Invoice_model');

            $this->load->model('Client_model');

            $data['trashcan_select'] = $this->Client_model->getTrashCanDropDown();

            $data['customer'] = $this->Customer_model->getCustomerbyId($id);

			$data['user_id']	= $this->tank_auth->get_user_id();

            $data['custid']     = $id;

			$data['username']	= $this->tank_auth->get_username();

            $data['page_title'] = 'Trash Can Manager - Control Panel';

		  $data['page'] = '/admin/admin_createinvoice'; // pass the actual view to use as a parameter

		  $this->load->view('container-admin',$data);

		}

	}



    function makeInvoice()

    {

        $this->load->library('form_validation');

        $this->load->model('Client_model');

        $this->load->model('Customer_model');

        $this->load->model('Invoice_model');



        $this->form_validation->set_rules('userid', 'User Id', 'trim');



        if($this->form_validation->run() == FALSE)

        {



        }



        else

        {

            $userid = (string)$this->input->post('userid', TRUE);

            $custid = (string)$this->input->post('custid', TRUE);

            $invoicenumber = (string)$this->input->post('invoice_number', TRUE);

            $notes = (string)$this->input->post('notes', TRUE);

            $ispaid = (string)$this->input->post('is_paid', TRUE);

            $is_recurring = (string)$this->input->post('is_recurring', TRUE);

            $frequency = (string)$this->input->post('frequency', TRUE);

            $autosend = (string)$this->input->post('auto_send', TRUE);

            $description = (string)$this->input->post('description', TRUE);

            $goback = (string)$this->input->post('goback', TRUE);



            if ( ! isset($invoicenumber) OR empty($invoicenumber))

		{

			$input['invoice_number'] = $this->Invoice_model->_generate_invoice_number();

		}



		    $unique_id = $this->Invoice_model->_generate_unique_id();



            $invoice_items = $this->input->post('invoice_item');



            //var_dump($invoice_items);



            $this->Invoice_model->insertInvoice($userid, $custid, $invoicenumber, $invoice_items, $notes, $ispaid, $is_recurring, $frequency, $autosend, $description, $unique_id, $goback);



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

            $data['trashcans']  = $this->Customer_model->getCustTrashcans($id);

			$data['user_id']	= $this->tank_auth->get_user_id();

            $data['custid']     = $id;

            $data['commenttype'] = $this->Customer_model->getCommentType();

            $data['select_options'] = $this->Customer_model->get_comment_type_select();

			$data['username']	= $this->tank_auth->get_username();

            $query    = $this->Customer_model->getAddress($id);



            if(isset($query->street1)) {

                $address = $query->street1 . ', '. $query->street2 . ', '. $query->city . ', '. $query->state . ', '. $query->zip;

                $markerDesc =  $query->street1 . ', '. $query->street2 . ', '. $query->city . ', '. $query->state . ', '. $query->zip;

                $this->gmap->addMarkerByAddress($address, "Marker Title", $markerDesc);

                }

            else



                $address = NULL;



            /* $this->gmap->addDirections("42 Beanland Gardens, Wibsey, Bradford, UK", "57 Cardigan Lane, Leeds, UK", 'map_directions', $display_markers=true); */

            $data['headerjs'] = $this->gmap->getHeaderJS();

            $data['headermap'] = $this->gmap->getMapJS();

            $data['onload'] = $this->gmap->printOnLoad();

            $data['directions'] = $this->gmap->addDirections();

            $data['comments'] = $this->Customer_model->getComments($id);

            $data['map'] = $this->gmap->printMap();

            $data['sidebar'] = $this->gmap->printSidebar();

            $data['page_title'] = 'Trash Can Manager - Control Panel';

		  $data['page'] = '/admin/admin_custview'; // pass the actual view to use as a parameter

		  $this->load->view('container-admin',$data);

		}

	}

    function receivepayment($id)
    {
        if (!$this->tank_auth->is_logged_in()) {

            redirect('/auth/login');

        } else {

            $data['headerjs'] = NULL;

            $data['headermap'] = NULL;

			$this->load->model('Customer_model');

            $this->load->model('Invoice_model');

            $this->load->model('Client_model');

            $data['trashcan_select'] = $this->Client_model->getTrashCanDropDown();

            $data['customer'] = $this->Customer_model->getCustomerbyId($id);

			$data['user_id']	= $this->tank_auth->get_user_id();

            $data['custid']     = $id;

			$data['username']	= $this->tank_auth->get_username();

            $data['page_title'] = 'Trash Can Manager - Control Panel';

            $data['page'] = '/admin/admin_receivepayment'; // pass the actual view to use as a parameter

            $this->load->view('container-admin',$data);

        }

    }



    function settings()

    {

        if (!$this->tank_auth->is_logged_in()) {

            redirect('/auth/login');

        } else {

            $data['headerjs'] = NULL;

            $data['headermap'] = NULL;

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



    function updateClient()

    {

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

            $data['headerjs'] = NULL;

            $data['headermap'] = NULL;

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



    function updateComment()

    {

        $this->load->library('form_validation');

		$this->load->model('Customer_model');



		// field name, error message, validation rules

        $this->form_validation->set_rules('custid', 'Customer Id', 'trim');

		$this->form_validation->set_rules('comment', 'Comment', 'trim', 'required');

        $this->form_validation->set_rules('commenttype', 'Comment Type', 'trim');

        $this->form_validation->set_rules('userid', 'User ID', 'trim');

        $this->form_validation->set_rules('commentid', 'Comment ID', 'trim');

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

			$data['page'] = '/admin/admin_custview'; // pass the actual view to use as a parameter

		  	$this->load->view('container-admin',$data);

		}

		else

		{

			// Validation has passed. Now Send to Model



            $custid = (string)$this->input->post('custid', TRUE);

            $commentid = (string)$this->input->post('commentid', TRUE);

			$comment = (string)$this->input->post('comment', TRUE);

            $commenttype = (string)$this->input->post('commenttype', TRUE);

            $userid =(string)$this->input->post('userid', TRUE);

            $goback =(string)$this->input->post('goback', TRUE);





			$this->Customer_model->updateComment($custid, $commentid, $comment, $commenttype, $userid, $goback);

		}



    }



    function updateTrashCan()

    {

        $this->load->library('form_validation');

        $this->load->model('Client_model');



        $this->form_validation->set_rules('idtrashcans', 'Trash Size ID', 'trim', 'required');

        $this->form_validation->set_rules('trashcansize', 'Trash Can Size', 'trim', 'required');

        $this->form_validation->set_rules('trashcantype', 'Trash Can Type', 'trim', 'required');

        $this->form_validation->set_rules('trashdescript', 'Trash Can Description', 'trim', 'required');

        $this->form_validation->set_rules('trashcanprice', 'Trash Can Price', 'trim', 'required');

        $this->form_validation->set_rules('userid', 'User Id', 'trim');

        $this->form_validation->set_rules('goback', 'Go Back', 'trim');



        if($this->form_validation->run() == FALSE)

        {

            $data['headerjs'] = NULL;

            $data['headermap'] = NULL;

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

            $idtrashcans = (string)$this->input->post('idtrashcans', TRUE);

            $cansize = (string)$this->input->post('trashcansize', TRUE);

            $cantype = (string)$this->input->post('trashcantype', TRUE);

            $description = (string)$this->input->post('trashdescript', TRUE);

            $price = (string)$this->input->post('trashcanprice', TRUE);

            $userid = (string)$this->input->post('userid', TRUE);

            $goback = (string)$this->input->post('goback', TRUE);



            $this->Client_model->updateTrashCan($userid, $idtrashcans, $cansize, $cantype, $price, $description, $goback);

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

}



/* End of file welcome.php */

/* Location: ./application/controllers/admin.php */
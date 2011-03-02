<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Email extends CI_Controller
{
	function __construct()
	{
		parent::__construct();

		$this->load->helper('url');
	}

	function send() 
	{	
		$this->load->library('form_validation');
		$this->load->model('Email_model');
		$this->load->library('recaptcha');
		$this->load->library('form_validation');
		$this->lang->load('recaptcha');
		$data ['recaptcha'] = $this->recaptcha->get_html();
		// field name, error message, validation rules
		$this->form_validation->set_rules('name', 'Name', 'trim|required');
		$this->form_validation->set_rules('email', 'Email Address', 'trim|required|valid_email');
		$this->form_validation->set_rules('comments', 'Comments', 'trim|required');
		$this->form_validation->set_rules('phone', 'Phone Number', 'trim|');
		$this->form_validation->set_rules('recaptcha_response_field','lang:recaptcha_field_name','required|callback_check_captcha');
		
		if ($this->form_validation->run())
		{
			// validation has passed. Now send the email
			$name = (string)$this->input->post('name', TRUE);
			$phone = (string)$this->input->post('phone', TRUE);
			$email = (string)$this->input->post('email', TRUE);
			$subject = (string)$this->input->post('subject', TRUE);
			$comments = (string)$this->input->post('comments', TRUE);
			
			$message = "Message from: " . $name . "<br/>" ;
			$message .= "Phone Number: " . $phone . "<br/>";
			$message .= "Email: " . $email . "<br/>";
			$message .= "Subject: " . $subject . "- From Open Sky Media<br/>";
			$message .= "Message: " . $comments . "<br/>";
			
			$redirect = "/site/contact_confirmation";

			$this->Email_model->sendeMail($name, $email, $message, $subject, $redirect);
		
		}
		else
		{
			$this->load->library('recaptcha');
			$this->load->library('form_validation');
			$this->lang->load('recaptcha');
			$data ['recaptcha'] = $this->recaptcha->get_html();
			$data['page_title'] = 'Open Sky Media - Web Development Professional: Contact Us';
			$data['page'] = 'contact_view'; // pass the actual view to use as a parameter
			$this->load->view('container',$data);
		
			
	}
	
	
	
	}
	
	function check_captcha($val) {
	  if ($this->recaptcha->check_answer($this->input->ip_address(),$this->input->post('recaptcha_challenge_field'),$val)) {
	    return TRUE;
	  } else {
	    $this->form_validation->set_message('check_captcha',$this->lang->line('recaptcha_incorrect_response'));
	    return FALSE;
	  }
	}

}

/* End of file email.php */
/* Location: ./application/controllers/email.php */
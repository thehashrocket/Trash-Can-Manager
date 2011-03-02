<?php

class Email_model extends CI_Model {

function sendeMail($name, $email, $message, $subject, $redirect) {
			
			$this->email->from($email, $name);
			$this->email->to('jason@openskymedia.com');
			$this->email->subject($subject);		
			$this->email->message($message);

			if($this->email->send())
			{
				//echo 'Your email was sent, fool.';
				redirect($redirect);
			}

			else
			{
				show_error($this->email->print_debugger());
			}
	}


}
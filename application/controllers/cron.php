<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Pancake
 *
 * A simple, fast, self-hosted invoicing application
 *
 * @package		Pancake
 * @author		Pancake Dev Team
 * @copyright	Copyright (c) 2010, Pancake Payments
 * @license		http://pancakeapp.com/license
 * @link		http://pancakeapp.com
 * @since		Version 1.0
 */

// ------------------------------------------------------------------------

/**
 * The javascript controller
 *
 * @subpackage	Controllers
 * @category	Javascript
 */
class Cron extends CI_Controller {
	
	public function invoices()
	{
		$this->load->model('invoice_model');

		$table = $this->db->dbprefix('invoices');
		
		$invoices = $this->db->query('
			SELECT `id`, `unique_id`, recur_id
			FROM ('.$table.' i)
			WHERE `is_recurring` = 1
			AND i.id =
			(
				SELECT i2.id
				FROM '.$table.' i2
				WHERE i2.recur_id = i.recur_id
				ORDER BY i2.date_entered DESC, id DESC
				LIMIT 1
			)', array($table, $table))
			->result_array();

		foreach ($invoices as $invoice)
		{
			// Get EEEEEVERYTHING
			$invoice = $this->invoice_m->get($invoice['unique_id']);

			switch ($invoice['frequency'])
			{
				case 'w':
					if (strtotime('-1 week') < $invoice['date_entered'])
					continue 2;

					$invoice['due_date'] = strtotime('+1 week', $invoice['due_date']);
				break;

				case 'm':
					if (strtotime('-1 month') < $invoice['date_entered'])
					continue 2;

					$invoice['due_date'] = strtotime('+1 month', $invoice['due_date']);
				break;
				
				case 'y':
					if (strtotime('-1 year') < $invoice['date_entered'])
					continue 2;

					$invoice['due_date'] = strtotime('+1 year', $invoice['due_date']);
				break;
			}
			
			$id = $this->invoice_m->insert(array(
				'client_id'			=> $invoice['client_id'],
				'amount'			=> $invoice['amount'],
				'due_date'			=> date('Y-m-d', $invoice['due_date']),
				'invoice_number'	=> '',
				'notes'				=> $invoice['notes'],
				'description'		=> isset($invoice['description']) ? $invoice['description'] : '',
				'type'				=> $invoice['type'],
				'is_paid'			=> 0,
				'payment_date'		=> 0,
				'is_recurring'		=> 1,
				'frequency'			=> $invoice['frequency'],
				'auto_send'			=> $invoice['auto_send'],
				'recur_id'			=> $invoice['recur_id'],

				'items'				=> $invoice['items']
			));

			if ($id)
			{
				echo "Created invoice: {$id}" . (IS_CLI ? PHP_EOL : '<br/>');
			}

			else
			{
				echo "Failed to create clone of {$invoice['recur_id']}" . (IS_CLI ? PHP_EOL : '<br/>');
			}
		}

		echo '-- Finished --';
	}
}

/* End of file cron.php */
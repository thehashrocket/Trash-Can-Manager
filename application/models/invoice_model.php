<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Jason Shultz
 * Date: 1/11/11
 * Time: 2:36 PM
 */


// ------------------------------------------------------------------------

/**
 * The payments model
 *
 * @subpackage	Models
 * @category	Payments
 */
class Invoice_model extends CI_Model
{
    /**
	 * @var	string	The payments table name
	 */
	protected $table = 'invoices';
    
    /**
	 * Generates an invoice number
	 *
	 * @access	private
	 * @return	string
	 */

    /**
	 * @var string	The table that contains the invoice rows
	 */
	protected $rows_table = 'invoice_rows';


	public function _generate_invoice_number()
	{
		$this->load->helper('string');

		$valid = FALSE;
		while ($valid === FALSE)
		{
			$invoice_number = random_string('numeric', 6);
			$results = $this->db->where('invoice_number', $invoice_number)->get($this->table)->result();
			if (empty($results))
			{
				$valid = TRUE;
			}
		}

		return $invoice_number;
	}

    /**
	 * Generates the unique id for an invoice
	 *
	 * @access	private
	 * @return	string
	 */
	public function _generate_unique_id()
	{
		$this->load->helper('string');

		$valid = FALSE;
		while ($valid === FALSE)
		{
			$unique_id = random_string('alnum', 8);
			$results = $this->db->where('unique_id', $unique_id)->get($this->table)->result();
			if (empty($results))
			{
				$valid = TRUE;
			}
		}

		return $unique_id;
	}

    public function insertInvoice($userid, $custid, $invoicenumber, $invoice_items, $notes, $ispaid, $is_recurring, $frequency, $autosend, $description, $unique_id, $goback)
    {
        $data = array(
            'unique_id'         => $unique_id,
            'custid'            => $custid,
            'invoice_number'    => $invoicenumber,
            'notes'             => $notes,
            'description'       => $description,
            'date_entered'      => time(),
            'userid'            => $userid,
            'is_recurring'      => $is_recurring,
        );

        $this->db->insert('invoices', $data);

        $insert_id = $this->db->insert_id();

        // If no invoice # is provided, then use the insert_id for the invoice #

        if ( empty($invoicenumber) )
        {
            $this->db->where('unique_id', $unique_id)
                    ->set('invoice_number', $insert_id)
                    ->update($this->table);
        }




        $this->insertInvoiceRows($userid, $custid, $invoicenumber, $invoice_items, $unique_id);


        redirect($goback);

    }

    public function insertInvoiceRows($userid, $custid, $invoicenumber, $invoice_items, $unique_id)
    {

        $items_array = array();

        for ($i = 0; $i < count($invoice_items['trashcan']); $i++)
        {
            $qty = $invoice_items['quantity'][$i];
            $trashcan = $invoice_items['trashcan'][$i];
            $userid = $userid;
            $custid = $custid;

            $items_array[] = array(
                'quantity'      =>  $qty,
                'trashsizeid'   =>  $trashcan,
                'userid'        =>  $userid,
                'custid'        =>  $custid,
            );

            $items_array2[] = array(
                'unique_id'     => $unique_id,
                'description'   => $this->Client_model->getTrashCanName($trashcan),
                'qty'           => $qty,
            );
            
        }

        $items = $items_array;

        foreach ($items as $item)
        {
            $this->db->insert('custtrashcans', $item);
        }

        $items2 = $items_array2;

        foreach ($items2 as $item)
        {
            $this->db->insert('invoice_rows', $item);
        }
        
    }

    public function get_all_overdue($custid = NULL) {
        $userid = $this->tank_auth->get_user_id();

        $this->db->select("invoices.*, custname.firstname, custname.lastname, custname.custid, custname.userid")
                ->where(array('invoices.is_paid' =>0, 'due_date <' =>time()))
                ->where('custname.userid',$userid)
                ->from('invoices')
                ->join('custname', 'invoices.custid = custname.custid');

        return $this->db->get();
}

}

/* End of file: invoices_m.php */
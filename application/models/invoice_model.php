<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Jason Shultz
 * Date: 1/11/11
 * Time: 2:36 PM
 */
 
class Invoice_model extends CI_Model {

    /**
	 * @var	string	The payments table name
	 */
	protected $table = 'invoices';

	/**
	 * @var string	The table that contains the invoice rows
	 */
	protected $rows_table = 'invoice_rows';

    public function get_all_overdue($custid = NULL) {
        $userid = $this->tank_auth->get_user_id();

        $this->db->select("invoices.*, custname.firstname, custname.lastname, custname.custid, custname.userid")
                ->where(array('invoices.is_paid' =>0, 'due_date <' =>time()))
                ->where('custname.userid',$userid)
                ->from($this->table)
                ->join('custname', 'invoices.custid = custname.custid');

        return $this->db->get();
    }

}

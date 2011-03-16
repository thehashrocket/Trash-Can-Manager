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
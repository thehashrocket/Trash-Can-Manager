<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Jason Shultz
 * Date: 2/11/11
 * Time: 12:52 PM
 */
 
class Client_model extends CI_Model {

    function getClient() {
        $userid = $this->tank_auth->get_user_id();
        $this->db->select('c.companyname, c.costreet, c.cocity, c.costate, c.cozip, c.cophone, c.userid');
        $this->db->where('c.userid', $userid);
        $this->db->from('clients as c');
        $q = $this->db->get();

        if($q->num_rows() == 0)
        {
            $query = array(
                'companyname' => 'New Company',
                'costreet' => 'New Street',
                'cocity' => 'New City',
                'costate' => 'New State',
                'cozip' => 'New Zip',
                'cophone' => 'New Phone'
                    );
            $query = (object) $q;
            return $query;
        }

        else
        return $q->row();
    }

    function updateClient($userid, $companyname, $costreet, $cocity, $costate, $cozip, $cophone, $goback) {
        $this->db->select('c.companyname, c.costreet, c.cocity, c.costate, c.cozip, c.cophone, c.userid');
        $this->db->where('c.userid', $userid);
        $this->db->from('clients as c');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            /* Update Client */

            $data1 = array(
                'companyname' => $companyname,
                'costreet' => $costreet,
                'cocity' => $cocity,
                'costate' => $costate,
                'cozip' => $cozip,
                'cophone' => $cophone,
                'userid' => $userid
            );

            $this->db->where('userid', $userid);
            $this->db->update('clients', $data1);

            redirect($goback);
        }

        /* Create Custpomer */
        else {
            $data2 = array(
                'companyname' => $companyname,
                'costreet' => $costreet,
                'cocity' => $cocity,
                'costate' => $costate,
                'cozip' => $cozip,
                'cophone' => $cophone,
                'userid' => $userid
            );

            $this->db->insert('clients', $data2);

            redirect($goback);
        }
    }

    function getTrashCans() {
        $userid = $this->tank_auth->get_user_id();
        $this->db->select('*');
        $this->db->from('trashcans');
        $this->db->where('userid', $userid);
        return $this->db->get();
    }

    function archiveTrashCan($user_id, $idtrashcans, $goback) {
        $this->db->select('*');
        $this->db->from('trashcans');
        $this->db->where('userid', $user_id);
        $this->db->where('idtrashcans', $idtrashcans);
        $data = array(
            'is_archived'=>'1'
        );
        $this->db->update('trashcans', $data);
        redirect($goback);
    }

    function updateTrashCan($userid, $idtrashcans, $cansize, $cantype, $price, $description, $goback) {
        $this->db->select('*');
        $this->db->where('idtrashcan', $idtrashcans);

        $this->db->from('trashcans');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            /* Update Client */

            $data1 = array(
                'userid' => $userid,
                'idtrashcans' => $idtrashcans,
                'cansize' => $cansize,
                'cantype' => $cantype,
                'price' => $price,
                'description' => $description,
            );

            $this->db->where('idtrashcans', $idtrashcans);
            $this->db->update('trashcans', $data1);

            redirect($goback);
        }

        /* Create Custpomer */
        else {
            $data2 = array(
                'userid' => $userid,
                'cansize' => $cansize,
                'cantype' => $cantype,
                'price' => $price,
                'description' => $description
            );

            $this->db->insert('trashcans', $data2);

            redirect($goback);
        }
    }

}
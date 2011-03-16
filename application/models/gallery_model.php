<?php
/**
 * The Gallery Model handles Images. It is not currently being used.
 * Created by JetBrains PhpStorm.
 * User: Jason Shultz
 * Date: 2/11/11
 * Time: 12:52 PM
 */

class Gallery_model extends CI_Model {
	
	var $gallery_path;
	var $gallery_path_url;
	
	
	function Gallery_model() {
		
		
		$this->gallery_path = realpath(APPPATH . '../assets/images/gallery');
		$this->gallery_path_url = base_url().'assets/images/gallery/';
	}
	
	/* Uploads images to the site and adds to the database. */
	function do_upload($projid) {
		
		$config = array(
			'allowed_types' => 'jpg|jpeg|gif|png',
			'upload_path' => $this->gallery_path,
			'max_size' => 2000
		);
		
		$this->load->library('upload', $config);
		$this->upload->do_upload();
		$image_data = $this->upload->data();
		
		$config = array(
			'source_image' => $image_data['full_path'],
			'new_image' => $this->gallery_path . '/thumbs',
			'maintain_ratio' => true,
			'width' => 150,
			'height' => 100
		);
		
		$this->load->library('image_lib', $config);
		$this->image_lib->resize();
		
		$upload = $this->upload->data();
		/*$bus_id = $this->get_bus_id();*/
		
		/*
        TABLE STRUCTURE =============
            id, the row ID
            photoname
            thumb
            fullsize
            projid
            userid
        */
		

		
		$data = array(
            'id'        => 0 , // I GUESS IS AUTO_INCREMENT
            'photoname'    => '',
            'thumb'        => $this->gallery_path_url . 'thumbs/' . $upload['file_name'],
            'fullsize'    => $this->gallery_path_url . $upload['file_name'],
            'projid'=> $projid,
            'userid' => $this->tank_auth->get_user_id(),
        );
		
		// CHECK THE DATA CREATED FOR INSERT
		
		$this->db->insert('photos', $data);
	}
	



	/* Displays Images on a page */
	
	function get_images() {
		
		$files = scandir($this->gallery_path);
		$files = array_diff($files, array('.', '..', 'thumbs'));
		
		$images = array();
		
		foreach ($files as $file) {
			$images []= array (
				'url' => $this->gallery_path_url . $file,
				'thumb_url' => $this->gallery_path_url . 'thumbs/' . $file
			);
		}
		
		return $images;
	}
	
	function get_images_from_db($id) {
		$user = $this->tank_auth->get_user_id();
		$this->db->select('p.id, p.fullsize, p.thumb, p.userid, p.projid');
		$this->db->from('photos as p');
		$this->db->where('p.projid', $id);
		return $this->db->get();
	}

    function public_get_images_from_db($id) {
		$this->db->select('p.fullsize, p.thumb, p.userid, p.projid');
		$this->db->from('photos as p');
		$this->db->where('p.projid', $id);
		return $this->db->get();
	}

    function get_thumbnails($id) {
        $this->db->select('i.projid, i.thumb,p.id,p.catid');
        $this->db->from('projects as p');
        $this->db->where('p.catid', $id);
        $this->db->join('photos as i', 'i.projid = p.id', 'left');
        return $this->db->get();
    }
	
	function profile_get_images_from_db($id) {
		$user = $this->tank_auth->get_user_id();
		$this->db->select('p.fullsize, p.thumb, p.userid, p.projid');
		$this->db->from('photos as p');
		$this->db->where('p.userid', $user);
		return $this->db->get();
		
	}
	
	function get_video_from_db($id) {
		$user = $this->tank_auth->get_user_id();
		$this->db->select('v.id, v.title, v.link, v.busid');
		$this->db->from('video as v');
		$this->db->where('v.busid', $id);
		$this->db->limit(1);
			// get the results.. cha-ching
			return $this->db->get();
			
			// any results?
			if($q->num_rows() !== 1)
			{
			return FALSE;
			}
			
			return $this->db->get();
		
	}
	
	function profile_get_video_from_db($id) {
		$user = $this->tank_auth->get_user_id();
		$this->db->select('v.id, v.title, v.link, v.busid');
		$this->db->from('video as v');
		$this->db->where('v.userid', $user);
		$this->db->limit(1);
			// get the results.. cha-ching
			return $this->db->get();
			
			// any results?
			if($q->num_rows() !== 1)
			{
			return FALSE;
			}
			
			return $this->db->get();
		
	}
	
/*	function get_bus_id() {
        $userid = $this->tank_auth->get_user_id();
        $this->db->select('b.id');
        $this->db->from ('business AS b');
        $this->db->where ('b.userid', $userid);
        $query = $this->db->get();
            if ($query->num_rows() > 0) {
              // RESULT ARRAY RETURN A MULTIDIMENSIONAL ARRAY e.g. ARRAY OF DB RECORDS
              // ( ROWS ), SO IT DOENS'T FIT
              //return $query->result_array();
              // THE CORRECT METHOD IS row_array(), THAT RETURN THE FIRST ROW OF THE
              // RECORDSET
              return $query->row_array();
            }
        }*/
		
	function updateVideo($videoid, $redirect, $userid, $busid) {
		
	$user = $this->tank_auth->get_user_id();
	
	$this->db->select('v.id');
	$this->db->from ('video AS v');
	$this->db->where ('v.busid', $busid);
	$query = $this->db->get();
	
		if ($query->num_rows() > 0) {
			$data = array(
				'link' => $videoid,
				'busid' => $busid,
				'userid' => $user,
				);
			$this->db->select('v.id');
			$this->db->from ('video AS v');
			$this->db->where ('busid', $busid);
			$this->db->update('video', $data);
		}
		
		else {
			$data = array(
				'link' => $videoid,
				'busid' => $busid,
				'userid' => $user,
				);
			$this->db->insert('video', $data);
			
		}
	
	$goback = $redirect . '/' . $busid;
	
	redirect($goback);
}
		

	
}




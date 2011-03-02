<?php

class Projects_model extends CI_Model {


    function getProject($id) {
        $this->db->select('*');
        $this->db->from('projects');
        $this->db->where('id',$id);
        return $this->db->get();
    }
    
function getProjList() {

	$this->db->select('*');

    $this->db->from('projects');

    return $this->db->get();			
			
	}

function getProjListByID($id) {

	$this->db->select('*');

    $this->db->from('projects');

    $this->db->where('catid', $id);

    return $this->db->get();

	}

function get_proj_with_thumbnail($id) {
        $this->db->select('i.projid, i.thumb,p.id,p.catid,p.projname,p.projshortdesc');
        $this->db->from('projects as p');
        $this->db->where('p.catid', $id);
        $this->db->join('photos as i', 'i.projid = p.id', 'left');
        $this->db->group_by('p.id');
        return $this->db->get();
    }

function getCategoryByID($id) {

	$this->db->select('*');

    $this->db->from('categories');

    $this->db->where('id', $id);

    return $this->db->get();

	}

function getCategories() {

      $this->db->select('*');

      $this->db->from('categories');

      return $this->db->get();

  }
  
  function createProject($name, $shortdesc, $description, $systemfacts, $category, $redirect)
  {
	  $data = array(
	  'projname' => $name,
      'projshortdesc' => $shortdesc,
	  'projdesc' => $description,
      'projsystemfacts' => $systemfacts,
	  'catid' => $category,
	  );
	  
	  $this->db->insert('projects', $data);
	  
	  $goback = $redirect . '/';
	  
	  redirect($goback);
  
  }
  
  function updateProject($id, $name, $shortdesc, $description, $systemfacts, $category, $redirect)
  {
	  $this->db->select('p.id');
	  $this->db->from('projects AS p');
	  $this->db->where('p.id', $id);
	  $query= $this->db->get();
	  
	  if ($query->num_rows() > 0) {
		  $data = array(
            'projname' => $name,
            'projshortdesc' => $shortdesc,
              'projsystemfacts' => $systemfacts,
            'projdesc' => $description,
            'catid' => $category,
		  );
		$this->db->where('id', $id);
		$this->db->update('projects', $data);
	  }
	  
	  else {
		  
		  $data = array(
			  'projname' => $name,
              'projshortdesc' => $shortdesc,
			  'projdesc' => $description,
              'projsystemfacts' => $systemfacts,
			  'catid' => $category,
	  );
	  
	  $this->db->insert('projects', $data);
	  
	  }

	$goback = $redirect . '/';
	
	redirect($goback);

  }

}
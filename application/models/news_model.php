<?php

class News_model extends CI_Model {


    function getNews($id) {
        $this->db->select('*');
        $this->db->from('news');
        $this->db->where('id',$id);
        return $this->db->get();
    }
    
function getNewsList() {

	$this->db->select('*');

    $this->db->from('news');

    return $this->db->get();			
			
	}


  
  function createNews($headline, $story, $redirect)
  {
	  $data = array(
	  'headline' => $headline,
      'story' => $story,
	  );
	  
	  $this->db->insert('news', $data);
	  
	  $goback = $redirect . '/';
	  
	  redirect($goback);
  
  }
  
  function updateNews($id, $headline, $story, $redirect)
  {
	  $this->db->select('n.id');
	  $this->db->from('news AS n');
	  $this->db->where('n.id', $id);
	  $query= $this->db->get();
	  
	  if ($query->num_rows() > 0) {
		  $data = array(
            'headline' => $headline,
            'story' => $story,
		  );
		$this->db->where('id', $id);
		$this->db->update('news', $data);
	  }
	  
	  else {
		  
		  $data = array(
            'headline' => $headline,
            'story' => $story,
	  );
	  
	  $this->db->insert('news', $data);
	  
	  }

	$goback = $redirect . '/';
	
	redirect($goback);

  }

}
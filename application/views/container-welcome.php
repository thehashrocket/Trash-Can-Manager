<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php
$this->load->view('meta');
?>
</head>
<body>



<?php
		  $this->load->view('header-welcome');
		  $this->load->view($page);
		  $this->load->view('footer');
?>

<script type="text/javascript">
  jQuery(document).ready(function(){
    jQuery('.lightbox').lightbox();
  });
</script>
</body>
</html>
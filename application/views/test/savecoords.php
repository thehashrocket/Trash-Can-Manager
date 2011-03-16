<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Test Geolocation</title>
<meta name="description" content="Trash Can Manager is the complete solution for Billing and Customer Relationship Management for Waste Management and Garbage Companies" />
<meta name="keywords" content="trash can garbage manager billing customer relation relationship manager management invoice invoicing contact" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<!-- jquery loading -->
<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/redmond/jquery-ui.css" rel="stylesheet" type="text/css"/>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
<!-- end jquery lading -->

<link rel="shortcut icon" href="/favicon.ico" />
<link href="/assets/blueprint/screen.css" rel="stylesheet" type="text/css" />
<link href="/assets/blueprint/markup.css" rel="stylesheet" type="text/css" />

<?php echo $headerjs; ?>
<?php echo $headermap; ?>


</head>
<body>
<script type="text/javascript">
    $(document).ready(function(){
  get_location();
});
function get_location() {
  if (Modernizr.geolocation) {
    navigator.geolocation.getCurrentPosition(register_coords);
  } else {
    // no native support; maybe try Gears?
  }
}
function register_coords(position) {
  var latitude = position.coords.latitude;
  var longitude = position.coords.longitude;
  // use jquery or your own preference to send the values to CI
  $.post('/test/savecoords/', { latitude:latitude, longitude:longitude }, function(){
    // some optional callback
  });
}

</script>


<?php echo $onload; ?>
                <?php echo $map; ?>
                <?php echo $sidebar; ?>

</body>
</html>
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









</head>

<body>

<script type="text/javascript">

    if(navigator.geolocation) {

        if(navigator.geolocation) {

            navigator.geolocation.getCurrentPosition(function(position) {

                alert('Your lat-long is: ' + position.coords.latitude + ' / ' + position.coords.longitude);

                alert('You live in ' + position.address.city + ', ' + position.address.state)

            });

        }



    }

    else {

        alert('No soup for you!  Your browser does not support this feature');

    }



</script>

<?php



$uagent = new uagent();



print('<pre>');

print_r($uagent->get_user_agent($_SERVER['HTTP_USER_AGENT']));

print('</pre>');



print('<pre>');

print_r($uagent->get_hostname($uagent->get_ipaddress()));

print('</pre>');



print('<pre>');

print_r($uagent->get_geoip($uagent->get_ipaddress()));

print('</pre>');



?>



</body>

</html>
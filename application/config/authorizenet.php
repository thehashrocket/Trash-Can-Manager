<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Config File For Authorize.Net Merchant Gateway
|--------------------------------------------------------------------------
|
| URL to your CodeIgniter root. Typically this will be your base URL,
| WITH a trailing slash:
|
|
|
| If this is not set then CodeIgniter will guess the protocol, domain and
| path to your installation.
|
*/

$authLogId = '';
$authTranKey = '';

define("AUTHORIZENET_API_LOGIN_ID",$authLogId);
define("AUTHORIZENET_TRANSACTION_KEY",$authTranKey);
define("AUTHORIZENET_SANDBOX",true);
$METHOD_TO_USE = "AIM";


/* End of file authorizenet.php */
/* Location: ./application/config/authorizenet.php */

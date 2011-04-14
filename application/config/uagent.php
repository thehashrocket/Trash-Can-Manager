<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**

 * Uagent

 * 

 * User Agent detection library for CodeIgniter.

 * by Vlad V Vlasceanu

 * Web page: http://www.vvvlad.com/resources/uagent

 * Contact the author at: http://www.vvvlad.com/contact

 * 

 * PROVIDES:

 * 1. User Agent Detection

 * 2. Hostname Lookup based on the IP address

 * 3. Geographical IP localization

 * 

 * READ THE README.TXT FILE FOR IMPORTANT DETAILS

 * 

 * LICENSE: This library is free software; you can redistribute it and/or

 * modify it under the terms of the GNU Lesser General Public

 * License as published by the Free Software Foundation; either

 * version 2.1 of the License, or (at your option) any later version.

 * 

 * This library is distributed in the hope that it will be useful,

 * but WITHOUT ANY WARRANTY; without even the implied warranty of

 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU

 * Lesser General Public License for more details.

 * 

 * You should have received a copy of the GNU Lesser General Public

 * License along with this library; if not, write to the Free Software

 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA

 * 

 * ACKNOWLEDGEMENTS:

 * Based on PHP Browscap v0.7 by Jonathan Stoppani

 * available at: http://code.google.com/p/phpbrowscap/

 * 

 * Host name lookup code based largely on code published in the PHP manual by

 * marco.ceppi@seacrow.org  

 * 

 * Special thanks go to Gary Keith and his Browser Capabilities Project

 * at http://browsers.garykeith.com/ for providing a comprehensive browser

 * signature database.

 * 

 * Special thanks go to the people at IPinfoDB and MaxMind for providing

 * a free and reliable ip geolocation database. More info at:

 * http://ipinfodb.com/index.php

 * 

 * @package		User Agent

 * @author		Vlad Vlasceanu

 * @since			Version 0.95

 * @filesource

 */



/*

|--------------------------------------------------------------------------

| Shared Framework Config

|--------------------------------------------------------------------------

*/



// print debug messages on screen?

$config['sf_osd_debug'] = false;



// permissions to use when saving files

$config['sf_file_write_mode'] = 0666;



// cURL remote connection timeout

$config['sf_curl_timeout'] = 10;



// the user agent string to use when connecting to remote sources

$config['sf_curl_user_agent'] = 'Mozilla/5.0 (compatible; cURL) UAgent/{{version}}';



/*

|--------------------------------------------------------------------------

| Uagent Config

|--------------------------------------------------------------------------

*/



// exit on fatal errors?

$config['ua_error_fatal'] = false;



// cache folder, must have write permission

$config['ua_cache_dir'] = BASEPATH . 'cache/';



// name of the ini file

$config['ua_ini_file'] = 'browscap.ini';



// name of the index file

$config['ua_index_file'] = 'browscap.index.php';



// enable automatic update of the signatures?

$config['ua_enable_updates'] = true;



// update interval = X seconds

$config['ua_update_interval'] = 30 * 24 * 60 * 60;



// on error, retry every X seconds

$config['ua_error_interval'] = 5 * 24 * 60 * 60;



// update from: remote or local

$config['ua_update_method'] = 'remote';



// path to local update file

$config['ua_local_ini_file'] = '/path/to/file/browscap.ini';



// path to remote update file

$config['ua_remote_ini_url'] = 'http://browsers.garykeith.com/stream.asp?Lite_BrowsCapINI';



// path to remote version file

$config['ua_remote_ver_url'] = 'http://updates.browserproject.com/version-date.asp';



// enable only lowercase indexes in the result. The cache has to be rebuilt in order to apply this option.

$config['ua_lowercase'] = true;



// keep index loaded, useful if multiple ua checks are performed

$config['ua_keep_index_loaded'] = true;



// use the unix native lookup command? otherwise use the php built-in function

$config['ua_unix_nslookup'] = false;



// Use the x-forwarded-for header to get the client IP address if the client accesses the sit using a proxy.

$config['ua_detect_proxy'] = true;



// automatically detect user agent of request on object init

$config['ua_auto_user_agent'] = false;



// automatically detect host name of request on object init

$config['ua_auto_hostname'] = false;



// automatically geolocate ip address of request on object init

$config['ua_auto_geoip'] = false;



// database that contains the geoip tables

$config['ua_geoip_db'] = 'trashcan_trashdb';



// mysql username - only useful when runnig the library in non-CI mode (native)

$config['ua_geoip_dbuser'] = '';



// mysql password - only useful when runnig the library in non-CI mode (native)

$config['ua_geoip_dbpass'] = '';



// mysql server - only useful when runnig the library in non-CI mode (native)

$config['ua_geoip_host'] = '';



// use a custom query to find geo data. Useful if you're not using the standard tables, the library will replace "?" with the requested ip address at runtime, e.g. SELECT * FROM table WHERE ip = ?

$config['ua_geoip_custom_sql'] = '';


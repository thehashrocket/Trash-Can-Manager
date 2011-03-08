<?php
/**
 * Shared Framework
 * 
 * Provides common functions and methods
 * by Vlad V Vlasceanu
 * Web page: http://www.vvvlad.com/resources/uagent
 * Contact the author at: http://www.vvvlad.com/contact
 * 
 * PROVIDES:
 * 1. cURL based remote fetch
 * 2. Error reporting and logging
 * 3. CodeIgniter Interfacing
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
 * @package		User Agent
 * @author		Vlad Vlasceanu
 * @since			Version 0.95
 * @filesource
 */

// ------------------------------------------------------------------------

// Shared Framework inheritable class
class Shared_Framework {
	const VERSION = '0.96';
	protected $CI_MODE = false;
	protected $CI;
	protected $params;
	
	// constructor
	public function __construct($params) {
		// set mode
		if (defined('BASEPATH')) { $this->CI_MODE = true; }
		
		// link to CI, save params
		if ($this->CI_MODE) { $this->CI =& get_instance(); }
		else { $this->params = $params; }
		
		// debug
		$this->log_message("Shared Framework->initialized;");
	}
	
	// save file
	public function save_file($file, $content) {
		// only if you can access file
		if (@touch($file)) {
			// set mode
			$mode = $this->param('sf_file_write_mode'); if (!$mode) { $mode = 0666; }
			
			// save file
			$res = @file_put_contents($file, $content);
			if ($res === false) {
				$this->log_message("Shared Framework->safe_file({$file}) ~ could not save file;");
				return false;
			} else {
				// update file mode
				$res = @chmod($file, $mode);
				if ($res === false) {
					$this->log_message("Shared Framework->safe_file({$file}) ~ could not apply permissions;");
					return false;
				}	else {
					$this->log_message("Shared Framework->safe_file({$file}) ~ file saved;");
					return true;
				}
			}
		} else {
			$this->log_message("Shared Framework->safe_file({$file}) ~ check permissions cannot write file on disk;");
			return false;
		}
	}
	
	// get remote file
	public function get_remote_url($url) {
		if (extension_loaded('curl')) {
			// set timout & user agent
			$timeout = $this->param('sf_curl_timeout'); if (!$timeout) { $timeout = 5; }
			$ua = $this->param('sf_curl_user_agent'); if (!$ua) { $ua = 'Mozilla/5.0 (compatible; cURL) Shared Framework/{{version}}'; }
			
			// start curl session
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
			curl_setopt($ch, CURLOPT_USERAGENT, str_replace('{{version}}', self::VERSION, $ua));
			
			// execute
			$return = curl_exec($ch);
			$code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			curl_close($ch);
			if ($code != 200) {
				$this->log_message("Shared Framework->get_remote_url({$url}) ~ http_code: {$code} returned;");
				return false;
			} else {
				$this->log_message("Shared Framework->get_remote_url({$url}) ~ success;");
				return trim($return);
			}
		} else {
			$this->log_message("Shared Framework->get_remote_url({$url}) ~ cURL extension, not installed, loaded or accessible;");
			return false;
		}
	}

	// error
	public function error($message, $die = true) {
		if ($this->CI_MODE) { log_message('error', $message); }
		if ($this->param('sf_osd_debug')) { print("$message<br/>"); }
		if ($die) { exit; }
	}

	// config value
	protected function param($key) {
		if ($this->CI_MODE) { return $this->CI->config->item($key); }
		else { return $this->params[$key]; }
	}
	
	// convert array to string
	protected function array2string($array) {
		$strings = array();
		foreach ((array)$array as $key => $value) {
			if (is_int($key)) { $key	= ''; }
			elseif (ctype_digit((string) $key) || strpos($key, '.0')) { $key 	= intval($key) . '=>' ; }
			else { $key 	= "'" . str_replace("'", "\'", $key) . "'=>" ; }
			if (is_array($value)) { $value	= $this->array2string($value); }
			elseif (ctype_digit((string) $value)) { $value 	= intval($value); }
			else { $value 	= "'" . str_replace("'", "\'", $value) . "'"; }
			$strings[]	= $key . $value;
		}
		return 'array(' . implode(',', $strings) . ')';
	}
	
	// log message
	protected function log_message($message, $mode = 'debug') {
		if ($this->CI_MODE) { log_message($mode, $message); }
		if ($this->param('sf_osd_debug')) { print("$message<br/>"); }
	}
}

// END Shared_Framework class

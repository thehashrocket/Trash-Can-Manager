<?php
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

// ------------------------------------------------------------------------

// User Agent Detection Class
class Uagent extends Shared_Framework {
	const VERSION = '0.96';
	const REGEX_DELIMITER = '@';
	const REGEX_MODIFIERS = 'i';
	const VALUES_TO_QUOTE = 'Browser|Parent';
	const ORDER_FUNC_ARGS = '$a, $b';
	const ORDER_FUNC_LOGIC = '$a=strlen($a);$b=strlen($b);return$a==$b?0:($a<$b?1:-1);';

	protected $index_loaded = false;
	protected $index_file = null;
	protected $ini_file = null;
	protected $user_agents = array();
	protected $browsers = array();
	protected $patterns = array();
	protected $properties = array();

	// constructor
	public function __construct($params = array()) {
		// init parent
		parent::__construct($params);

		// load extra configuration file
		if ($this->CI_MODE) { $this->CI->config->load('uagent'); }

		// has to be set to reach E_STRICT compatibility, does not affect system/app settings
		date_default_timezone_set(date_default_timezone_get());

		// debug
		$this->log_message("UAgent->initialized;");

		// automatically get user agent, hostname and geolocation data
		if ($this->param('ua_auto_user_agent')) { $this->get_user_agent(); }
		if ($this->param('ua_auto_hostname')) { $this->get_hostname(); }
		if ($this->param('ua_auto_geoip')) { $this->get_geoip(); }
	}

	// ::DEPRECATED::: function getUserAgent() - do not use anymore
	public function getUserAgent($user_agent = null) {
		return $this->get_user_agent($user_agent);
	}

	// get user agent
	public function get_user_agent($user_agent = null) {
		// set user agent;
		if (isset($user_agent) and strlen(trim($user_agent)) > 0) { $custom_ua = true; }
		$this->log_message("UAgent->get_user_agent({$user_agent});");

		// first load the index database
		if (!$this->index_loaded) { $this->load_index(); }

		// detect the user agent
		$browser = array();
		if ($this->index_loaded) {
			// which user agent do we process?
			if (!$custom_ua) {
				if (isset($_SERVER['HTTP_USER_AGENT'])) { $user_agent = $_SERVER['HTTP_USER_AGENT']; }
				else { $user_agent = ''; }
			}

			// debug
			$this->log_message("UAgent->get_user_agent({$user_agent}); ~ index loaded, processing ua string: {$user_agent}");

			// process user agent
			foreach ((array)$this->patterns as $key => $pattern) {
				if (preg_match($pattern . 'i', $user_agent)) {
					$browser = array($user_agent, trim(strtolower($pattern), self::REGEX_DELIMITER), $this->user_agents[$key]);
					$browser = $value = $browser + $this->browsers[$key];
					while (array_key_exists(3, $value) && $value[3]) {
						$value = $this->browsers[$value[3]];
						$browser +=  $value;
					}
					if (!empty($browser[3])) { $browser[3] = $this->user_agents[$browser[3]]; }
					break;
				}
			}
		}

		// add the keys for each property
		if ($custom_ua) {
			$array = array();
			foreach ((array)$browser as $key => $value) { $array[$this->properties[$key]] = $value; }
		} else {
			foreach ((array)$browser as $key => $value) { $this->{'UA_' . ucwords($this->properties[$key])} = $value; }
		}

		// debug
		$this->log_message("UAgent->get_user_agent({$user_agent}); ~ detection complete");

		// delete the index - free up some memory, useful if you're not planning to use it for subsequent calls
		if (!$this->param('ua_keep_index_loaded')) {
			$this->log_message("UAgent->get_user_agent({$user_agent}); ~ destrying index");

			$this->browsers = array();
			$this->user_agents = array();
			$this->patterns = array();
			$this->properties = array();
			$this->index_loaded = false;
		}

		// return user agent
		if ($custom_ua) { return $array; }
		else { return true; }
	}

	// ::DEPRECATED::: function nsLookup() - do not use anymore
	public function nsLookup($ip = null) {
		return $this->get_hostname($ip);
	}

	// get hostname
	public function get_hostname($ip = null) {
		// set ip;
		if (isset($ip) and strlen(trim($ip)) > 0) { $custom_ip = true; }
		$this->log_message("UAgent->get_hostname({$ip});");

		// which ip do we process?
		if (!$custom_ip) { $ip = $this->get_ipaddress(); }

		// validate ip
		if (!preg_match("/^(?:25[0-5]|2[0-4]\d|1\d\d|[1-9]\d|\d)(?:[.](?:25[0-5]|2[0-4]\d|1\d\d|[1-9]\d|\d)){3}$/", $ip)) {
			$this->log_message("UAgent->get_hostname({$ip}) ~ IP address doesn't look like a real IP address, validation failed;");
			return false;
		}

		// lookup ip address
		$result = '';
		if ($this->param('ua_unix_nslookup')) {
			$result = `host $ip`;
			$result = ($result) ? end(explode(' ', $result)) : $ip;
		} else {
			$result = gethostbyaddr($ip);
		}
		$this->log_message("UAgent->get_hostname({$ip}) ~ hostname detected: {$result};");

		if ($custom_ip) { return $result; }
		else { $this->UA_Hostname = $result; return true; }
	}

	// ::DEPRECATED::: function geoLookup() - do not use anymore
	public function geoLookup($ip = null) {
		return $this->get_geoip($ip);
	}

	// get geolocation data
	public function get_geoip($ip = null) {
		// set ip;
		if (isset($ip) and strlen(trim($ip)) > 0) { $custom_ip = true; }
		$this->log_message("UAgent->get_geoip({$ip});");

		// which ip do we process?
		if (!$custom_ip) { $ip = $this->get_ipaddress(); }

		// validate ip
		if (!preg_match("/^(?:25[0-5]|2[0-4]\d|1\d\d|[1-9]\d|\d)(?:[.](?:25[0-5]|2[0-4]\d|1\d\d|[1-9]\d|\d)){3}$/", $ip)) {
			$this->log_message("UAgent->get_geoip({$ip}) ~ IP address doesn't look like a real IP address, validation failed;");
			return false;
		}

		// lookup ip address
		$result = array();

		// build query
		if (strlen($this->param('ua_geoip_custom_sql')) > 0) { $sql = $this->param('ua_geoip_custom_sql'); }
		else { $sql = "SELECT l.*, ic.name AS country_name, fr.name AS region_name FROM " . $this->param('ua_geoip_db') . ".ip_group_city igc LEFT JOIN " . $this->param('ua_geoip_db') . ".locations l ON (igc.location = l.id) LEFT JOIN " . $this->param('ua_geoip_db') . ".iso3166_countries ic ON (ic.code = l.country_code)  LEFT JOIN " . $this->param('ua_geoip_db') . ".fips_regions fr ON (fr.country_code = l.country_code AND fr.code = l.region_code) WHERE igc.ip_start <= ? ORDER BY igc.ip_start DESC LIMIT 1";	}

		/// CI mode? or plain mode
		if ($this->CI_MODE) {
			$query = $this->CI->db->query($sql, array(sprintf("%u", ip2long($ip))));
			if ($query->num_rows() > 0) { $result = $query->row_array(); }
			$this->log_message("UAgent->get_geoip({$ip}) ~ running query in CI mode: " . $this->CI->db->last_query() . ";");
		} else {
			$cn = mysql_connect($this->param('ua_geoip_host'), $this->param('ua_geoip_dbuser'), $this->param('ua_geoip_dbpass'));
			if ($cn === false) {
				$this->error("UAgent->get_geoip() ~ cannot connect to database server", $this->param('ua_error_fatal'));
			} else {
				$db = mysql_select_db($this->param('ua_geoip_db'), $cn);
				if ($db === false) {
					$this->error("UAgent->get_geoip() ~ cannot select database", $this->param('ua_error_fatal'));
				} else {
					$sql = str_replace('?', "'" . mysql_real_escape_string(sprintf("%u", ip2long($ip))) . "'", $sql);
					$this->log_message("UAgent->get_geoip({$ip}) ~ running query in native mode: " . $sql . ";");
					$res = mysql_query($sql);
					if ($res !== false and mysql_num_rows($res)) { $result = mysql_fetch_assoc($res); }
				}
			}
		}

		// return results
		if ($custom_ip) {
			return $result;
		} else {
			foreach ((array)$result as $key => $value) { $this->{'GEO_' . ucfirst($key)} = $value; }
			return true;
		}
	}

	// figure out IP address
	public function get_ipaddress() {
		if ($this->param('ua_detect_proxy') and strlen(trim($_SERVER['HTTP_X_FORWARDED_FOR'])) > 0) {
			$tmp = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
			$ip = trim(reset($tmp));
		} else {
			$ip = $_SERVER['REMOTE_ADDR'];
		}

		$this->UA_IP_address = $ip;
		return $ip;
	}

	// load the indes
	protected function load_index() {
		$this->log_message("UAgent->load_index();");

		// init the cache directory path
		$cache = $this->param('ua_cache_dir');
		if ($cache == null) { $this->error("UAgent->load_index() ~ cache dir not set", $this->param('ua_error_fatal')); }
		else { $cache = realpath($cache) . DIRECTORY_SEPARATOR; }

		if (!is_dir($cache)) { $this->error("UAgent->load_index() ~ cache dir: {$cache} is not a directory", $this->param('ua_error_fatal')); }
		$this->log_message("UAgent->load_index() ~ using cache dir: {$cache};");

		// set the ini and index files
		$this->index_file = $this->param('ua_index_file'); if (!$this->index_file) { $this->index_file = 'browscap.php'; }
		$this->ini_file = $this->param('ua_ini_file'); if (!$this->ini_file) { $this->ini_file = 'browscap.ini'; }
		$this->index_file = $cache . $this->index_file;
		$this->ini_file = $cache . $this->ini_file;

		// debug
		$this->log_message("UAgent->load_index() ~ using index file: {$this->index_file};");
		$this->log_message("UAgent->load_index() ~ using ini file: {$this->ini_file};");

		// set the interval only if needed
		if ($this->param('ua_enable_updates') and file_exists($this->ini_file)) { $interval = time() - filemtime($this->ini_file); }
		else { $interval = 0; }
		$this->log_message("UAgent->load_index() ~ interval: {$interval};");

		// find out if the cache needs to be updated
		if (!file_exists($this->index_file) or !file_exists($this->ini_file) or ($interval > (integer)$this->param('ua_update_interval'))) {
			$this->log_message("UAgent->load_index() ~ preparing to update;");

			// update cache and deal with the event of failure
			$result = $this->update_index();
			if ($result === false) {
				$this->error("UAgent->load_index() ~ index update failed", $this->param('ua_error_fatal'));

				// try again in a few days
				$result = @touch($this->ini_file, time() + (integer)$this->param('ua_error_interval') - (integer)$this->param('ua_update_interval'));
				if ($result === false) {
					$this->error("UAgent->load_index() ~ ini file: {$this->ini_file} is not writable", $this->param('ua_error_fatal'));
				} else {
					$result = @chmod($this->ini_file, $this->param('sf_file_write_mode'));
					if ($result === false) {
						$this->error("UAgent->load_index() ~ ini file: {$this->ini_file} cannot change permissions", $this->param('ua_error_fatal'));
					} else {
						$this->log_message("UAgent->load_index() ~ scheduled another update try  later;");
					}
				}
			} else {
				$this->log_message("UAgent->load_index() ~ update success;");
			}
		}

		// load index
		if (file_exists($this->ini_file)) {
			$this->log_message("UAgent->load_index() ~ loading index db...;");
			require($this->index_file);
			$this->browsers = $browsers;
			$this->user_agents = $userAgents;
			$this->patterns = $patterns;
			$this->properties = $properties;
			$this->index_loaded = true;
		}
	}

	// update the index
	protected function update_index() {
		$this->log_message("UAgent->update_index();");

		if ($this->param('ua_update_method') == 'local') { $uri = $this->param('ua_local_ini_file'); }
		else { $uri = $this->param('ua_remote_ini_url'); }
		if (strlen($uri) < 1) { $this->error("UAgent->update_index() ~ update source is missing", $this->param('ua_error_fatal')); }

		// debug
		$this->log_message("UAgent->update_index(); ~ source: {$uri};");

		// local file timestamp
		$local_time = 0;
		if (file_exists($this->ini_file) and is_readable($this->ini_file) and filesize($this->ini_file)) { $local_time = filemtime($this->ini_file); }

		// get remote file timestamp
		$remote_time = 0;
		if ($this->param('ua_update_method') == 'local') {
			if (file_exists($uri) and is_readable($uri) and filesize($uri)) { $remote_time = filemtime($uri); }
			else { $this->error("UAgent->update_index() ~ update source: {$uri} is missing, unreadable or empty", $this->param('ua_error_fatal')); }
		} else {
			$ver_uri = $this->param('ua_remote_ver_url'); if (strlen($ver_uri) < 1) { $this->error("UAgent->update_index() ~ version url is missing", $this->param('ua_error_fatal')); }
			if (strlen($ver_uri)) {
				$temp = $this->get_remote_url($this->param('ua_remote_ver_url'));
				$temp = strtotime($temp);
				if ($temp > 0) { $remote_time = $temp; }
				else { $this->error("UAgent->update_index() ~ failed to get correct browscap version", $this->param('ua_error_fatal')); }
			}
		}

		// debug
		$this->log_message("UAgent->update_index(); ~ local ts: {$local_time} vs. remote ts: {$remote_time};");

		// no newer version on the server? update our timestamp
		if ($remote_time <= $local_time and file_exists($this->index_file)) {
			$this->log_message("UAgent->update_index(); ~ no need to update, no new version available;");
			$result = @touch($this->ini_file);
			if ($result === false) { $this->error("UAgent->update_index() ~ cannot update timestamp on local file: {$this->ini_file}", $this->param('ua_error_fatal')); }
			return true;
		}

		// debug
		$this->log_message("UAgent->update_index(); ~ get browscap file");

		// get browscap file
		if ($this->param('ua_update_method') == 'local') {
			$result = @copy($uri, $this->ini_file);
			if ($result === false) {
				$this->error("UAgent->update_index() ~ cannot copy file from: {$uri}", $this->param('ua_error_fatal'));
			} else {
				$result = @touch($this->ini_file);
				if ($result === false) {
					$this->error("UAgent->update_index() ~ cannot update timestamp on local file: {$this->ini_file}", $this->param('ua_error_fatal'));
				} else {
					$result = @chmod($this->ini_file, $this->param('sf_file_write_mode'));
					if ($result === false) {
						$this->error("UAgent->update_index() ~ ini file: {$this->ini_file} cannot change permissions", $this->param('ua_error_fatal'));
					}
				}
			}
		} else {
			$browscap = $this->get_remote_url($uri);
			if ($browscap === false) {
				$this->error("UAgent->update_index() ~ cannot download file from: {$uri}", $this->param('ua_error_fatal'));
				$content = '';
			} else {
				$browscap = explode("\n", $browscap);
				$pattern = self::REGEX_DELIMITER . '(' . self::VALUES_TO_QUOTE . ')="?([^"]*)"?$' . self::REGEX_DELIMITER;
				$content = '';
				foreach ((array)$browscap as $v) { $content .= preg_replace($pattern, '$1="$2"', trim($v)) . "\n"; }
				unset($browscap);
			}

			$result = $this->save_file($this->ini_file, $content);
			if ($result === false) {
				$this->error("UAgent->update_index() ~ cannot save file: {$this->ini_file}", $this->param('ua_error_fatal'));
			}
			unset($content);
		}

		// debug
		$this->log_message("UAgent->update_index(); ~ parse browscap file");

		// parse the new ini file
		if (file_exists($this->ini_file) and is_readable($this->ini_file)) {
			if (version_compare(PHP_VERSION, '5.3.0') >= 0) { $browsers = parse_ini_file($this->ini_file, true, INI_SCANNER_RAW); }
			else { $browsers = parse_ini_file($this->ini_file, true); }

			if ($browsers !== false) {
				array_shift($browsers);
				$this->properties = array_keys($browsers['DefaultProperties']);
				array_unshift($this->properties, 'browser_name', 'browser_name_regex', 'browser_name_pattern', 'Parent');
				$this->user_agents = array_keys($browsers);
				usort($this->user_agents, create_function(self::ORDER_FUNC_ARGS, self::ORDER_FUNC_LOGIC));
				$user_agents_keys = array_flip($this->user_agents);
				$properties_keys = array_flip($this->properties);
				$search = array('\*', '\?');
				$replace = array('.*', '.');

				foreach ((array)$this->user_agents as $user_agent) {
					$pattern = preg_quote($user_agent, self::REGEX_DELIMITER);
					$this->patterns[] = self::REGEX_DELIMITER . '^'  . str_replace($search, $replace, $pattern) . '$' . self::REGEX_DELIMITER;
					if (!empty($browsers[$user_agent]['Parent'])) {
						$parent = $browsers[$user_agent]['Parent'];
						$browsers[$user_agent]['Parent'] = $user_agents_keys[$parent];
					}

					foreach ((array)$browsers[$user_agent] as $k => $v) {
						$k = $properties_keys[$k] . ".0";
						if ($v == 'true') { $browser[$k] = true; }
						elseif ($v == 'false') { $browser[$k] = false; }
						else { $browser[$k] = $v; }
					}

					$this->browsers[] = $browser;
					unset($browser);
				}
				unset($user_agents_keys, $properties_keys, $browsers);

				// save the keys lowercase if configured as such
				if ($this->param('ua_lowercase')) {
					$this->properties = array_map('strtolower', $this->properties);
				}

				// debug
				$this->log_message("UAgent->update_index(); ~ generate index file");

				// build PHP code
				$cacheTpl = "<?php\n\$properties=%s;\n\$browsers=%s;\n\$userAgents=%s;\n\$patterns=%s;\n";
				$propertiesArray	= $this->array2string($this->properties);
				$patternsArray 		= $this->array2string($this->patterns);
				$userAgentsArray	= $this->array2string($this->user_agents);
				$browsersArray		= $this->array2string($this->browsers);
				$index = sprintf($cacheTpl, $propertiesArray, $browsersArray, $userAgentsArray, $patternsArray);

				// debug
				$this->log_message("UAgent->update_index(); ~ save index file");

				// save index file
				$result = $this->save_file($this->index_file, $index);
				if ($result === false) {
					$this->error("UAgent->update_index() ~ cannot save file: {$this->index_file}", $this->param('ua_error_fatal'));
				}

				// cleanup
				unset($index);
				unset($propertiesArray);
				unset($patternsArray);
				unset($userAgentsArray);
				unset($browsersArray);
				$this->properties = array();
				$this->patterns = array();
				$this->user_agents = array();
				$this->browsers = array();

				// return with success code
				return true;
			}
		} else {
			$this->error("UAgent->update_index() ~ cannot open file: {$this->ini_file}", $this->param('ua_error_fatal'));
		}

		// if we got here update was not successful
		return false;
	}
}

// END UAgent class

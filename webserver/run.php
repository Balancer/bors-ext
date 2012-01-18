<?php

bors_lib_php::add_include_path(BORS_3RD_PARTY.'/'.config('nanoserv_path'));
require_once 'nanoserv/handlers/HTTP/Server.php';

use \Nanoserv\Core as Nanoserv;
class dumb_httpd extends \Nanoserv\HTTP\Server
{
	public function on_Request($url)
	{
		if($this->request_content)
		{
//			echo "Request $url\n"; var_dump($this->request_headers); echo "\n\n";
//			var_dump($this->request_content);
			$post = bors_lib_http::parse_raw_http_request($this->request_content, $this->request_headers['CONTENT-TYPE']);
//			var_dump($post);
			$_POST = $post;
		}

		if(!file_exists($f = config('nanoserv_root').$url))
			$f = NULL;

		if(!$f && !file_exists($f = BORS_CORE.'/shared'.str_replace('/_bors/', '/', $url)))
			$f = NULL;

		if($f && is_file($f))
		{
			if(preg_match('/\.css$/', $f))
				$this->Set_Content_Type('text/css');
			else
				$this->Set_Content_Type(mime_content_type($f));
			return file_get_contents($f);
		}

		$server = new bors_lib_servers_nanoserv($this);
		$server->assign_url($url);
		$server->assign_request_headers();
		ob_start();
		$server->do_request();
		$result = ob_get_contents();
		ob_end_clean();

		bors_debug::syslog('nanoserv-access', "{$server->_remote_addr} - - ["
			.date('d/M/Y:H:i:s O') // 23/Nov/2010:14:04:16 +0300
			."] \"GET {$server->_url}".($server->_query ? "?{$server->_query}" : '')
			." HTTP/1.1\" ".$server->_status
			." ".strlen($result)
			." \"-\" \"{$server->_user_agent}\"", false, array('notime' => true));

		return $result;
	}

	function request_headers() { return $this->request_headers; }
}

// Replace [::] below with 0.0.0.0 for IPv4-only operation
//$l = Nanoserv::New_Listener("tcp://[::]:8800", "dumb_httpd");
$l = Nanoserv::New_Listener("tcp://0.0.0.0:8800", "dumb_httpd");

$l->Set_Forking();
$l->Activate();

error_reporting(error_reporting() & ~E_NOTICE);
echo "Nanoserv starts…\n";
Nanoserv::Run();

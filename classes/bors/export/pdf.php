<?php

class bors_export_pdf extends bors_object
{
	function render_engine() { return $this; }

	function render()
	{
		$body_url = 'http://aviaport.wrk.ru/events/maks2013/program/pdf/helper/?date=2013-08-29';

		$cover_url = 'http://aviaport.wrk.ru/events/maks2013/program/pdf/helper/cover.html';
		$file = tempnam('/tmp', 'pdfhelper');
//		header("X-PDF-INFO: /usr/local/bin/wkhtmltopdf-amd64 --cover $cover_url $helper_url $target_dir/$target_name");

		$bin = config('bin.wkhtmltopdf', '/opt/bin/wkhtmltopdf-amd64');

		if($args = config('bin.wkhtmltopdf.args'))
			$bin .= " $args ";

		$log_put = config('debug_hidden_log_dir').'/pdf-maker.log';

		if($h = $this->get('header_url'))
			$header = " --header-html $h";
		else
			$header = "";

		if($b = $this->get('body_url'))
			$body = " $b";
		else
			$body = " http://www.balancer.ru/";

//debug_hidden_log('--pdf', "$bin cover $cover_url $helper_url $target_dir/$target_name");
		system("$bin cover $cover_url $header $body $file &> $log_put");

		$pdf = file_get_contents($file);
		unlink($file);
		return $pdf;
	}

	function pre_show()
	{
		@header('Content-Type: application/pdf');

		echo $this->render($this);

//		@header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); 
//		@header('Cache-Control: no-store, no-cache, must-revalidate'); 
//		@header('Cache-Control: post-check=0, pre-check=0', false); 
//		@header('Pragma: no-cache');

		//$pdf = file_get_contents("$target_dir/$target_name");
		//unlink("$target_dir/$target_name");
		//return $pdf;

		return true;
	}
}

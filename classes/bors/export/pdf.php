<?php

/*
	Изучить:
		knplabs/knp-snappy
		PHP5 library allowing thumbnail, snapshot or PDF generation from a url or a html page. Wrapper for wkhtmltopdf/wkhtmltoimage.
		https://packagist.org/packages/knplabs/knp-snappy

		mikehaertl/phpwkhtmltopdf
		A slim PHP wrapper around wkhtmltopdf with an easy to use and clean OOP interface
		https://packagist.org/packages/mikehaertl/phpwkhtmltopdf
		http://mikehaertl.github.io/phpwkhtmltopdf/
*/

class bors_export_pdf extends bors_object
{
	function render_engine() { return $this; }

	function render()
	{
		$tmp_files = array();

//		header("X-PDF-INFO: /usr/local/bin/wkhtmltopdf-amd64 --cover $cover_url $helper_url $target_dir/$target_name");

		$bin = config('bin.wkhtmltopdf', '/opt/bin/wkhtmltopdf-amd64');

		if($args = config('bin.wkhtmltopdf.args'))
			$bin .= " $args ";

		$log_put = config('debug_hidden_log_dir').'/pdf-maker.log';

		$header = "";
		if($header_html = $this->get('header_html'))
		{
			$header_file = uniqid('/tmp/pdf-header-').'.html';
			$tmp_files[] = $header_file;
			file_put_contents($header_file, $header_html);
			$header = " --header-html $header_file";
		}
		elseif($header_url = $this->get('header_url'))
				$header = " --header-html $header_url";

		$cover = "";
		if($cover_html = $this->get('cover_html'))
		{
			$cover_file = uniqid('/tmp/pdf-cover-').'.html';
			$tmp_files[] = $cover_file;
			file_put_contents($cover_file, $cover_html);
			$cover = " cover $cover_file";
		}
		elseif($cover_url = $this->get('cover_url'))
				$cover = " cover $cover_url";

		if($body_html = $this->get('body_html'))
		{
			$body = uniqid('/tmp/pdf-body-').'.html';
			$tmp_files[] = $body;
			file_put_contents($body, $body_html);
		}
		else
		{
			if($b = $this->get('body_url'))
				$body = " $b";
			else
				$body = " http://bors.balancer.ru/";
		}

		$footer = "";
		if($footer_html = $this->get('footer_html'))
		{
			$footer_file = uniqid('/tmp/pdf-footer-').'.html';
			$tmp_files[] = $footer_file;
			file_put_contents($footer_file, $footer_html);
			$footer = " --footer-html $footer_file";
		}
		elseif($footer_url = $this->get('footer_url'))
				$footer = " --footer-html $footer_url";


		$file = uniqid('/tmp/pdf-result-').'.pdf';
		$tmp_files[] = $file;

		$cmd = "$bin --encoding utf-8 $cover $header $body $footer $file &> $log_put";
		debug_hidden_log('00-pdf', $cmd);
		system($cmd);

		$pdf = file_get_contents($file);

		foreach($tmp_files as $f)
			unlink($f);

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

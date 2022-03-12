<?php if(!defined('BASEPATH')) exit('no direct script acess allowed');

class Template {

	function show($view, $data=array()){

			$CI = & get_instance();
 
			// Load header
			$CI->load->view('template/header',$data);
 
			// Load content
			$CI->load->view($view,$data);
 
			// Load footer
			$CI->load->view('template/footer',$data);
 
			// Scripts
			$CI->load->view('template/scripts',$data);


	}
}

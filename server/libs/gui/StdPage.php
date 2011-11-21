<?php 

class StdPage implements Page{
	

	private $js_urls;
	private $css_urls;
	private $header;
	private $menu;
	private $content;
	private $footer;
	private $page_title;


	function __construct()
	{

		//vamos a ver si me enviaron un login
		if(isset($_POST["do_login"])){
			//test credentials
			$user = SesionController::testLogin( $_POST["user"], $_POST["password"] );
		}

		//vamos a ver si me enviaron un logout
		if(isset($_REQUEST["close_session"])){
			SesionController::logout( );
			die(header("Location: ../"));

		}



		$this->js_urls 	= "";
		$this->css_urls = "";
		$this->header 	= "";
		$this->menu 	= "";
		$this->content 	= "";
		$this->footer 	= "";
		$this->page_title = "POS ERP";
	}

	public function addJs( $url )
	{
		$this->js_urls .= '<script type="text/javascript" src="' . $url . '"></script>';
	}


	public function addCss( $url )
	{
		$this->css_urls .= '<link rel="stylesheet" type="text/css" href="' . $url . '">';
	}



	public function addHeader( $html )
	{
		$this->header = $html;
	}

	public function addMenu( $html )
	{
		$this->menu = $html;
	}

	public function addContent( $html )
	{
		$this->content = $html;
	}
	
	public function addFooter( $html )
	{
		$this->footer = $html;
	}


	public function render()
	{
		?><!DOCTYPE html><html lang="es"><head><?php
		
		print( $this->js_urls );
		print( $this->css_urls );
		print( "<title>" . $this->page_title . "</title>");

		?></head><body><?php

		print( $this->header );
		print( $this->menu );
		print( $this->content );
		print( $this->footer );
		
		?></body></html><?php		
	}
}
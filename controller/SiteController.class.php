<?php

class SiteController{
	
	public static function view($view, $data = null, $data_range=null){
		require_once 'views/'.$view.'.php';
		
	}
	public function Index(){
		$content = Content::getAll();
		$method = Method::get(1);
		self::view('index',$method,$content);
	}
	public function Blog(){
		$method = Method::get(1);
		self::view('blog',$method);
	}
	public function About(){
		$method = Method::get(1);
		self::view('about',$method);
	}
}
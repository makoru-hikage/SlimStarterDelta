<?php

use Interop\Container\ContainerInterface;

class AuthenticationController extends BaseController {

	public function index($req, $res, $args){
		
		$this->data['title'] = "This is a title.";

		$this->app->menu_manager->get('main_sidebar')->setActiveMenu('dashboard');

		$this->app->view->render($res,'home/index.twig', $this->data);
	
		
	}
}
<?php

namespace DeltaX\RepositoryInvoker;

use \Slim\App;
use \Prjkt\Components\Repofuck\Repofuck;
use \DeltaX\RepositoryInvoker\RepositoryInvokerInterface;

class RepofuckInvoker implements RepositoryInvokerInterface{

	protected $app;

	protected $repo;

	protected $controller = null;

	protected $httpMethods = array();

	public function __construct(\Slim\App $app, $repo){
		$this->app = $app;
		$this->repo = $repo;
		$this->setDefaultHttpMethodFunctions();
	}

	public function __invoke($request, $response, $args){

		$params = $params ?? $request->params();
		var_dump ($request->getMethod());
		/*$this->repo->setDataAndKeys($prequestParams);
		$data = $this->invokeMethodFunction($request->getMethod(), $params);

		if ($request->isAjax()) {
			$response->withJson($data);
		} else {
			var_dump($params);
			
		}*/

	}

	protected function setDefaultHttpMethodFunctions(){
		/*$this->httpMethods = [
			'GET' => [$this->repo, 'first'],
			'POST' => [$this->repo, 'create'],
			'PUT' => [$this->repo, 'update'],
			'GET' => [$this, 'softDelete']
		];*/

		$this->httpMethods = [
			'get' => function () {echo "fuck";},
			'POST' => function () {echo "fuck";},
			'PUT' => function () {echo "fuck";}
		];
	}

	protected function invokeHttpMethodFunction($httpMethod, array $params){
		return call_user_func($this->httpMethods[$httpMethod], $params);
	}

	public function hasHttpMethod($httpMethod) : bool {
		array_key_exists($httpMethod, $this->httpMethods);
	}

	public function getAllowedHttpMethods() : array {
		return $this->httpMethods;
	}

	public function setHttpMethodFunction($httpMethod, $function){
		$this->httpMethods[$httpMethod] = $function;
	}

	public function setHttpMethods(array $httpMethods) {
		$this->httpMethods = $httpMethods;
	}

	public function softDelete($params) : \Model {

		$params['is_deleted'] = 1;
		$this->repo->setDataAndKeys($params);
		$this->repo->update();
	}

} 
<?php

namespace DeltaX\RepositoryInvoker;

interface RepositoryInvokerInterface {

	public function hasHttpMethod($httpMethod);
	public function getAllowedHttpMethods();
	public function setHttpMethodFunction($httpMethod, $function);
	public function setHttpMethods(array $httpMethods);

}
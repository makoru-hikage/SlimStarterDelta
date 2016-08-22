<?php


namespace DeltaX\UserAuthentication;

class SentinelAuthenticationAdapter {

	public function authenticate($user, $remember = false){		
		return Sentinel::authenticate($credentials);
	}

	public function check($forced = false){
		return $forced ? Sentinel::forceCheck() : Sentinel::check();
	}
	public function getUser($checked = true){
		return Sentinel::getUser($checked); 
	}
	
	public function register(array $credentials, callback $callback){
		return Sentinel::register($credentials, $callback);
	}
	public function login($user, $remember = false){
		return Sentinel::login($user, $remember);
	}
	public function logout(){
		return Sentinel::logout();
	}
}
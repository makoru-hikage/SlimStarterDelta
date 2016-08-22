<?php

namespace DeltaX\UserAuthentication;

interface UserAuthenticationAdapterInterface {
	public function authenticate($user, $remember);

	public function check($forced);
	public function getUser($check);
	
	public function register(array $credentials, callback $callback);
	public function login($user, $remember);
	public function logout();
}
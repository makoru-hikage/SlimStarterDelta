<?php

namespace DeltaX\ContentAccess;

interface ContentAuthorizationInterface {
	public function verticallyAuthorize($user, permission);
	public function horizontallyAuthorize($user, array $content);
	public function authorizeContent();
}
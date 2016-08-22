<?php 

$app->get('/', '\AuthenticationController:index');

$app->get('/shit', function (){echo "shit!";});


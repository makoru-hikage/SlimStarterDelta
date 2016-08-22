<?php

$config['settings']['cookies'] = array(
    'expires'       => '30 minutes',
    'path'          => '/',
    'domain'        => null,
    'secure'        => false,
    'httponly'      => false,
    'name'          => 'slim_session',
    'secret'        => 'CHANGE_ME',
    'cipher'        => MCRYPT_RIJNDAEL_256,
    'cipher_mode'   => MCRYPT_MODE_CBC
);
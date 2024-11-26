<?php

// First we need to load the composer autoloader so we can use WP Mock
require_once './vendor/autoload.php';

// Contains the testable function.
require_once './functions/wp_mail.php';

// WordPress specifics activate below

// WP_Mock::activateStrictMode();
WP_Mock::bootstrap();

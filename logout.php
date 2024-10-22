<?php
require_once 'core/config.php';
require_once 'core/functions.php';

session_destroy();
redirect(SITE_URL);
?>
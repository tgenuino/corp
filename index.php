<?php
require(__DIR__ . '/app/corp.php');

\app\corp::start($_SERVER['REQUEST_URI'], __DIR__);
?>
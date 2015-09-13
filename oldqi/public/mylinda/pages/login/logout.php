<?php
/* BO USER */
$mysession = 'continentetv_bo_session';

unset($_SESSION[$mysession]);
session_destroy();

header("Location: {$path}/login");
exit(0);
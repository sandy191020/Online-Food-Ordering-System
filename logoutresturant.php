<?php
session_start();
session_destroy();
header("Location: resturant.html");
exit;
?>
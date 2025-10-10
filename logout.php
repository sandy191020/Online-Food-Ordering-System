<?php
session_start();
session_destroy();
header("Location: user_form.html");
exit;
?>

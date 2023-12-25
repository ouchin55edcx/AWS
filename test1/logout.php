<?php
session_start();
session_unset();
session_destroy();
session_regenerate_id();
header("Location: your_redirect_page.php");
exit();
?>

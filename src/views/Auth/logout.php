<?php
session_start();
session_unset();
session_destroy();
header("Location: LoginAndSignUp.php?logout=success");
exit();
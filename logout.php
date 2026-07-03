<?php
session_start();
session_unset(); //pour supprimer tt donnees stck
session_destroy(); 
header("location:login/login.php");
exit();

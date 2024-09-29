// Connection to the database
<?php
    require("../env.inc");
    $conn= mysqli_connect($host, $dbUser, $dbPassword, $db);
?>
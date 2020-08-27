<?php
    $host = "localhost";
    $db = "a3002724_scp";
    $user = "a3002724_agent";
    $pw = "NtPmK9v2CgwI8yU4";

    $dsn = "mysql:host=$host; dbname=$db";

    try
    {
        $conn = new PDO($dsn, $user, $pw);
    }
    catch(PDOException $error)
    {
        echo "<h3>Error</h3>" . $error->getMessage();
    }
    

?>
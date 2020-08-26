<?php

    include "config/database.php";

    // Select records from db table
    $query = "select * from subject";
    $record = $conn->prepare($query);
    $record->execute();

?>
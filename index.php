<!DOCTYPE HTML>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="css/bootstrap.css" type="text/css">

        <title>SCP Foundation - Home</title>
    </head>

    <body class="bg-dark">
        <div class="container">

            <!-- Nav Bar -->
            <div class="row-cols-12">
                <!-- PHP include -->
                <?php include "config/select_record.php"; ?>
                <nav class="navbar navbar-expand-lg navbar-light bg-light rounded shadow">
                    <a class="navbar-brand font-weight-bold" href="index.php">
                        <img src="images/logo.png" width="50" height="50" class="d-inline-block align-middle" alt="SCP Foundation">SCP Foundation
                    </a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarHamburger" aria-controls="navbarHamburger" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarHamburger">
                        <ul class="navbar-nav mr-auto mt-2 mt-lg-2">
                            <a href="index.php" class="nav-link active">Home</a>
                            <!-- Run php loop through db and display subject item numbers here -->
                            <?php foreach($record as $scp_item): ?>
                                <a href="read_one.php?id='<?php echo $scp_item['id']; ?>'" class="nav-link"><?php echo $scp_item['item_no']; ?></a>
                            <?php endforeach; ?>
                            <a href="create.php" class="nav-link">New Subject Record</a>
                        </ul>
                    </div>
                </nav>                
            </div>

            <!-- Welcome Message -->
            <div class="row-cols-12">
                <div class="card shadow p-3 mb-3 mt-3 bg-light rounded text-lg-left text-center">
                    <div class="card-body">
                        <h1 class="card-title">SCP Foundation Database</h1>
                        <p class="card-text">
                            <div class="row-cols-1">
                                <p class="lead font-italic">Welcome Agent.</p>
                                <p class="lead">View the current subject records below or add a new subject.</p>
                            </div>
                        </p>
                    </div>
                </div>
            </div>
        
            <div class="row">
                <?php   
                    // PHP include for db connection
                    include 'config/database.php';

                    // Select records from database
                    $query = "select id, item_no, object_class, subject_image, created, modified from subject order by id asc";
                    $statement =  $conn->prepare($query);
                    $statement->execute();

                    // Returns the number of records in the database
                    $rows = $statement->rowCount();

                    // Delete functionality
                    $delete = isset($_GET['action']) ? $_GET['action'] : "";
        
                    // If directed from delete.php
                    if($delete == 'deleted')
                    {
                        echo "
                            <div class='col-12 alert alert-success mt-4'>
                                <h4>Record has been deleted successfully.</h4>
                            </div>
                        ";
                    }

                    // If there is more than one row in the db, display it
                    if($rows > 0)
                    {	
                        // Loop through table to retrieve each record and display in bootstrap grid
                        while($record = $statement->fetch(PDO::FETCH_ASSOC))
                        {
                            extract($record);

                            echo "
                                <div class='col-md-6'>
                                    <div class='card shadow p-3 mb-3 bg-light rounded text-center'>
                                        <h3 class='card-header bg-light'>
                                            {$item_no}
                                        </h3>
                                        <img src='{$subject_image}' class='card-img-top shadow rounded' alt='{$item_no}'>
                                        <div class='card-body'>                                            
                                            <p class='card-text'></p>
                                            <div class='row'>
                                                <div class='col-4 pt-1 pb-1'><a href='read_one.php?id={$id}' class='btn btn-dark btn-sm'>View</a></div>
                                                <div class='col-4 pt-1 pb-1'><a href='update.php?id={$id}' class='btn btn-secondary btn-sm'>Update</a></div>
                                                <div class='col-4 pt-1 pb-1'><a href='delete.php?id={$id}' onclick='delete_record({$id})' class='btn btn-danger btn-sm'>Delete</a></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <span class='border-bottom'></span>                                
                            ";					
                        }
                    }
                    else
                    {
                        echo "
                            <div><p>No records found.</p></div>
                        ";
                    }                    
                ?>
            </div>

            <!-- Footer -->
            <div class="row-cols-12">
                <footer class='footer mt-auto py-3 bg-light text-dark text-center rounded shadow'>
                    <div><strong>&#169;</strong> Taylor Hollander</div>
                </footer>
            </div>

        </div>

        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="js/bootstrap.bundle.js"></script>
        <script>
            function delete_record(id)
            {
                var answer = confirm('Ok to delete this record?');

                if(answer)
                {
                    window.location = 'delete.php?id=' + id;
                }
            }
        </script>

    </body>
</html>
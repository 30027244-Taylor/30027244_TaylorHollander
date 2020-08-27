<!DOCTYPE HTML>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="css/bootstrap.css" type="text/css">

        <title>SCP Database - Delete</title>
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

            <!-- Delete Message -->
            <div class="row-cols-12">
                <div class="card shadow p-3 mb-3 mt-3 bg-light rounded text-lg-left text-center">
                    <div class="card-body">
                        <h2 class="card-title">Subject Record Deleted</h2>
                        <p class="card-text">
                            <div class="row-cols-1 alert alert-success text-left">
                                <h4>Record has been deleted successfully.</h4>
                                <p><a href="index.php" class="btn btn-dark">Back to Home</a></p>
                            </div>
                        </p>
                    </div>
                </div>
            </div>

            <?php 
                // PHP include for db connection
                include "config/database.php";

                try
                {
                    $id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');

                    // Delete query
                    $query = "delete from subject where id=?";
                    $statement = $conn->prepare($query);
                    $statement->bindParam(1, $id);

                    if($statement->execute())
                    {
                        // Redirect back to index page with delete get value
                        header('Location: index.php?action=deleted');
                    }
                    else
                    {
                        die('Unable to delete record.');
                    }
                }
                catch(PDOException $exception)
                {
                    die('ERROR: ' . $exception->getMessage());
                }    
            
            ?>

            <!-- Footer -->
            <div class="row-cols-12 mt-3">
                <footer class='footer mt-auto py-3 bg-light text-dark text-center rounded shadow'>
                    <div><strong>&#169;</strong> Taylor Hollander</div>
                </footer>
            </div>
            
        </div>
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="js/bootstrap.bundle.js"></script>
        
    </body>
</html>
<!DOCTYPE HTML>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="css/bootstrap.css" type="text/css">

        <title>SCP Foundation - Read</title>
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
        
            <div class="row">
                <?php

                    // Check if an id value was sent to this page via GET method (?id=) usually from a link
                    if(isset($_GET['id']))
                    {                    
                        // PHP include for db connection
                        include 'config/database.php';
                        $id = trim($_GET['id'], "'");

                        // Delete function
                        $delete = isset($_GET['action']) ? $_GET['action'] : "";
            
                        // If directed from delete.php
                        if($delete == 'deleted')
                        {
                            echo "
                                <div class='alert alert-success mt-4'>
                                    <h4>Record has been deleted successfully.</h4>
                                    <br>
                                    <a href='index.php' class='btn btn-dark'>Back to Home</a>
                                </div>
                            ";
                        }

                        try
                        {
                            $query = "select * from subject where id = ? limit 0,1";
                            $statement = $conn->prepare($query);

                            // Bind ? to id
                            $statement->bindParam(1, $id);
                            $statement->execute();

                            // Store retrieved record into assoc array
                            $row = $statement->fetch(PDO::FETCH_ASSOC);

                            // Individual values from record
                            $id = $row['id'] ?? '';
                            $item_no = $row['item_no'] ?? '';
                            $object_class = $row['object_class'] ?? '';
                            $subject_image = $row['subject_image'] ?? '';
                            $procedures = $row['procedures'] ?? '';
                            $description = $row['description'] ?? '';
                            $h1 = $row['h1'] ?? '';
                            $extra_1 = $row['extra_1'] ?? '';
                            $h2 = $row['h2'] ?? '';
                            $extra_2 = $row['extra_2'] ?? '';
                            $h3 = $row['h3'] ?? '';
                            $extra_3 = $row['extra_3'] ?? '';
                            $created = $row['created'] ?? '';
                            $modified = $row['modified'] ?? '';
                        }
                        catch(PDOException $exception)
                        {
                            die('ERROR: ' . $exception->getMessage());
                        }
                    }
                    else 
                    {
                        die('ERROR: Record ID not found');
                    }
                ?>

                <!-- Subject Record Content -->
                <div class="col-lg-12">
                    <div class="card shadow p-3 mb-3 mt-3 bg-white rounded text-md-left text-center">

                        <!-- Item Number -->
                        <h1 class="card-header bg-white text-lg-left text-center">
                            <?php echo nl2br(htmlspecialchars($item_no, ENT_QUOTES)); ?>
                        </h1>
                        <div class="card-body">

                            <!-- Object Class -->
                            <h2 class="card-title text-lg-left text-center"><?php echo nl2br(htmlspecialchars($object_class, ENT_QUOTES)); ?></h2>

                            <p class="card-text">

                                <!-- Subject Image -->
                                <div class="row-cols-1">
                                    <p><img src="<?php echo nl2br(htmlspecialchars($subject_image, ENT_QUOTES)); ?>" class="card-img-top img-fluid shadow rounded" alt="<?php echo htmlspecialchars($item_no, ENT_QUOTES); ?>"></p>
                                </div>

                                <!-- Procedures -->
                                <div class="row-cols-1">
                                    <h3 class="text-lg-left text-center">Special Containment Procedures:</h3>
                                </div>
                                <div class="row-cols-1">
                                    <p>
                                        <?php echo nl2br(htmlspecialchars($procedures, ENT_QUOTES)); ?>
                                    </p>
                                </div>

                                <!-- Description -->
                                <div class="row-cols-1">
                                    <h3 class="text-lg-left text-center">Description:</h3>
                                </div>
                                <div class="row-cols-1">
                                    <p>
                                        <?php echo nl2br(htmlspecialchars($description, ENT_QUOTES)); ?>
                                    </p>
                                </div>

                                <!-- Extra 1 -->
                                <div class="row-cols-1">
                                    <h class="text-lg-left text-center"><?php echo nl2br(htmlspecialchars($h1, ENT_QUOTES)); ?></h3>
                                </div>
                                <div class="row-cols-1">
                                    <p>
                                        <?php echo nl2br(htmlspecialchars($extra_1, ENT_QUOTES)); ?>
                                    </p>
                                </div>

                                <!-- Extra 2 -->
                                <div class="row-cols-1">
                                    <h3 class="text-lg-left text-center"><?php echo nl2br(htmlspecialchars($h2, ENT_QUOTES)); ?></h3>
                                </div>
                                <div class="row-cols-1">
                                    <p>
                                        <?php echo nl2br(htmlspecialchars($extra_2, ENT_QUOTES)); ?>
                                    </p>
                                </div>

                                <!-- Extra 3 -->
                                <div class="row-cols-1">
                                    <h3 class="text-lg-left text-center"><?php echo nl2br(htmlspecialchars($h3, ENT_QUOTES)); ?></h3>
                                </div>
                                <div class="row-cols-1">
                                    <p>
                                        <?php echo nl2br(htmlspecialchars($extra_3, ENT_QUOTES)); ?>
                                    </p>
                                </div>
                            </p>

                            <!-- Created and Modified -->
                            <div class="row-cols-1 text-monospace">
                                <small><strong>Record Created: </strong><?php echo nl2br(htmlspecialchars($created, ENT_QUOTES)); ?></small>
                            </div>
                            <div class="row-cols-1 text-monospace">
                                <small><strong>Record Last Updated: </strong><?php echo nl2br(htmlspecialchars($modified, ENT_QUOTES)); ?></small>
                            </div>

                            <!-- Update, Delete and Home buttons -->
                            <div class="row-cols-12 text-lg-left mt-4">
                                <div class="row mb-2">
                                    <a href="update.php?id=<?php echo nl2br(htmlspecialchars($id, ENT_QUOTES)); ?>" class="btn btn-secondary">Update</a>
                                </div>
                                <div class="row mb-2">
                                    <a href="delete.php?id=<?php echo nl2br(htmlspecialchars($id, ENT_QUOTES)); ?>" onclick="delete_record(<?php echo nl2br(htmlspecialchars($id, ENT_QUOTES)); ?>)" class="btn btn-danger">Delete</a>
                                </div>
                                <div class="row mb-2">
                                    <a href="index.php" class="btn btn-dark btn-sm">Back to Home</a> 
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="row-cols-12">
                <footer class='footer mt-auto py-3 bg-light text-dark text-center rounded shadow'>
                    <div><strong>&#169;</strong> Taylor Hollander</div>
                </footer>
            </div>

        </div>

        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
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
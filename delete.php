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

    <body class="container row-cols-1">

        <h1 class="page-header">Delete Product Record</h1>
        <div class="alert alert-success mt-4">
            <h4>Record has been deleted successfully.</h4>
            <br>
            <a href="index.php" class="btn btn-dark">Back to Home</a>
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

        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="js/bootstrap.bundle.js"></script>
        
    </body>
</html>
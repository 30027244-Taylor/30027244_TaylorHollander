<!DOCTYPE HTML>
<html>
	<head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="css/bootstrap.css" type="text/css">

        <title>SCP Foundation - Create</title>
    </head>

	<body class="bg-dark">
        <div class="container">
            <div class="row-cols-12">
                <!-- PHP include -->
                <?php include "config/select_record.php"; ?>
                
                <!-- Nav Bar -->
                <nav class="navbar navbar-expand-lg navbar-light bg-light rounded shadow">
                    <a class="navbar-brand font-weight-bold" href="index.php">
                        <img src="images/logo.png" width="50" height="50" class="d-inline-block align-middle" alt="SCP Foundation">SCP Foundation
                    </a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarHamburger" aria-controls="navbarHamburger" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarHamburger">
                        <ul class="navbar-nav mr-auto mt-2 mt-lg-2">
                            <a href="index.php" class="nav-link">Home</a>
                            <!-- Run php loop through db and display subject item numbers here -->
                            <?php foreach($record as $scp_item): ?>
                                <a href="read_one.php?id='<?php echo $scp_item['id']; ?>'" class="nav-link"><?php echo $scp_item['item_no']; ?></a>
                            <?php endforeach; ?>
                            <a href="create.php" class="nav-link active">New Subject Record</a>
                        </ul>
                    </div>
                </nav>
            </div>

            <div class="p-4 mt-3 bg-light text-dark rounded text-md-left text-center">
                <?php
                    if($_POST)
                    {
                        // PHP include for db connection
                        include 'config/database.php';

                    try
                    {
                            // Insert query
                            $query = "insert into subject set item_no=:item_no, object_class=:object_class, subject_image=:subject_image, procedures=:procedures, description=:description, h1=:h1, extra_1=:extra_1, h2=:h2, extra_2=:extra_2, h3=:h3, extra_3=:extra_3, created=:created";

                            // Prepare query for execution
                            $statement = $conn->prepare($query);

                            $item_no = htmlspecialchars(strip_tags($_POST['item_no']));
                            $object_class = htmlspecialchars(strip_tags($_POST['object_class']));
                            $subject_image = htmlspecialchars(strip_tags($_POST['subject_image']));
                            $procedures = htmlspecialchars(strip_tags($_POST['procedures']));
                            $description = htmlspecialchars(strip_tags($_POST['description']));
                            $h1 = htmlspecialchars(strip_tags($_POST['h1']));              
                            $extra_1 = htmlspecialchars(strip_tags($_POST['extra_1']));                
                            $h2 = htmlspecialchars(strip_tags($_POST['h2']));
                            $extra_2 = htmlspecialchars(strip_tags($_POST['extra_2']));                
                            $h3 = htmlspecialchars(strip_tags($_POST['h3']));
                            $extra_3 = htmlspecialchars(strip_tags($_POST['extra_3']));

                            // Bind our parameters to our query
                            $statement->bindParam(':item_no', $item_no);
                            $statement->bindParam(':object_class', $object_class);
                            $statement->bindParam(':subject_image', $subject_image);
                            $statement->bindParam(':procedures', $procedures);
                            $statement->bindParam(':description', $description);
                            $statement->bindParam(':h1', $h1);
                            $statement->bindParam(':extra_1', $extra_1);
                            $statement->bindParam(':h2', $h2);
                            $statement->bindParam(':extra_2', $extra_2);
                            $statement->bindParam(':h3', $h3);
                            $statement->bindParam(':extra_3', $extra_3);

                            // Specify when record was created and then bind
                            $created = date('Y-m-d H:i:s');
                            $statement->bindParam(':created', $created);

                            // Execute the query
                            if($statement->execute())
                            {
                                echo "
                                    <div class='alert alert-success mt-4'>
                                        <h4>New Subject added!</h4>
                                        <p>New subject record has been successfully created and added to the database.</p>
                                        <a href='index.php' class='btn btn-dark'>Back to Home</a>
                                    </div>
                                ";
                            }
                            else
                            {
                                echo "
                                    <div class='alert alert-danger mt-4'>
                                        <h4>Unable to save record</h4>
                                        <p>Something has gone wrong... Please try again.</p>
                                        <a href='create.php' class='btn btn-dark'>Back To Home</a>
                                    </div>
                                ";
                            }

                    }
                    catch(PDOException $exception)
                    {
                            die('ERROR: ' . $exception->getMessage());
                    }
                    }		
                
                ?>        

                <!-- New Record Form -->
                <br>
                <h1>New Subject Record</h1>
                <br>
                <h3>Enter new subject information using the form below.</h3>

                <form class="form-group text-left" method="post" action="create.php">

                    <hr class="mx-auto d-block">
                    
                    <label>Item Number: <strong>*</strong></label>
                    <br>
                    <input type="text" class="form-control" name="item_no" placeholder="Use the format 'SCPXXX'" required>
                    <small>Max. 20 characters</small>
                    <br>
                    <br>

                    <label for="formControlSelect">Object Class: <strong>*</strong></label>
                    <br>
                    <select class="form-control" id="formControlSelect" name="object_class" required>
                        <option selected value="">Select a class...</option>
                        <option value="Safe">Safe</option>
                        <option value="Euclid">Euclid</option>
                        <option value="Keter">Keter</option>
                        <option value="Thaumiel">Thaumiel</option>
                        <option value="Neutralised">Neutralised</option>
                    </select>
                    <br>

                    <label>Subject Image:</label>
                    <br>
                    <input type="text" class="form-control" name="subject_image" placeholder="Use the format 'images/image.(jpg, png)'">
                    <br>

                    <label>Procedures:<strong>*</strong></label>
                    <br>
                    <textarea class="form-control" name="procedures" rows="5" placeholder="Separate paragraphs with a new line" required></textarea>
                    <br>

                    <label>Description: <strong>*</strong></label>
                    <br>
                    <textarea class="form-control" name="description" rows="5" placeholder="Separate paragraphs with a new line" required></textarea>
                    <br>

                    <label>Heading:</label>
                    <br>
                    <input type="text" class="form-control" name="h1">
                    <br>

                    <label>Extra Information:</label>
                    <br>
                    <textarea class="form-control" name="extra_1" rows="5" placeholder="Separate paragraphs with a new line"></textarea>
                    <br>

                    <label>Heading:</label>
                    <br>
                    <input type="text" class="form-control" name="h2">
                    <br>

                    <label>Extra Information:</label>
                    <br>
                    <textarea class="form-control" name="extra_2" rows="5"></textarea>
                    <br>

                    <label>Heading:</label>
                    <br>
                    <input type="text" class="form-control" name="h3">
                    <br>

                    <label>Extra Information:</label>
                    <br>
                    <textarea class="form-control" name="extra_3" rows="5"></textarea>

                    <br>
                    <hr class="mx-auto d-block">
                    <br>
                    
                    <input type="submit" class="btn btn-success mx-auto d-block" name="submit" value="Submit">
                    
                </form>
                <div class="row-cols-12 text-center">
                    <a href="index.php" class="btn btn-dark btn-sm">Back to Home</a>
                </div>
            </div>

            <!-- Footer -->
            <div class="row-cols-12 mt-3">
                <footer class='footer mt-auto py-3 bg-light text-dark text-center rounded shadow'>
                    <div><strong>&#169;</strong> Taylor Hollander</div>
                </footer>
            </div>
        </div>


        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="js/bootstrap.bundle.js"></script>
	</body>
</html>
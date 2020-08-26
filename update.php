<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="css/bootstrap.css" type="text/css">

        <title>SCP Foundation - Update</title>
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
                            <a href="create.php" class="nav-link">New Subject Record</a>
                        </ul>
                    </div>
                </nav>
            </div>

            <div class="p-4 mt-3 bg-light text-dark rounded text-md-left text-center">
                <?php

                    // Check if ID value was sent to this page via the get method (?=) from a link
                    $id = isset($_GET['id']) ? $_GET['id'] : die("ERROR: Record ID not found.");

                    // PHP include for db connection
                    include 'config/database.php';

                    // Get the current record from the db based on the id value
                    try
                    {
                        // Select the data from the db
                        $query = "select id, item_no, object_class, subject_image, procedures, description, h1, extra_1, h2, extra_2, h3, extra_3 from subject where id = ? limit 0,1";
                        $read = $conn->prepare($query);

                        // Bind our ? to id
                        $read->bindParam(1, $id);

                        $read->execute();

                        // Store record into associative array
                        $row = $read->fetch(PDO::FETCH_ASSOC);

                        // Retrieve individual field data from the array
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
                        

                    }
                    catch(PDOException $exception)
                    {
                        die('ERROR: ' . $exception->getMessage());
                    }

                    if($_POST)
                    {
                        try
                        {
                            // Update sql query
                            $query = "update subject set item_no=:item_no, object_class=:object_class, subject_image=:subject_image, procedures=:procedures, description=:description, h1=:h1, extra_1=:extra_1, h2=:h2, extra_2=:extra_2, h3=:h3, extra_3=:extra_3, modified=:modified where id=:id";

                            // Prepare the query
                            $update = $conn->prepare($query);

                            // Save post values from the form
                            $id = htmlspecialchars(strip_tags($_POST['id']));
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

                            // Bind parameters
                            $update->bindParam(':id', $id);
                            $update->bindParam(':item_no', $item_no);
                            $update->bindParam(':object_class', $object_class);
                            $update->bindParam(':subject_image', $subject_image);
                            $update->bindParam(':procedures', $procedures);
                            $update->bindParam(':description', $description);
                            $update->bindParam(':h1', $h1);
                            $update->bindParam(':extra_1', $extra_1);
                            $update->bindParam(':h2', $h2);
                            $update->bindParam(':extra_2', $extra_2);
                            $update->bindParam(':h3', $h3);
                            $update->bindParam(':extra_3', $extra_3);

                            // Updates modified timestamp
                            $modified = date('Y-m-d H:i:s');
                            $update->bindParam(':modified', $modified);

                            // Execute the update query
                            if($update->execute())
                            {
                                echo "
                                
                                <div class='alert alert-success mt-4'>
                                    <h4>Record {$id} was updated successfully.</h4>
                                    <p><a href='read_one.php?id={$id}' class='btn btn-secondary'>Back to {$item_no}</a></p>
                                    <p><a href='index.php' class='btn btn-dark btn-sm'>Back to Home</a></p>
                                </div>
                                
                                ";
                            }
                            else
                            {
                                echo "
                                
                                <div class='alert alert-danger mt-4'>
                                    <h4>Unable to update record, please try again.</h4>
                                    <p><a href='read_one.php?id={$id}' class='btn btn-secondary'>Back to {$item_no}</a></p>
                                    <p><a href='index.php' class='btn btn-dark bt-sm'>Back to Home</a></p>
                                </div>
                                
                                ";
                            }
                        }
                        catch(PDOException $exception)
                        {
                            die('ERROR: ' . $exception->getMessage());
                        }
                    }
                    else
                    {
                        echo "
                        
                        <div class='alert alert-warning mt-4'>
                            <h4>Record is ready to be updated</h4>
                        </div>

                        ";
                    }
                
                ?>

                <!-- Update Record Form -->
                <br>
                <h1>Update Subject Record</h1>
                <br>
                <h3>Update record for <?php echo htmlspecialchars($item_no, ENT_QUOTES); ?> using the form below.</h3>
                
                <form class="form-group text-left" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'] . '?id={$id}'); ?>">

                    <hr class="mx-auto d-block">

                    <label>Record ID: <?php echo htmlspecialchars($id, ENT_QUOTES); ?></label>
                    <br>
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($id, ENT_QUOTES); ?>">
                    <br>

                    <label>Item Number: *</label>
                    <br>
                    <input type="text" class="form-control" name="item_no" value="<?php echo htmlspecialchars($item_no, ENT_QUOTES); ?>" required>
                    <br>

                    <label for="formControlSelect">Object Class: *</label>
                    <br>
                    <select class="form-control" id="formControlSelect" name="object_class" required>
                        <option selected value="<?php echo htmlspecialchars($object_class, ENT_QUOTES); ?>"><?php echo htmlspecialchars($object_class, ENT_QUOTES); ?></option>
                        <option value="Safe">Safe</option>
                        <option value="Euclid">Euclid</option>
                        <option value="Keter">Keter</option>
                        <option value="Thaumiel">Thaumiel</option>
                        <option value="Neutralised">Neutralised</option>
                    </select>
                    <br>

                    <label>Subject Image:</label>
                    <br>
                    <input type="text" name="subject_image" class="form-control" value="<?php echo htmlspecialchars($subject_image, ENT_QUOTES); ?>">
                    <br>

                    <label>Procedures: *</label>
                    <br>
                    <textarea name="procedures" class="form-control" rows="5" value="<?php echo htmlspecialchars($procedures, ENT_QUOTES); ?>" required><?php echo htmlspecialchars($procedures, ENT_QUOTES); ?></textarea>
                    <br>

                    <label>Description: *</label>
                    <br>
                    <textarea name="description" class="form-control" rows="5" value="<?php echo htmlspecialchars($description, ENT_QUOTES); ?>" required><?php echo htmlspecialchars($description, ENT_QUOTES); ?></textarea>
                    <br>
                    
                    <label>Heading:</label>
                    <br>
                    <input type="text" class="form-control" name="h1" value="<?php echo htmlspecialchars($h1, ENT_QUOTES); ?>">
                    <br>

                    <label>Extra Information:</label>
                    <br>
                    <textarea name="extra_1" class="form-control" rows="5" value="<?php echo htmlspecialchars($extra_1, ENT_QUOTES); ?>"><?php echo htmlspecialchars($extra_1, ENT_QUOTES); ?></textarea>
                    <br>

                    <label>Heading:</label>
                    <br>
                    <input type="text" class="form-control" name="h2" value="<?php echo htmlspecialchars($h2, ENT_QUOTES); ?>">
                    <br>

                    <label>Extra Information:</label>
                    <br>
                    <textarea name="extra_2" class="form-control" rows="5" value="<?php echo htmlspecialchars($extra_2, ENT_QUOTES); ?>"><?php echo htmlspecialchars($extra_2, ENT_QUOTES); ?></textarea>
                    <br>

                    <label>Heading:</label>
                    <br>
                    <input type="text" class="form-control" name="h3" value="<?php echo htmlspecialchars($h3, ENT_QUOTES); ?>">
                    <br>

                    <label>Extra Information:</label>
                    <br>
                    <textarea name="extra_3" class="form-control" rows="5" value="<?php echo htmlspecialchars($extra_3, ENT_QUOTES); ?>"><?php echo htmlspecialchars($extra_3, ENT_QUOTES); ?></textarea>
                    <br>

                    <br>
                    <hr class="mx-auto d-block bg-dark">
                    <br>

                    <input type="submit" name="update" value="Save Changes" class="btn btn-warning mx-auto d-block">
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
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="js/bootstrap.bundle.js"></script>
    </body>
</html>
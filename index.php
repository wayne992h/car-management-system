<?php require_once('./dao/carDAO.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="upload.js"></script>
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
        table tr td:last-child{
            width: 120px;
        }
    </style>
    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();   
        });
    </script>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="employee">
                <div class="col-md-12">
                    <div class="mt-5 mb-3 clearfix">
                        <h2 class="pull-left">HD Dream Car Garage</h2>
                        <a href="create.php" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Add New Car</a>
                    </div>
                    <?php
                        $carDAO = new carDAO();
                        $cars = $carDAO->getCars();
                        
                        if($cars){
                            echo '<table class="table table-bordered table-striped">';
                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th>#</th>";
                                        echo "<th>Brand</th>";
                                        echo "<th>Model</th>";
                                        echo "<th>Year</th>";
                                        echo "<th>Action</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                foreach($cars as $car){
                                    echo "<tr>";
                                        echo "<td>" . $car->getId(). "</td>";
                                        echo "<td>" . $car->getBrand() . "</td>";
                                        echo "<td>" . $car->getModel() . "</td>";
                                        echo "<td>" . $car->getYear() . "</td>";
                                        echo "<td>";
                                            echo '<a href="read.php?id='. $car->getId() .'" class="mr-3" title="View Record" data-toggle="tooltip"><span class="fa fa-eye"></span></a>';
                                            echo '<a href="update.php?id='. $car->getId() .'" class="mr-3" title="Update Record" data-toggle="tooltip"><span class="fa fa-pencil"></span></a>';
                                            echo '<a href="delete.php?id='. $car->getId() .'" title="Delete Record" data-toggle="tooltip"><span class="fa fa-trash"></span></a>';
                                        echo "</td>";
                                    echo "</tr>";
                                }
                                echo "</tbody>";                            
                            echo "</table>";
                            // Free result set
                            //$result->free();
                        } else{
                            echo '<div class="alert alert-danger"><em>No records were found.</em></div>';
                        }
                   
                    
                    ?>
                </div>
            </div>        
        </div>
    </div>

    <!--Container of image and buttons-->
    <div class="container">
         <div id="image-area"></div>
         <div class="buttons-container">
             <button id="add-image">Add image</button>
             <button id="delete-image">Delete image</button>
            </div>   
    </div>

    <?php
    // Close connection
    $carDAO->getMysqli()->close();
    include 'footer.php';

    ?>


</body>
</html>
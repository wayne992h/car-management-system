<?php
// Include carDAO file
require_once('./dao/carDAO.php');
$carDAO = new carDAO(); 

// Check existence of id parameter before processing further
if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
    // Get URL parameter
    $id =  trim($_GET["id"]);
    $car = $carDAO->getCar($id);
            
    if($car){
        // Retrieve individual field value
        $brand = $car->getBrand();
        $model = $car->getModel();
        $year = $car->getYear();
    } else{
        // URL doesn't contain valid id. Redirect to error page
        header("location: error.php");
        exit();
    }
} else{
    // URL doesn't contain id parameter. Redirect to error page
    header("location: error.php");
    exit();
} 

// Close connection
$carDAO->getMysqli()->close();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="mt-5 mb-3">View Record</h1>
                    <div class="form-group">
                        <label>brand</label>
                        <p><b><?php echo $brand; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>model</label>
                        <p><b><?php echo $model; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>year</label>
                        <p><b><?php echo $year; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Date of purchase</label>
                        <p><b><?php echo $car->getDateOfPurchase(); ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Picture</label>
                        <?php if (!empty($car->getPicture())): ?>
                            <br>
                            <img src="<?php echo $car->getPicture(); ?>" alt="Car image" style="max-width: 100%; max-height: 300px;">
                        <?php else: ?>
                            <p><i>No image available.</i></p>
                        <?php endif; ?>
                    </div>
                    <p><a href="index.php" class="btn btn-primary">Back</a></p>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>
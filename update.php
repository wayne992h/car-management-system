<?php
// Include DAO and Car model files
require_once('./dao/carDAO.php');
require_once('./model/car.php');
 
// Define variables and initialize with empty values
$brand = $model = $year = "";
$brand_err = $model_err = $year_err = "";
$carDAO = new carDAO(); 

// Processing form data when form is submitted
if (isset($_POST["id"]) && !empty($_POST["id"])) {
    // Get hidden input value
    $id = $_POST["id"];
    
    // Validate brand
    $input_brand = trim($_POST["brand"]);
    if(empty($input_brand)){
        $brand_err = "Please enter a brand.";
    } elseif(!filter_var($input_brand, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $brand_err = "Please enter a valid brand.";
    } else{
        $brand = $input_brand;
    }

    
    // Validate model
    $input_model = trim($_POST["model"]);
    if(empty($input_model)){
        $model_err = "Please enter an model."; 
    } else{
        $model = $input_model;
    }
    

    // Validate year
    $input_year = trim($_POST["year"]);
    if(empty($input_year)){
        $year_err = "Please enter the year amount.";
    } elseif(!ctype_digit($input_year)){
        $year_err = "Please enter a positive integer value.";
    } else{
        $year = $input_year;
    }
    
    
    $picture = "";
    if ($_FILES["picture"]["error"] == UPLOAD_ERR_OK) {
        $target_dir = "image/";
        $target_file = $target_dir . basename($_FILES["picture"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if file was uploaded successfully and move it to the target directory
        if (move_uploaded_file($_FILES["picture"]["tmp_name"], $target_file)) {
            $picture = $target_file;
        } else {
            echo "Error uploading the image.";
            $uploadOk = 0;
        }
    }

    // Check input errors before inserting in database
    if (empty($brand_err) && empty($model_err) && empty($year_err)) {
        $car = $carDAO->getCar($id);
        $old_picture = $car->getPicture();

        // If a new picture was uploaded, use it; otherwise, keep the existing picture
        $picture = empty($picture) ? $old_picture : $picture;

        $car = new Car($id, $brand, $model, $year, $_POST["date_of_purchase"], $picture);
        $result = $carDAO->updateCar($car);
        header("refresh:2; url=index.php");
        echo '<br><h6 style="text-align:center">' . $result . '</h6>';

        // Close connection
        $carDAO->getMysqli()->close();
    }
} else {
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
}
?>
 
 <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <script src="validate.js"></script>
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
                    <h2 class="mt-5">Update Record</h2>
                    <p>Please edit the input values and submit to update the  record.</p>
                    <form action="update.php" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label>Brand</label>
                        <input type="text" name="brand" id="brand" class="form-control <?php echo (!empty($brand_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $brand; ?>">
                        <span class="invalid-feedback"><?php echo $brand_err;?></span>
                        <span id="brand-error" class="error-text"></span>
                    </div>
                    <div class="form-group">
                        <label>Model</label>
                        <textarea name="model" id="model" class="form-control <?php echo (!empty($model_err)) ? 'is-invalid' : ''; ?>"><?php echo $model; ?></textarea>
                        <span class="invalid-feedback"><?php echo $model_err;?></span>
                        <span id="model-error" class="error-text"></span>
                    </div>
                    <div class="form-group">
                        <label>Year</label>
                        <input type="text" name="year" id="year" class="form-control <?php echo (!empty($year_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $year; ?>">
                        <span class="invalid-feedback"><?php echo $year_err;?></span>
                        <span id="year-error" class="error-text"></span>
                    </div>
                    <div class="form-group">
                        <label for="date_of_purchase">Date of Purchase</label>
                        <input type="date" name="date_of_purchase" class="form-control" id="date_of_purchase" value="<?php echo $car->getDateOfPurchase(); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="picture">Picture</label>
                        <input type="file" name="picture" class="form-control" id="picture" accept="image/*">
                    </div>
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>
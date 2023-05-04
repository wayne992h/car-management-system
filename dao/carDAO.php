<?php
require_once('abstractDAO.php');
require_once('./model/car.php');

class carDAO extends abstractDAO {
        
    function __construct() {
        try{
            parent::__construct();
        } catch(mysqli_sql_exception $e){
            throw $e;
        }
    }

    public function getCars(){
        $result = $this->mysqli->query('SELECT * FROM cars');
        $cars = Array();
        
        if($result->num_rows >= 1){
            while($row = $result->fetch_assoc()){
                $car = new Car($row['id'], $row['brand'], $row['model'], $row['year'], $row['date_of_purchase'], $row['picture']);
                $cars[] = $car;
            }
            $result->free();
            return $cars;
        }
        $result->free();
        return false;
    }


    public function getCar($id){
        $query = "SELECT * FROM cars WHERE id = ?";
        $stmt = $this->mysqli->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if($result->num_rows === 1){
            $row = $result->fetch_assoc();
            $car = new Car($row['id'], $row['brand'], $row['model'], $row['year'], $row['date_of_purchase'], $row['picture']);
            $result->free();
            return $car;
        }
        $result->free();
        return false;
    }
    
    public function addCar($car){
        
        if(!$this->mysqli->connect_errno){
            //The query uses the question mark (?) as a
            //placeholder for the parameters to be used
            //in the query.
            //The prepare method of the mysqli object returns
            //a mysqli_stmt object. It takes a parameterized 
            //query as a parameter.
            $query = 'INSERT INTO cars (brand, model, year, date_of_purchase, picture) VALUES (?,?,?,?,?)';
            $stmt = $this->mysqli->prepare($query);
            if($stmt){
                $brand = $car->getBrand();
                $model = $car->getModel();
                $year = $car->getYear();
                $date_of_purchase = $car->getDateOfPurchase();
                $picture = $car->getPicture();
        
                $stmt->bind_param('ssiss',
                    $brand,
                    $model,
                    $year,
                    $date_of_purchase,
                    $picture
                );
                    //Execute the statement
                    $stmt->execute();         
                    
                    if($stmt->error){
                        return $stmt->error;
                    } else {
                        return $car->getBrand() . ' added successfully!';
                    } 
			}
             else {
                $error = $this->mysqli->errno . ' ' . $this->mysqli->error;
                echo $error; 
                return $error;
            }
       
        }else {
            return 'Could not connect to Database.';
        }
    }   
    public function updateCar($car){
        
        if(!$this->mysqli->connect_errno){
            //The query uses the question mark (?) as a
            //placeholder for the parameters to be used
            //in the query.
            //The prepare method of the mysqli object returns
            //a mysqli_stmt object. It takes a parameterized 
            //query as a parameter.
            $query = "UPDATE cars SET brand=?, model=?, year=?, date_of_purchase=?, picture=? WHERE id=?";
            $stmt = $this->mysqli->prepare($query);
            if($stmt){
                $id = $car->getId();
                $brand = $car->getBrand();
                $model = $car->getModel();
                $year = $car->getYear();
                $date_of_purchase = $car->getDateOfPurchase();
                $picture = $car->getPicture();
        
                $stmt->bind_param('ssissi',
                    $brand,
                    $model,
                    $year,
                    $date_of_purchase,
                    $picture,
                    $id
                );   
                    //Execute the statement
                    $stmt->execute();         
                    
                    if($stmt->error){
                        return $stmt->error;
                    } else {
                        return $car->getBrand() . ' updated successfully!';
                    } 
			}
             else {
                $error = $this->mysqli->errno . ' ' . $this->mysqli->error;
                echo $error; 
                return $error;
            }
       
        }else {
            return 'Could not connect to Database.';
        }
    }   
    //Delete record

    public function deleteCar($carId){
        if(!$this->mysqli->connect_errno){
            $query = 'DELETE FROM cars WHERE id = ?';
            $stmt = $this->mysqli->prepare($query);
            $stmt->bind_param('i', $carId);
            $stmt->execute();
            if($stmt->error){
                return false;
            } else {
                return true;
            }
        } else {
            return false;
        }
    }
}
?>
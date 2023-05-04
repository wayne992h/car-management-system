<?php
	class Car {
		private $id;
		private $brand;
		private $model;
		private $year;
		private $date_of_purchase;
		private $picture;
	
		public function __construct($id, $brand, $model, $year, $date_of_purchase, $picture){
			$this->id = $id;
			$this->brand = $brand;
			$this->model = $model;
			$this->year = $year;
			$this->date_of_purchase = $date_of_purchase;
			$this->picture = $picture;
		}		
		
		public function getBrand(){
			return $this->brand;
		}
		
		public function setBrand($brand){
			$this->brand = $brand;
		}
		
		public function getModel(){
			return $this->model;
		}
		
		public function setModel($model){
			$this->model = $model;
		}

		public function getYear(){
			return $this->year;
		}

		public function setYear($year){
			$this->year = $year;
		}

		public function setId($id){
			$this->id = $id;
		}

		public function getId(){
			return $this->id;
		}

		public function getDateOfPurchase() {
			return $this->date_of_purchase;
		}
	
		public function setDateOfPurchase($date_of_purchase) {
			$this->date_of_purchase = $date_of_purchase;
		}
	
		public function getPicture() {
			return $this->picture;
		}
	
		public function setPicture($picture) {
			$this->picture = $picture;
		}
	}
?>
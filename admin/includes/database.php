<?php  
class database{

	//DB Params
	private $dns = "mysql:host=bupiyqubiupbiju2xunl-mysql.services.clever-cloud.com;dbname=bupiyqubiupbiju2xunl";
	private $username = "uqp2xmsefqdw6bli";
	private $password = "pkP6X31oLMbMmNLYKocd";
	private $conn;

	//DB Connect
	public function connect(){
		$this->conn = null;
		try{
			$this->conn = new PDO($this->dns,$this->username,$this->password);
			$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		}catch(PDOException $e){
			echo "Connection failed: ".$e->getMessage();
		}

		return $this->conn;
	}
}
?>


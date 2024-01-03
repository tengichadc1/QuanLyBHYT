<?php
class Data{
	protected $con;
	public function __construct()
	{
		try
		{
			$this->con = new PDO("mysql:host=localhost;dbname=db_luanan;charset=utf8", "root", "@");
			return $this->con;
		}
		catch (PDOException $e){}
	}
}
?>
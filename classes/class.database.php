<?php
class database	{
	private $username="phpdhcp";
	private $servername="localhost";
	private $database="phpdhcp";
	private $password="lolpass";
	
	function connect() 	{
		$con = mysql_connect($this->servername,$this->username,$this->password);
	
		if (!$con)	{
		die('Could not connect: ' . mysql_error());
					}
						}
						
	function disconnect()	{
		$con = mysql_connect($this->servername,$this->username,$this->password);
	
		if (!$con)	{
		die('Could not connect: ' . mysql_error());
					}
		mysql_close($con);
							}
				}
?>

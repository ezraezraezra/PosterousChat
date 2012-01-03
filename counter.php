<?php
	include 'info.php';
	
	/*
	 * Project:     Posterous
	 * Description: Programatically create a site with an embed.
	 * Website:     coming soon
	 * 
	 * Author:      Ezra Velazquez
	 * Website:     http://ezraezraezra.com
	 * Date:        Jan 2012
	 * 
	 */

    class Counter {
    	var $info_object;
		var $connection;
		var $db_selected;
		
    	function Counter() {
    		$this->info_object = new info();
    	}
		
		function startApp() {
			$this->connection = mysql_connect($this->info_object->hostname, $this->info_object->user, $this->info_object->pwd);
			if(!$this->connection) {
				die("Error ".mysql_errno()." : ".mysql_error());
			}
			
			$this->db_selected = mysql_select_db($this->info_object->database, $this->connection);
			if(!$this->db_selected) {
				die("Error ".mysql_errno()." : ".mysql_error());
			}
		}
	
		function closeApp() {
			mysql_close($this->connection);
		}
		
		function submit_info($data, $conn, $return) {
			$result = mysql_query($data,$conn);
			if(!$result) {
				die("Error ".mysql_errno()." : ".mysql_error());
			}
			else if($return == true) {
				return $result;
			}
		}
		
		function createId() {
			// Create new entry on table
			$request_string = "INSERT INTO posterous (url_id) VALUES('holder')";
			$request = $this->submit_info($request_string, $this->connection, true);
			$id = mysql_insert_id();
			
			return $id;
		}
		
		function setURL($url_id, $table_id) {
			// Set the url based on ID
			$request_string = "UPDATE posterous SET url_id = '$url_id' WHERE id='$table_id'";
			$request = $this->submit_info($request_string, $this->connection, true);
		}
		
		function randomCharacter($id) {
			$alphaNumeric = "0123456789abcdefghigklmnopqrstuvwxyz";
			$key = array("a", "e", "i", "o", "u");
			$id_array = array();
			$str_id = "$id";
			$str_id_counter = 0;
			$unique_id = array();
			$result = "";
			
			// Set key
			$unique_id[2] = $key[strlen($str_id)];
			
			for($x = 5; $x > -1; $x--) {
				if($x != 2) {
					if(strlen($str_id) > ($str_id_counter)) {
						$unique_id[$x] = substr($str_id, $str_id_counter, 1);
						$str_id_counter = $str_id_counter + 1;
						//echo "top: ".$unique_id[$x]."<br/>";
					}
					else {
						$unique_id[$x] = substr($alphaNumeric, rand(0,34), 1);
						//echo "middle: ".$unique_id[$x]."<br/>";
					}
				}
				else {
					$unique_id[$x] = $key[strlen($str_id) - 1];
					//echo "bottom: ".$unique_id[$x]."<br/>";
				}
			}
			
			for($x = 0; $x < 6; $x++) {
				$result = $result.$unique_id[$x];
			}
			
			return $result;
		}
		
		function createURL() {
			$this->startApp();
				$id = $this->createId();
				$url_id = $this->randomCharacter($id);
				$this->setURL($url_id, $id);
			$this->closeApp();
			
			return $url_id;
		} 
			
    }

// $counter = new Counter();
// $counter->startApp();
// echo $counter->randomCharacter(1);
// $counter->closeApp();

?>
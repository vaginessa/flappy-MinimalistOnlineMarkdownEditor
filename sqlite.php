<?php 

//-- Functions for work with SqLite database  /
//-- open SqLite database ------------------- /

class MyDB extends SQLite3
{
   function __construct()
   {
      $this->open('db_main.db');
   }
}
$db = new MyDB();
if(!$db){
   echo $db->lastErrorMsg();
} else {
   echo "Opened database successfully<br />";
}

//------------------------------------------- /

// select data from tadabase
function selectFromSqLite($db){
	$ret = $db->query("SELECT * from USERS");
	while($row = $ret->fetchArray(SQLITE3_ASSOC) ){
	   echo "NAME = ". $row['NAME'] ."<br />";
	   echo "PASSWORD = ". $row['PASSWORD'] ."<br />";
	}
	echo "Operation done successfully<br />";
	// $db->close();
}

// insert data to database
function addDataToSqLite($db, $new_name, $new_password){
	$ret = $db->exec("INSERT INTO USERS (NAME,PASSWORD) VALUES ('".$new_name."', '".$new_password."')");
	if(!$ret){
	   echo $db->lastErrorMsg();
	} else {
	   echo "Records created successfully<br />";
	}
	// $db->close();
}

// update item in SqLite database (change password)
function updateSqLite($db){
	$ret = $db->exec("UPDATE USERS set NAME = 'newName' where ID=2");
	if(!$ret){
	   echo $db->lastErrorMsg();
	} else {
	   echo $db->changes(), " Record updated successfully<br />";
	}
}

// delete item from SqLite database
function deleteFromSqLite($db, $delete_name){
	$ret = $db->exec("DELETE from USERS where NAME = '".$delete_name."'");
	if(!$ret){
	 echo $db->lastErrorMsg();
	} else {
	  echo $db->changes(), " Record deleted successfully<br />";
	}
}

// create table in SqLite database
function createTableInSqLite($db){
$sql = "CREATE TABLE USERS(
NAME           TEXT NOT NULL,
PASSWORD       CHAR(50) NOT NULL)";

$ret = $db->exec($sql);
if(!$ret){
   echo $db->lastErrorMsg();
} else {
   echo "Table created successfully\n";
}
// $db->close();
}
?>
<html>
<head>
	<title>SqLite TEST</title>
</head>
<body>
<p>
Show data in DB:<br>
<?php
//createTableInSqLite($db);
addDataToSqLite($db, "NEW_NAME", "NEW_PASS");
//deleteFromSqLite($db, "NEW_NAME");
selectFromSqLite($db);

// need to put this at the end
$db->close();
?>
</p>
</body>
</html>
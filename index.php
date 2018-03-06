<?php
$hostname = "sql1.njit.edu";
$username = "cog3";
$password = "nguyen59";
$dbname = "cog3";
$conn = NULL;
try 
{
    $conn = new PDO("mysql:host=$hostname;dbname=$dbname",
    $username, $password);
    echo 'Connected successfully'.'<br>';
}
catch(PDOException $e)
{
	echo "Connection failed: " . $e->getMessage();
	http_error("500 Internal Server Error\n\n"."There was a SQL error:\n\n" . $e->getMessage());
}
function runQuery($query){
	global $conn;
	try{
	    $get = $conn->prepare($query);
	    $get->execute();
	    $products = $get->fetchAll();
	    $get->closeCursor();
	    return $products;
	}catch(PDOException $e){
		http_error("500 Internal Server Error\n\n"."There was a SQL error:\n\n" . $e->getMessage());
		}	  
}
function http_error($message) 
{
	header("Content-type: text/plain");
	die($message);
}

$sql = "select id,email,fname,lname,password from cog3.accounts where id < 6; ";
$output = runQuery($sql);	
if(count($output) > 0){
	echo "<table border=\"1\"><tr><th>ID</th><th>Email</th><th>First Name</th><th>Last Name</th><th>Password</th></tr>";
	foreach ($output as $row) {
		echo "<tr><td>".$row["id"]."</td><td>".$row["email"]."</td><td>".$row["fname"]."</td><td>".$row["lname"]."</td><td>".$row["password"]."</td></tr>";
	}
		echo 'Number of results: '.count($output);
	}else{
    	echo 'No results';
	}




?>
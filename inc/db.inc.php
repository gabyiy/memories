<?php 
$host = "localhost";
$username = "root";
$password="";
$db= "memories";

$con = @mysqli_connect($host,$username,$passowrd);

if(@$con){

    if(@mysqli_select_db($con,$db));
}

?>
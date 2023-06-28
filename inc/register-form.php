<div class="register-form" >
    <h1>Register</h1>
<form method="post" id="register-form" action="register-page.php">
<input type="text" name="fName" id="fName" placeholder="Enter first name"/>
<input type="text" name="lName" id="lName" placeholder="Enter you r last name"/>
<input type="email" name="email" id="email" placeholder="Enter you r email">
<input type="password" name="password" id="password" placeholder="Enter you r password">
<input  type="password" name="confirm-password" id="confirm-password" placeholder="Confir you r password"/>
<textarea type="text" name="bio" id="bio" placeholder=""></textarea>

<input type="submit" name="submit" id="submit" value="Register"/>
</form>
<div id="error"></div>
<div id="success"></div>
</div>

<?php 

$id="";
$fName="";
$lName="";
$username="";
$email="";
$password="";
$bio="";
$uploads=0;
$error =  array();

function sanitaize($data){

    $data = trim($data);
    $data = htmlspecialchars($data);
    $data = stripslashes($data);

    return ($data);

}

function     register_user($con,$id,$fName,$lName,$username,$email,$password,$bio,$uploads){

$codedPassword =md5($password);
    $query = "insert into users values ('$id','$fName','$lName','$username','$email','$codedPassword','$bio','$uploads')";

    $query_run = mysqli_query($con,$query);

if($query_run){
?>
<script type="text/javascript">
    $("#success").append("User created <a href='login-page.php'> Click here to login </a>");
</script>
<?php
}else{
    ?>
    <script type="text/javascript">
        $("#error").append("User not created");
    </script>
    <?php  
}

}
if(isset( $_POST["submit"])){

    if(empty($_POST["fName"])){
   $error[] = "Please enter you r first name";
    }elseif(strlen($_POST["fName"])>25){
        $error[] ="You r name must not have more then 25 characters";
    }else{
        $fName= sanitaize($_POST["fName"]);
    }

    if(empty($_POST["lName"])){
        $error[] = "Please enter you r  last name";
    }elseif (strlen($_POST['lName'])>25){
        $erorr[] = "You r name must not have more then 25 chararcters";
    }else{
        $lName= sanitaize(($_POST["lName"]));
    }
    if(empty($_POST['email'])){
        $erorr[]= "Pleaee enter you r  email";
    }elseif(strlen($_POST['email'])>50){
        $error[] ="You r email must not have more theb 50 characters";
    }else{
        $email= sanitaize($_POST["email"]);
    }
    if(empty($_POST["password"])){
        $error[]="you must enter a password";
    }elseif(strlen($_POST['password'])>30){
        $error[]= "You r password should not have more then 40 characters";

        if(!empty($_POST["confirm-password"])){

        }elseif($_POST["password"]!=$_POST["confirm-password"]){
            $error[]="You r password shoud match the confirmed password";
        }else {
            $error[]= "confirm you r password";
        }
    }else{
        $password = sanitaize($_POST['password']);
    }

    

if(count($error)==0){
    $username= $fName.$lName;
    $query_username = "select * from users where username='$fName'";
    $query_run_username=mysqli_query($con,$query_username);

    $query_email = "select * from users where email= '$email'";
    $query_run_email = mysqli_query($con,$query_email);


    if(mysqli_num_rows($query_run_username)>0){
?>
<script type="text/javascript">
$("#error").append("<p> Username already exist");
</script>
<?php
    }if (mysqli_num_rows($query_run_email)>0){
?>
<script type="text/javascript">
    $("#error").append("Email allready exist");
</script>
<?php
    }
    
    else{
    register_user($con,$id,$fName,$lName,$username,$email,$password,$bio,$uploads);
    }
}else{

    foreach($error as $key =>$value){
        ?>
        <script type="text/javascript">
            $(".error").append("<?php echo $value.'<br>';?>");
        </script>
        <?php
    }
}

}

?>
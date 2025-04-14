<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    function newRegistration(){
        window.open("registration.php");
    }

    function submitForm(){
        document.getElementById('actionbutton').value='Submit';
        frm1.submit();
    }

</script>
  
  
</head>
<body>
    
    
<?php 
$areaid=$_SESSION["areaid"];
require_once 'connection.php'; 

$sellerid=0;
$actionbutton='';
if(isset($_POST['actionbutton'])) { $actionbutton=$_POST['actionbutton']; };

if($actionbutton=="Submit"){
    
    $userid=$_POST["userid"]-1111;
    $userpassword=$_POST["userpassword"];
    
    $res1 = $connect->query("select sellerid from sellermaster where sellerid='".$userid."' and password='".$userpassword."'");
    if($row1 = mysqli_fetch_array($res1)) { 
        $sellerid=$row1["sellerid"];
        $_SESSION["sellerid"]=$sellerid;
        echo "<script>window.location.href='sellermain.php';</script>";
        
    }
}


?>    

<div class="container">
  <div class="container p-3 my-3 bg-dark text-white">
  <h2>Sign In</h2>
  </div>
    <form name='frm1' id='frm1' action='signin.php' method='post' >
    <div class="form-group">
      <input type="text" class="form-control" id="userid" placeholder="User ID" name="userid">
    </div>
    <div class="form-group">
      <input type="password" class="form-control" id="userpassword" placeholder="Password" name="userpassword">
    </div>
    <button type="submit" class="btn btn-success" onclick='submitForm()'>Submit</button>
    <button type="button" class="btn btn-success" onclick='window.close();'>Cancel</button>
    <input type='hidden' name='actionbutton' id='actionbutton' value='' >
  </form>
</div>

</body>
</html>

<?php
session_start();

require_once "config.php";

$uid=$_SESSION["id"];
$uname=$_SESSION["username"];
$type=$header=$venue=$date=$time=$footer=$user="";
$err="";
if($_SERVER["REQUEST_METHOD"] == "POST"){
if(empty($_POST['type']) ||	empty(trim($_POST['header'])) || empty(trim($_POST['onDate'])) || empty(trim($_POST['onDate'])))
	$err="Please fill in the mandatory(*) fields";
else{
	$type=$_POST['type'];
	$header=$_POST['header'];
	$venue=$_POST['Venue'];
	$date=$_POST['onDate'];
	$time=$_POST['time'];
	$footer=$_POST['footer'];
	$ddate=$_POST['Ddate'];
	$dtime=$_POST['Dtime'];
	$reg=" INSERT INTO eventtable(uid,uname,type,header,venue,date,time,footer,deadlinedate,deadlinetime) VALUES('$uid','$uname','$type','$header','$venue','$date','$time','$footer','$ddate','$dtime')";
	if(mysqli_query($link,$reg))
	{
		$last_id = mysqli_insert_id($link);
	
		$user=array_keys($_POST['user']);
		if(!empty($_POST['user']))
		{
			$N=count($user);
			$uname="";    		
			foreach($user as $var){
				$sql = "SELECT username FROM users where id=?";
				if($stmt = mysqli_prepare($link, $sql)){
					mysqli_stmt_bind_param($stmt, "i", $param_id);
					$param_id = $var;
					$uname="";
					if(mysqli_execute($stmt)){
						mysqli_stmt_bind_result($stmt,$uname);
						mysqli_stmt_fetch( $stmt );
					}
					mysqli_stmt_close($stmt);
				}
				$ins="INSERT INTO invite(eno,userid,name) VALUES('$last_id','$var','$uname')";
				mysqli_query($link,$ins);
			}
		}
	}
	header("location: welcome.php");
	}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" type="text/css" href="formsty.css">
</head>
<body>
<div class="wrapper">
	<h1> Fill the event details</h1>
	<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
		<div class="form-group">
			<label ><b>Type*:</b></label>
			<input type="radio" name="type" value="Birthday">Birthday
			<input type="radio" name="type" value="Party">Party
			<input type="radio" name="type" value="Marriage">Marriage
			<input type="radio" name="type" value="Funeral">Funeral	
			<input type="radio" name="type" value="Other">Other			
		</div>
		<br>
		<div class="form-group">
			<label><b>Header*:</label>
			<input type="text" name="header" class="form-control">
		</div>
		<br>
		<label>Details :</label>
		<br>
		<div class="form-group">
			<label>Venue:</label>
			<input type="text" name="Venue" class="form-control">
		</div>
		<br>
		<div class="form-group">
			<label>Date*:</label>
			<input type="date" name="onDate" placeholder="dd-mm-yyyy" value="" class="form-control">
		</div>
		<br>
		<div class="form-group">
			<label>Time*:</label>
			<input type="time" name="time" class="form-control" required>
		</div>
		<br>
		<div class="form-group">
			<label>Footer:</label>
			<input type="text" name="footer" class="form-control">
		</div>
		<div class="form-group">
			<label>Deadline*:</label>
			<input type="date" name="Ddate" placeholder="dd-mm-yyyy" value="" class="form-control">
			<input type="time" name="Dtime" class="form-control" required>
		</div>

		<label>Invite </b></label>
		<br>

		<span><?php 
		 $sql = "SELECT username,id FROM users where id != ?";
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $param_id);
            $name=$userid="";
            // Set parameters
            $param_id = $_SESSION["id"];
            // Attempt to execute the prepared statement
            if(mysqli_execute($stmt)){
                // store result
                mysqli_stmt_bind_result($stmt,$name,$userid);		
					while(mysqli_stmt_fetch( $stmt ) ) { ?></span>
		<p><input type='checkbox' name='user[<?php echo $userid;?>]' value='<?php echo $userid;?>'>
		<span><?php 
		echo "$name</p>"; 
			}
		  }
			mysqli_stmt_close($stmt);
		}
		mysqli_close($link);
		?></span>
		<br>	
		<span class="help-block"><?php echo $err; ?></span>
		<button type="submit" class="btn-primary">Create</button>
</div>		
</body>
</html>		

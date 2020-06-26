<?php
	session_start();
	require_once "config.php";
	$no = $_GET['no'];
	$sql = "SELECT header,venue,date,time,footer FROM eventtable where no=?";

	$header=$dispvenue=$date=$time=$dispfooter=$venue="";
    if($stmt = mysqli_prepare($link, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "i", $no);    
        // Set parameters   
        // Attempt to execute the prepared statement
		if(mysqli_execute($stmt)){
        /* store result */
        mysqli_stmt_bind_result($stmt,$header,$venue,$date,$time,$footer);			
		mysqli_stmt_fetch( $stmt );
		if(!empty($venue)){
			$dispvenue="Venue:";
		}
		if(!empty($footer)){
			$dispfooter=$footer;
		}		
		}else{
            echo "Oops! Something went wrong. Please try again later.";
        }
		mysqli_stmt_close($stmt);
	}
	$uid=$_SESSION["id"];
	$uname=$_SESSION["username"];

	$noofp=$eno='';
	$status=$food="";
	if($_SERVER["REQUEST_METHOD"] == "POST"){
			$food=$_POST['veg'];
			$noofp=$_POST['nop'];
			$eno=$no;
			$status=$_POST['submit'];
			$reg="UPDATE invite SET food='$food',people='$noofp',status='$status' WHERE eno='$eno' and userid='$uid'"; 
			mysqli_query($link,$reg);
			header("location: welcome.php");
	}
	mysqli_close($link);
?>
<html>
<head>
<title>Invitation</title>
<link rel="stylesheet" type="text/css" href="invitesty.css">
<body>
<div class="Invitation">
	<h1 class="heading"><b>INVITATION</h1>
	<p class="header"><?php echo htmlspecialchars($header); ?></p>
	<div class="details">
		<p><?php echo htmlspecialchars($dispvenue); ?><?php echo htmlspecialchars($venue); ?></p>
		<p><b>Date: <?php echo htmlspecialchars($date); ?></p>
		<p><b>Time: <?php echo htmlspecialchars($time); ?></p>
	</div>	
	<p class="footer"><?php echo htmlspecialchars($dispfooter); ?></p>
	<form method="post" action="viewandrespond.php?no=<?php echo $no; ?>">
		<label>Food Preference:</label>
		<input type="radio" name="veg" value="veg">
		<label>Veg</label>
		<input type="radio" name="veg" value="non">
		<label>Non-Veg</label>
		<br><br>
		<label>No of people comming:</label>
		<input type="number" name="nop" min="0">
		<br><br>
		<input type="submit" name="submit" value="accept" id="acc" style="background-color: green; color: white">
		<br><br>
		<input type="submit" name="submit" value="reject" style="background-color: red;color: white" id="reject">
	</form>
</div>
</body>
</html>
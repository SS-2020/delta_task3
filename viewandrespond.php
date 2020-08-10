<?php
	session_start();
	require_once "config.php";
	$no = $_GET['no'];
	$uid=$_SESSION["id"];
	$uname=$_SESSION["username"];
	$curdate=$curtime="";
	//to remove notification
	$query="UPDATE invite SET notify=0 WHERE eno='$no' and userid='$uid'";
	mysqli_query($link,$query);
	$src='';
	$sql1 = "SELECT type,header,venue,date,time,footer,deadlinedate,deadlinetime FROM eventtable where no=?";
	$type=$header=$dispvenue=$date=$time=$dispfooter=$venue=$Ddate=$Dtime="";
    if($stmt = mysqli_prepare($link, $sql1)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "i", $no);    
        // Set parameters   
        // Attempt to execute the prepared statement
		if(mysqli_execute($stmt)){
        mysqli_stmt_bind_result($stmt,$type,$header,$venue,$date,$time,$footer,$Ddate,$Dtime);			
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
	$noofp=$eno='';
	$status=$food="";
	if($_SERVER["REQUEST_METHOD"] == "POST"){
			$food=$_POST['veg'];
			$noofp=$_POST['nop'];
			$eno=$no;
			$status=$_POST['submit'];
			$reg="UPDATE invite SET food='$food',people='$noofp',status='$status',notify=2 WHERE eno='$eno' and userid='$uid'"; 
			mysqli_query($link,$reg);
			header("location: welcome.php");
	}
	if($type=="Birthday"){
		$src='images/birthday.jpg';
	}
	else if($type=="Party"){
		$src='images/party.jpg'; 
	}
	else if($type=="Marriage"){
		$src='images/marriage.jpg'; 
	}
	else if($type=="Funeral"){
		$src='images/funeral.jpg';
	}
?>
<html>
<head>
<title>Invitation</title>
<link rel="stylesheet" type="text/css" href="invitesty.css">
<body style="background-image:url(<?php echo htmlspecialchars($src); ?>);">
<div class="Invitation">

	<h1 class="heading"><b>INVITATION</h1>
	<p class="header"><?php echo htmlspecialchars($header); ?></p>
	<div class="details">
		<p><?php echo htmlspecialchars($dispvenue); ?><?php echo htmlspecialchars($venue); ?></p>
		<p><b>Date: <?php echo htmlspecialchars($date); ?></p>
		<p><b>Time: <?php echo htmlspecialchars($time); ?></p>
	</div>	
	<p class="footer"><?php echo htmlspecialchars($dispfooter); ?></p>
	<p class="dline">Deadline: <?php echo htmlspecialchars($Ddate)."   ".htmlspecialchars($Dtime); ?></p>
	<span><?php 
		//get current date and time and check with deadline
		$sql2="SELECT CURDATE()";
		$result2=mysqli_query($link,$sql2);
		while($row2=mysqli_fetch_assoc($result2)){
			$curdate=$row2['CURDATE()'];
		}
		$sql3="SELECT CURTIME()";
		$result3=mysqli_query($link,$sql3);
		while($row3=mysqli_fetch_assoc($result3)){
			$curtime=$row3['CURTIME()'];
		}
		if(($curdate<$Ddate)||(($curdate==$Ddate)&&($curtime<$Dtime)))
		{
			?></span>
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
			<span><?php
		}
		else{
			echo"<p>Deadline Over!</p>";
		}
		mysqli_close($link);
	?></span>

</div>
</body>
</html>

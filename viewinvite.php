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
mysqli_close($link);
?>
<html>
<head>
<title>Invitation</title>
<link rel="stylesheet" type="text/css" href="invitesty.css">
</head>
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
</div>
</body>
</html>
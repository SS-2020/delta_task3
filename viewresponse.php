<?php
	session_start();
	require_once "config.php";
	$no = $_GET['no'];
	$user=isset($_GET['user'])?$_GET['user']:"";
	$query="UPDATE invite SET notify=0 WHERE eno='$no' and name='$user'";
	mysqli_query($link,$query);
	$sql = "SELECT type,header,venue,date,time,footer FROM eventtable where no=?";
	$src='';
	$type=$header=$dispvenue=$date=$time=$dispfooter=$venue="";
    if($stmt = mysqli_prepare($link, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "i", $no);    
        // Set parameters   
        // Attempt to execute the prepared statement
		if(mysqli_execute($stmt)){
        /* store result */
        mysqli_stmt_bind_result($stmt,$type,$header,$venue,$date,$time,$footer);			
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
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Invitation</title>
<link rel="stylesheet" type="text/css" href="invitesty.css">
</head>
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
		<span><?php 
			$sql = "SELECT name,food,people FROM invite where eno=? and status=?";
			if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "is", $no,$sta);
            $sta="accept";
            // Attempt to execute the prepared statement
            if(mysqli_execute($stmt)){
                /* store result */
				$i=1;
                mysqli_stmt_bind_result($stmt,$name,$food,$people);		
					while(mysqli_stmt_fetch( $stmt ) ) {
						if($i==1)
						{
							echo "<p style='color:green'>Accepted:</p>";
							$i++;
						}
						echo " <p>NAME: $name FOOD:$food  NUMBER:$people </p> ";
					}
			}else{
                echo "Oops! Something went wrong. Please try again later.";
            }
			mysqli_stmt_close($stmt);
			}
						$sql = "SELECT name FROM invite where eno=? and status=?";
			if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "is", $no,$sta);
            $sta="reject";
            // Attempt to execute the prepared statement
            if(mysqli_execute($stmt)){
                /* store result */
				$i=1;
                mysqli_stmt_bind_result($stmt,$name);		
					while(mysqli_stmt_fetch( $stmt ) ) {
						if($i==1)
						{
							echo "<p style='color:red'>Rejected:</p>";
							$i++;
						}
						echo " <p>NAME: $name</p> ";
					}
			}else{
                echo "Oops! Something went wrong. Please try again later.";
            }
			mysqli_stmt_close($stmt);
			}
		?></span>
</div>
</body>
</html>

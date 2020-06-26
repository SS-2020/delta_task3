<?php
// Initialize the session
session_start();
require_once "config.php"; 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
	
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <style type="text/css">
        body{ 
		font: 14px sans-serif; 
		text-align: center; 
		background-color: orange;
		}
		.page-header{
			position: absolute;
			left:5%;
		}
		#logout{
			position: absolute;
			top:5%;
			right:10%;
			background-color: blue;
			color: black;
		}
		button{
			background-color: #87CEEB;
			color: #FF0000;
			border: solid green 2px;
		}
		.events{
			position: absolute;
			left:8%;
			top:15%
		}
		.invites{
			position: absolute;
			left:30%;
			top:15%;
			}
		.scheduled{
			position: absolute;
			left:60%;
			top:15%;
			}			
    </style>
</head>
<body>
    <div class="page-header">
        <h1>Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?> </b>! Welcome!</h1>
		<h2>Dashboard</h2>
	</div>
    <p >
        <a href="logout.php" ><button id="logout">Log Out</button></a>
    </p>
	<div class='events'>
		<h3>Your Events:</h3>
		<span><?php 
			$sql = "SELECT no,type,date,time FROM eventtable where uid=?";
			if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $param_id);
            $no="";
            // Set parameters
            $param_id = $_SESSION["id"];
            
            // Attempt to execute the prepared statement
            if(mysqli_execute($stmt)){
                /* store result */
                mysqli_stmt_bind_result($stmt,$no,$type,$on,$time);		

					while(mysqli_stmt_fetch( $stmt ) ) {
					echo " <p><button>Event: $type On:$on <br>Time:$time <br>";?></sapn>
					<a href='viewresponse.php?no=<?php echo $no; ?>' >View Invite Response</a>
				<span><?php echo" </button></p> ";
					}
			}else{
                echo "Oops! Something went wrong. Please try again later.";
            }
			mysqli_stmt_close($stmt);
		}
		?></span>
		<p><a href="addevent.php">Add event</a></p>
	</div>
	<div class='invites'>
		<h3>Event Invites:</h3>
		<span><?php 
		$param_id = $_SESSION["id"];
		$query="SELECT eno FROM invite where userid='$param_id' and status IS NULL";

				$result= mysqli_query($link,$query);
				while($eno=mysqli_fetch_assoc( $result) ) {
					$sql = "SELECT uname,type,date,time FROM eventtable where no=?";
					
					if($stmt2 = mysqli_prepare($link, $sql)){
						mysqli_stmt_bind_param($stmt2, "s", $no);
						$no = $eno['eno'];
						if(mysqli_execute($stmt2)){
							mysqli_stmt_bind_result($stmt2,$name,$type,$on,$time);		
							
							while(mysqli_stmt_fetch( $stmt2 ) ) {
								echo " <p><button>From: $name<br> Event: $type On:$on <br>Time:$time <br> ";?></span>
								<a href='viewandrespond.php?no=<?php echo $no; ?>'>View Invitation and Respond</a>
								<span><?php echo" </button></p> ";
							}
						}else{
							echo "Oops! Something went wrong 2. Please try again later.";
						}
					
						mysqli_stmt_close($stmt2);
					}
				}	
		?>
	</span>
	</div>
	<div class='scheduled'>
		<h3>SCHEDULED EVENTS:</h3>
		<span><?php 
		$param_id = $_SESSION["id"];
		$query="SELECT eno FROM invite where userid='$param_id' and status='accept' ";

				$result= mysqli_query($link,$query);
				while($eno=mysqli_fetch_assoc( $result) ) {
					$sql = "SELECT uname,type,date,time FROM eventtable where no=?";
					
					if($stmt2 = mysqli_prepare($link, $sql)){
						mysqli_stmt_bind_param($stmt2, "s", $no);
						$no = $eno['eno'];
						if(mysqli_execute($stmt2)){
							mysqli_stmt_bind_result($stmt2,$name,$type,$on,$time);		
							
							while(mysqli_stmt_fetch( $stmt2 ) ) {
								echo " <p><button>From: $name<br> Event: $type On:$on <br>Time:$time <br>";?></span>
								<a href='viewinvite.php?no=<?php echo $no; ?>'>View Invitation</a>
								<span><?php echo" </button></p> ";
							}
						}else{
							echo "Oops! Something went wrong 2. Please try again later.";
						}
					
						mysqli_stmt_close($stmt2);
					}
				}	
		mysqli_close($link);
		?>
		</span>
	</div>
</body>
</html>
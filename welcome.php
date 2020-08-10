<?php
// Initialize the session
session_start();
require_once "config.php"; 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
$uname=$_SESSION["username"];	
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
	<link href="welcomesty.css" rel="stylesheet" type="text/css">
</head>
<body>
    <div class="page-header">
        <h1>Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?> </b>! Welcome!</h1>
		<h2>Dashboard</h2>
		<h3 onclick="viewnot()">Notifications     -></h3>
		<h3 onclick="vieweve()">Your Events       -></h3>
		<h3 onclick="viewinv()">Event Invites     -></h3>
		<h3 onclick="viewsch()">Scheduled Events  -></h3>
        <a href="logout.php" id="logout" >Log Out</a>
	</div>

	<div class="notifications">
		<h2>NOTIFICATIONS:</h2><ul>
		<span><?php
			$param_id=$_SESSION['id'];
			$query1="SELECT eno FROM invite WHERE userid='$param_id' AND notify=1";
			$result1=mysqli_query($link,$query1);
			while($eno=mysqli_fetch_assoc( $result1) ) {
				$no=$eno['eno'];
				$query2="SELECT uname FROM eventtable WHERE no='$no'";
				$result2=mysqli_query($link,$query2);
				while($ename=mysqli_fetch_assoc( $result2) ) {
					$n=$ename['uname'];
					echo"<li>$n has invited you</li>";?></span>
					<a href='viewandrespond.php?no=<?php echo $no; ?>'>View and Respond</a>
				<span><?php
				}
			}
			$query3="SELECT no,type FROM eventtable WHERE uname='$uname'";
			$result3=mysqli_query($link,$query3);
			while($ans=mysqli_fetch_assoc($result3)) {
				$event=$ans['type'];
				$no=$ans['no'];
				$query4="SELECT name FROM invite WHERE eno='$no' AND notify=2";
				$result4=mysqli_query($link,$query4);
				while($name=mysqli_fetch_assoc( $result4) ) {
					$user=$name['name'];
					echo "<p>$user has responded to your $event invite</p>";?></span>
					<a href='viewresponse.php?no=<?php echo $no; ?>&user=<?php echo $user;?>' >View Invite Response</a>
					<span><?php
				}
			}
		?></span></ul>
	</div>
	<div class="events">
		<h2>YOUR EVENTS:</h2>
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
					echo " <button>Event: $type On:$on <br>Time:$time <br>";?></span>
					<a href='viewresponse.php?no=<?php echo $no; ?>' >View Invite Response</a>
				<span><?php echo" </button>";
					}
			}else{
                echo "Oops! Something went wrong. Please try again later.";
            }
			mysqli_stmt_close($stmt);
		}
		?></span>
		<p><a href="addevent.php">Add event</a></p>
	</div>
	<div class="invites">
		<h2>EVENT INVITES:</h2>
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
								echo " <button>From: $name<br> Event: $type On:$on <br>Time:$time <br> ";?></span>
								<a href='viewandrespond.php?no=<?php echo $no; ?>'>View Invitation and Respond</a>
								<span><?php echo" </button>";
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
	<div class="scheduled">
		<h2>SCHEDULED EVENTS:</h2>
		<span><?php 
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
								echo " <button>From: $name<br> Event: $type On:$on <br>Time:$time <br>";?></span>
								<a href='viewinvite.php?no=<?php echo $no; ?>'>View Invitation</a>
								<span><?php echo" </button>";
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
	<script>
		function viewnot(){
			document.querySelector(".notifications").style.display="block";
			document.querySelector(".events").style.display="none";
			document.querySelector(".invites").style.display="none";
			document.querySelector(".scheduled").style.display="none";
		}
		function vieweve(){
			document.querySelector(".notifications").style.display="none";
			document.querySelector(".events").style.display="block";
			document.querySelector(".invites").style.display="none";
			document.querySelector(".scheduled").style.display="none";
		}
		function viewinv(){
			document.querySelector(".notifications").style.display="none";
			document.querySelector(".events").style.display="none";
			document.querySelector(".invites").style.display="block";
			document.querySelector(".scheduled").style.display="none";
		}
		function viewsch(){
			document.querySelector(".notifications").style.display="none";
			document.querySelector(".events").style.display="none";
			document.querySelector(".invites").style.display="none";
			document.querySelector(".scheduled").style.display="block";
		}
	</script>
</body>
</html>

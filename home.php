<?php
session_start();
include "conn.php";
if(isset($_SESSION['name']))
{
?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="css/style.css">
<style type="text/css">
.divCentered {
	width: 40%;
    height:100px;
    margin-top: 150px;
    position: absolute;
	top: 10px;
	display: flex;	
	justify-content: center;
}
.alert {
    padding: 30px;
    background-color: #f44336; /* Red */
    color: white;
    margin-bottom: 15px;
}
.alertGreen {
    padding: 30px;
    background-color: #47d420; /* Green */
    color: white;
    margin-bottom: 15px;
}
.closebtn {
    margin-left: 15px;
    color: white;
    font-weight: bold;
    float: right;
    font-size: 22px;
    line-height: 20px;
    cursor: pointer;
    transition: 0.3s;
}
.closebtn:hover {
    color: black;
}
</style>
</head>
<body>
<div class="nav">
  <input type="checkbox">
    <span></span>
    <span></span>
    <div class="menu">
      <li><a href="home.php">home</a></li>
      <li><a href="home.php?part=resetPassword">reset Password</a></li>
      <li><a href="logout.php">Logout</a></li>
    </div>
</div>
<?php
	if ($_GET['part'] == "resetPassword") 
	{
		?>
		<div class="divCentered">
			<div>
				<form method="POST" action="home.php">		
					<p><input type="text" class="textbox" placeholder="Email" name="username" required="" /> </p>	
					<p><input type="text" class="textbox" placeholder="New Password" name="newPassword" required="" /> </p>	
					<p><input type="text" class="textbox" placeholder="Confirm Password" name="confirmPass" required="" /></p>
					<p align="center"><button class="button">Reset</button></p>
				</form>
	
			</div>
		</div>

		<?php
	}
?>

<?php
if(isset($_POST['username']) && isset($_POST['newPassword']) && isset($_POST ['confirmPass']))
{

	$query=$conn->prepare("SELECT email FROM users WHERE email= ?");
	$query->bind_param("s", $_POST['username']);
	$query->execute();
	$result = $query->get_result();
	$users = $result->fetch_assoc();

	if($users['email'] !== $_POST['username'])
	{
		?>
		<div class="divCentered">
			<div class="alert">
			  <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
			  <b>Error!</b> User does not exist.
			</div>
		</div>
		<?php
	} 
	elseif($users['email'] === $_POST['username'])
	{			
		if ($_POST['newPassword'] === $_POST['confirmPass']) 
		{
			$password = md5($_POST['newPassword']);
			$username = $_POST['username'];
			$stmt = $conn->prepare("UPDATE users SET passwd = ? WHERE email = ?");
			$stmt->bind_param("ss", $password, $username);
			$stmt->execute();
			$stmt->close();
			if($stmt)
			{
				?>
				<div class="divCentered">
					<div class="alertGreen">
					  <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
					  <b>Success!</b> Password has been changed.
					</div>
				</div>
				<?php
			} 
		} 
		else 
		{   
			?>
				<div class="divCentered">
					<div class="alert">
					  <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
					  <b>Error!</b> Password does not match.
					</div>
				</div>

			<?php
		}
	} else {
		?>
		<div class="divCentered">
			<div class="alert">
			  <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
			  <b>Error!</b> Wrong format.
			</div>
		</div>
		<?php
	}
}
?>

<div>
	<span class="nortification animateOpen"><?php echo "You logged in as ". $_SESSION['name']; ?></span>
</div>
</body>
</html>
<?php
} else {
	header("Location: index.php");
	exit();
}
?>

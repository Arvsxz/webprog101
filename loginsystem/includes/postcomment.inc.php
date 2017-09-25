<?php
session_start();
if(!isset($_SESSION['u_id'])){
	//include_once 'dialogboxloginfirst.inc.php';

  	header("Location: ../main.php?loginfirst");
	exit();
}
else if(isset($_SESSION['u_id'])){

	if (isset($_POST['submit'])) {

		include_once 'dbh.inc.php';
	
		$comment = mysqli_real_escape_string($conn, $_POST['commentEnter']);
		$postcommentidGet = mysqli_real_escape_string($conn, $_GET['id']);		

		//Error handlers
		//Check for empty fields
		if (empty($comment)) {
			header("Location: ../detail.php?id=".$_GET['id']."&commentfields=empty");
			exit();
		} 
			//Check if input characters are valid
				//Check if email is valid
			else {
				$sql = "SELECT * FROM comments WHERE comment_content='$comment'";
				$result = mysqli_query($conn, $sql);
				$resultCheck = mysqli_num_rows($result);

					if ($resultCheck > 0) {
						//header("Location: ../main.php?duplicatecomment");
						header("Location: ../detail.php?id=".$_GET['id']."&comment=duplicate");
						exit();
					} 

					else {
						//inserting question to database
						//$hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);
						//Insert the user into the database
						$username=$_SESSION['u_uid'];
						$sql = "INSERT INTO comments (comment_content, postcomment_id, comment_username) VALUES ('$comment', '$postcommentidGet','$username')";

						//$idpost = $_GET['id'];
						mysqli_query($conn, $sql);
						header("Location: ../detail.php?id=".$_GET['id']."");
						//<a href='detail.php.?id=".$row['posts_id']."'>
						//echo "<a href='http://localhost/loginsystem///detail.php?id=".$_SESSION["idcomment"]."'>lmaoo</a>";
						exit();
					}
				}
			
		

	} else {
		header("Location: ../signup.php");
		exit();
	}
}
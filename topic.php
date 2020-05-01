<?php
session_start();
require_once('./db.php');
?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="./style.css">
</head>
<body>
	<?php

	$topic = $_GET['topic'];
	$sqlb = 'SELECT * FROM Topic WHERE id ='.$topic;
	$selectb = mysqli_query($cnx, $sqlb);
	while($sb = mysqli_fetch_assoc($selectb)){
	?>
	<p><?php echo $sb['title'];?></p>
	<?php
	}
	$sql = 'SELECT * FROM Post WHERE Topic_id = '.$topic;
	$select = mysqli_query($cnx, $sql);
	while($s = mysqli_fetch_assoc($select)){
		$post = $s['id'];
		$_user = $s['User_id'];
	?>
	<div class="post">
		<p><?php echo $s['content']?></p>
	<?php
		if(isset($_SESSION['id_user'])){
			$user =  $_SESSION['id_user'];
			if($_user == $user){
				?>
				<a onclick="location.href='?topic=<?php echo $topic;?>&delete=<?php echo $post?>'">Delete</a>
			<?php
			}
		}
		?>
	</div>
		<?php
	}
	if(isset($_SESSION['id_user'])){
	?>
	<form id ="post_create" method="POST">
		<textarea name="content"></textarea>
		<input type="submit" name="up">
	</form>
	<?php
		if(isset($_POST['up'])){
			$content = mysqli_real_escape_string($cnx, $_POST['content']);
			$user = $_SESSION['id_user'];
			if($content&&$topic){
				$sql = 'INSERT INTO Post SET content = "'.$content.'", Topic_id = '.$topic.', User_id = '.$user;
				mysqli_query($cnx, $sql);
				header('Location: topic.php?topic='.$topic);
			}
		}
		if(isset($_GET['delete'])){
			$user = $_SESSION['id_user'];
			$delete = $_GET['delete'];
			$sql = "DELETE FROM Post WHERE id = $delete 
			AND Topic_id = (SELECT id FROM Topic WHERE id = $topic)
			AND User_id = (SELECT id FROM User WHERE id = $user)";
			mysqli_query($cnx, $sql);
			header('Location: topic.php?topic='.$topic);

		}
	}
	else{
	?>
	<p>Pour déposer un message, veuillez vous <a href="./user.php">connectez</a>.</p>
	<?php
	}
?>
</body>
</html>
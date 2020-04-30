<?php
session_start();
require_once('./db.php');
?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<?php
	$topic = $_GET['topic'];
	$sql = 'SELECT * FROM Post WHERE Topic_id = '.$topic;
	$select = mysqli_query($cnx, $sql);
	while($s = mysqli_fetch_assoc($select)){
	?>
	<div><?php echo $s['content']?></div>
	<?php
	}
	if(isset($_SESSION['id_user'])){
	?>
	<form method="POST">
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
	}
	else{
	?>
	<p>Pour déposer un message, veuillez vous <a href="./user.php">connectez</a>.</p>
	<?php
	}
?>
</body>
</html>
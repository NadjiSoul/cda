<?php
session_start();
require_once('db.php');
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="./style.css">
</head>
<header>
	<nav>
		<ul>
			<li><a href="./index.php">Home</a></li>
			<?php 
			$sql = 'SELECT * FROM Category';
			$select = mysqli_query($cnx, $sql);
			while($s = mysqli_fetch_assoc($select)){
			?>
			<li><a onclick="location.href='?category=<?php echo $s['id']?>'"><?php echo $s['label']; ?></a></li>
			<?php
			}
			if(isset($_SESSION['id_user'])){
				?>
			<li class="disconnect"><a href="./disconnect.php">Se deconnecter</a></li>
			<?php
			}
			else{
			?>
			<li class="connect"><a href="./user.php">Se connecter</a></li>
			<?php
			}
			?>
		</ul>
	</nav>
</header>
<body>
	<?php
	if(isset($_SESSION['id_user'])){
	?>
	<a id="button_topic" href="./topic_create.php">Créer un Topic</a>
	<?php
	}
	else{
	?>
	<p>Afin de créer un topic, veuillez vous <a href="./user.php">connectez</a>.</p>
	<?php
	}
	?>
	<section id="show">
		<?php
		if(isset($_GET['category'])){
			$cat = $_GET['category'];
			$sql = 'SELECT * FROM Topic WHERE Category_id = '.$cat;
		}
		else{
			$sql = 'SELECT * FROM Topic';
		}
		$select = mysqli_query($cnx, $sql);

		while($s = mysqli_fetch_assoc($select)){
		?>
		<article>
			<?php echo $s['title']; ?>
			<a onclick="location.href='./topic.php?topic=<?php echo $s['id'];?>'">Visualiser</a>
		</article>
		<?php
		}
		?>
	</section>
</body>
</html>
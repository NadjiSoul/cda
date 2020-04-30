<?php
session_start();
require_once('./db.php');

/*
$sql = "SELECT Topic.*, Category.label AS category_label FROM Topic
		INNER JOIN Category ON Topic.Category_id = Category.id";
$select = mysqli_query($cnx, $sql);
while($s = mysqli_fetch_assoc($select)){
	?>
	<li><?php echo $s['category_label'];?></li>
	<?php
}
*/
if(isset($_POST['valid'])){
	$title = $_POST['title'];
	$user = $_SESSION['id_user'];
	$label = $_POST['category']
	$sql = "INSERT INTO Topic SET title = '$title', Category_id = (SELECT id FROM Category WHERE label = '$category'), User_id = (SELECT id FROM User WHERE id_user = $user)";
    mysqli_query($cnx, $sql);
}
?>

<form method="POST">
	<input type="" name="">
	<select>
		<?php
		$sql = 'SELECT * FROM Category';
		$select = mysqli_query($cnx, $sql);
		while($s = mysqli_fetch_assoc($select)){
		?>
		<option><?php echo $s['label'];?></option>
		<?php
		}
		?>
	</select>
	<input type="submit" name="valid">
</form>
<?php
session_start();

if(isset($_SESSION['id_user'])){
	header('Location: index.php');
}
else{
	if(isset($_POST['create'])){
		$msg = '';
		if(empty($_POST['email'])){
			$msg .= '<span class="warning">Veuillez renseigner votre adresse mail.</span><br/>';
		}
		else if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
			$msg .= '<span class="warning">Votre email est considéré comme invalide</span><br/>';
		}
		if(empty($_POST['password'])){
			$msg .= '<span class="warning">Veuillez renseigner un mot de passe.</span><br/>';
		}
		else if(strlen($_POST['password']) < 8){
			$msg .= '<span class="warning">Votre mot de passe doit comporter au moins 8 caractères.</span><br/>';
		}
		if(empty($_POST['pass'])){
			$msg .= '<span class="warning">Veuillez confirmer votre mot de passe</span><br/>';
		}
		if(!empty($_POST['password']) && !empty($_POST['pass'])){
			if($_POST['password'] != $_POST['pass']){
			$msg .= 'Les mots de passes doivent êtres identiques.';
			}
		}
		if(empty($msg)){
		    require_once('./db.php');

			$pass = mysqli_real_escape_string($cnx, sha1($_POST['pass']));
			$password = mysqli_real_escape_string($cnx, sha1($_POST['password']));
		    $email = mysqli_real_escape_string($cnx, $_POST['email']);
	      	if($email&&$pass&&$password){
		        if($pass == $password){
		           	$sql = "INSERT INTO `User` SET email = '$email', password = '$password'";
		            $select = mysqli_query($cnx, $sql);
		       	    include_once('./includes/mail.php');
		            header('Location: ./user.php');
	            }
	        }
		}
	    echo $msg;
	}
	//////
	if(isset($_POST['login'])){
		require_once('./db.php');

		$username = $_POST['username'];
	    $password = sha1($_POST['password']);

	    $sql = "SELECT * FROM User WHERE email = '$username' AND password = '$password'";
        $select = mysqli_query($cnx, $sql);
	    if($username&&$password){
	        if($s = mysqli_fetch_assoc($select)){
	            $email = $s['email'];
	            $pw = $s['password'];
	                if($username==$email&&$password==$pw){
		                    $_SESSION['id_user'] = $s['id'];
		                    $_SESSION['email'] = $s['email'];
		                    $_SESSION['password'] = $password;
	                    	header('Location: ./index.php');
	                }
	        	}
	        }
	    }
		
	//////
}

?>

	    <form class="con_discon" method="POST" id="formb">
	        <input type="text" name="email">
	        <input type="password" name="password">
	        <input type="password" name="pass">
	        <div>
	            <input type="checkbox" name="checkbox" required>
	            <label for="checkbox">J'accepte les <a href="">Conditions Générales d'Utilisations</a></label>
	        </div>
	        <input type="submit" name="create">
	    </form>

	    	    <!-- CONNECTION -->
	    <form class="con_discon" method="POST" id="forma">
	        <input type="text" name="username" placeholder="mail">
	        <input type="password" name="password" placeholder="votre mot de passe...">
	        <input type="submit" name="login">
	    </form>
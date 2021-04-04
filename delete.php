<?php
    session_start();
    require_once 'pdo.php';
    ini_set('display_error',1);
    if(!isset($_GET['profile_id'])){
        $_SESSION['error'] = 'Missing profile_id';
        header('Location:index.php');
        return;
    }
    $stmt = $pdo->prepare("select * from Profile where profile_id = :pi");
    $stmt->execute(array(':pi' => $_GET['profile_id']));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if($row === false){
        $_SESSION['error'] = 'Could not load profile';
        header('Location:index.php');
        return;
    }
    if(isset($_POST['delete'])){
        $stmt = $pdo->prepare('delete from Profile
            where profile_id = :pi');
        $stmt->execute(array(':pi' => $_GET['profile_id']) );
	$stmt = $pdo->prepare('DELETE FROM Position WHERE profile_id=:pid');
	$stmt->execute(array( ':pid' => $_REQUEST['profile_id']));
        $_SESSION['success'] = 'Profile deleted';
        header('Location:index.php');
        return ;
    }else if(isset($_POST['cancel'])){
	header('Location:index.php');
	return ;
    }
?>
<!DOCTYPE html>
<html>
<head>
<title>Moaz Basheer's Profile Add</title>
<!-- bootstrap.php - this is HTML -->

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" 
    href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" 
    integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" 
    crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" 
    href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" 
    integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" 
    crossorigin="anonymous">

</head>
<body>
<div class="container">
<h1>Deleteing Profile</h1>
    <p style="color:red">
        <?php
        if(isset($_SESSION['error'])){
            echo $_SESSION['error'];
            unset($_SESSION['error']);
        }
        ?>
    </p>
    <form method="post">
        <p>First Name:
        <?php echo htmlentities($row['first_name']); ?></p>
        <p>Last Name:
        <?php echo htmlentities($row['last_name']); ?></p>
        <input type="hidden" name="profile_id"
        value="4696"
        />
        <input type="submit" name="delete" value="Delete">
        <input type="submit" name="cancel" value="Cancel">
        </p>
    </form>
</div>
</body>
</html>

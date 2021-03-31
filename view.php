<?php
    session_start();
    require_once 'pdo.php';
    ini_set('display_error',1);
    if(!isset($_GET['profile_id'])){
	$_SESSION['error'] = 'Missing profile_id';
	header('Location:index.php');
	return;
    }
    $stmt = $pdo->prepare('select * from Profile where profile_id = :pi');
    $stmt -> execute(array(':pi' => $_GET['profile_id']));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if($row === false){
	$_SESSION['error'] = 'Could not load profile';
	header('Location:index.php');
	return;
    }
?>
<!DOCTYPE html>
<html>
<head>
<title>Moaz Basheer's Profile View</title>
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
<h1>Profile information</h1>
<p>First Name:
<?php echo htmlentities($row['first_name']);?></p>
<p>Last Name:
<?php echo htmlentities($row['last_name']);?></p>
<p>Email:
<?php echo htmlentities($row['email']);?></p>
<p>Headline:<br/>
<?php echo htmlentities($row['headline']);?></p>
<p>Summary:<br/>
<?php echo htmlentities($row['summary']);?><p>
</p>
<?php
    echo "<p>Position:</p>";
    echo "<ul>";
    $stmt = $pdo->prepare('select * from Position where profile_id = :pid');
    $stmt->execute(array(
	':pid' => $_GET['profile_id'])
    );
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
	echo '<li>' . $row['year'] . ' : ' . $row['description'] . '</li>';
    }
    echo "</ul>";
?>

<a href="index.php">Done</a>
</div>
</body>
</html>

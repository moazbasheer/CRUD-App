<?php
session_start();
require_once 'pdo.php';
ini_set('display_errors',1);
?>
<!DOCTYPE html>
<html>
<head>
<title>Moaz Basheer's Resume Registry</title>
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
<h1>Moaz Basheer's Resume Registry</h1>
<?php
echo '<p style="color:red;">';
if(isset($_SESSION['error'])){
    echo $_SESSION['error'];
    unset($_SESSION['error']);
}
echo '</p>';
echo '<p style="color:green;">';
if(isset($_SESSION['success'])){
    echo $_SESSION['success'];
    unset($_SESSION['success']);
}
echo '</p>';
if(!isset($_SESSION['user_id'])){
    echo'<p><a href="login.php">Please log in</a></p>';
    echo '<table border="1">';
    $stmt = $pdo->prepare("select * from Profile");
    $stmt->execute();
    echo ("<tr><th>Name</th><th>Model</th></tr>");
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        echo '<tr>';
        echo"<td>";
        echo "<a href='view.php?profile_id=";
        echo $row['profile_id']; echo "'>";
        echo htmlentities($row['first_name']).' '
                .htmlentities($row['last_name']);
        echo '</a>';
        echo '</td>';
        echo "<td>".htmlentities($row['headline'])."</td>";
        echo '</tr>';
    }
    echo '</table>';

}else{
    echo'<p><a href="logout.php">Logout</a></p>';

    echo '<table border="1">';
    $stmt = $pdo->prepare("select * from Profile");
    $stmt->execute();
    echo ("<tr><th>Name</th><th>Model</th><th>Action</th></tr>");
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
	echo '<tr>';
	echo"<td>";
	echo "<a href='view.php?profile_id=";
	echo $row['profile_id']; echo "'>";
	echo htmlentities($row['first_name']).' '
		.htmlentities($row['last_name']);
	echo '</a>';
	echo '</td>';
	echo "<td>".htmlentities($row['headline'])."</td>";
	echo '<td>';
	echo "<a href='edit.php?profile_id=" . $row["profile_id"] ."'>Edit</a> ";
        echo "<a href='delete.php?profile_id=" . $row["profile_id"] ."'>Delete</a>";
	echo '</td>';
	echo '</tr>';
    }
    echo '</table>';
    echo'<a href="add.php">Add New Entry</a>';
}
?>
<p>
<b>Note:</b> Your implementation should retain data across multiple
logout/login sessions.  This sample implementation clears all its
data periodically - which you should not do in your implementation.
</p>
</div>
</body>

<?php
    session_start();
    require_once 'pdo.php';
    ini_set('display_errors', 1);
    
    function validatePos() {
    	for($i=1; $i<=9; $i++) {
    	    if ( ! isset($_POST['year'.$i]) ) continue;
    	    if ( ! isset($_POST['desc'.$i]) ) continue;

    	    $year = $_POST['year'.$i];
    	    $desc = $_POST['desc'.$i];

    	    if ( strlen($year) == 0 || strlen($desc) == 0 ) {
       	        return "All fields are required";
    	    }

    	    if ( ! is_numeric($year) ) {
                return "Position year must be numeric";
	    }
        }
	 return true;
    }
    if(!isset($_POST['first_name']) || !isset($_POST['last_name']) ||
	!isset($_POST['email']) || !isset($_POST['headline']) || !isset($_POST['summary']) ){
	;
    }
    else if($_POST['email'] != "" && strpos($_POST['email'],"@") === false){
	$_SESSION['error'] = 'Email address must contain @';
	header('Location:add.php');
	return;
    }else if(is_string(validatePos())){
	$_SESSION['error'] = validatePos();
	header('Location:add.php');
    }else if($_POST['first_name'] != "" && $_POST['last_name'] != "" &&
	$_POST['summary'] != "" && $_POST['email'] != "" && $_POST['headline'] != ""){
	$stmt = $pdo->prepare('insert into Profile(user_id,first_name,last_name,email,
		headline,summary) values(:ui, :fn, :ln, :em, :hdl, :sm)');
    	$stmt->execute(array(
		':ui' => $_SESSION['user_id'],
		':fn' => $_POST['first_name'],
                ':ln'=> $_POST['last_name'],
		':em' => $_POST['email'],
                ':hdl' => $_POST['headline'],
		':sm' => $_POST['summary'])
	);
	$profile_id = $pdo->lastInsertId();
	$rank = 1;
        for($i=1; $i<=9; $i++){
            if ( ! isset($_POST['year'.$i]) ) continue;
            if ( ! isset($_POST['desc'.$i]) ) continue;
	    $year = $_POST['year'.$i];
	    $desc = $_POST['desc'.$i];
	    $stmt = $pdo->prepare('INSERT INTO Position (profile_id, rank_, year, description) VALUES ( :pid, :rank, :year, :desc)');
	    $stmt->execute(array(
		':pid' => $profile_id,
		':rank' => $rank,
		':year' => $year,
		':desc' => $desc)
	    );
	    $rank++;
	}
        $_SESSION['success'] = 'Profile added';
        header('Location:index.php');
        return ;
    }else if(isset($_POST['cancel'])){
        header('Location:index.php');
        return ;
    }else{
	$_SESSION['error'] = 'All fields are required';
        header('Location:add.php');
        return;
    }
?>
<!DOCTYPE html>
<html>
<head>
<title>Moaz Basheer's Profile Add</title>
</head>
<?php require_once 'bootstrap.php'; ?>
<body>
<div class="container">
<h1>Adding Profile for UMSI</h1>
<p style="color:red;">
<?php
    if(isset($_SESSION['error'])){
        echo $_SESSION['error'];
	unset($_SESSION['error']);
    }
?>
</p>
<form method="post">
<p>First Name:
<input type="text" name="first_name" size="60"/></p>
<p>Last Name:
<input type="text" name="last_name" size="60"/></p>
<p>Email:
<input type="text" name="email" size="30"/></p>
<p>Headline:<br/>
<input type="text" name="headline" size="80"/></p>
<p>Summary:<br/>
<textarea name="summary" rows="8" cols="80"></textarea>
<p>
Position: <input type="submit" id="addPos" value="+">
<div id="position_fields">
</div>
</p>
<p>
<input type="submit" value="Add">
<input type="submit" name="cancel" value="Cancel">
</p>
</form>
</div>
<script>
countPos = 0;

// http://stackoverflow.com/questions/17650776/add-remove-html-inside-div-using-javascript
$(document).ready(function(){
    window.console && console.log('Document ready called');
    $('#addPos').click(function(event){
        // http://api.jquery.com/event.preventdefault/
        event.preventDefault();
        if ( countPos >= 9 ) {
            alert("Maximum of nine position entries exceeded");
            return;
        }
        countPos++;
        window.console && console.log("Adding position "+countPos);
        $('#position_fields').append(
            '<div id="position'+countPos+'"> \
            <p>Year: <input type="text" name="year'+countPos+'" value="" /> \
            <input type="button" value="-" \
                onclick="$(\'#position'+countPos+'\').remove();return false;"></p> \
            <textarea name="desc'+countPos+'" rows="8" cols="80"></textarea>\
            </div>');
    });
});
</script>
</body>
</html>

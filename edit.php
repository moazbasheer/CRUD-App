<?php
    session_start();
    require_once 'pdo.php';
    ini_set('display_error',1);
    echo $_POST['desc1'];
    if(isset($_POST['save'])){

        if($_POST['email'] != "" && strpos($_POST['email'],"@") === false){
            $_SESSION['error'] = 'Email address must contain @';
            header('Location:edit.php');
            return;
        }
    else if(!empty($_POST['first_name']) && 
        !empty($_POST['last_name']) &&
        !empty($_POST['summary']) && 
        !empty($_POST['email']) && 
        !empty($_POST['headline'])){
        
        $stmt = $pdo->prepare('update Profile
                set first_name = :fn, last_name = :ln, email = :em,
                        headline= :hdl, summary = :sm
                where profile_id = :pi');
        $stmt->execute(array(
                ':pi' => $_GET['profile_id'],
                ':fn' => $_POST['first_name'],
                ':ln'=>$_POST['last_name'],
                ':em' => $_POST['email'],
                ':hdl' => $_POST['headline'],
                ':sm' => $_POST['summary'])
        );
        $stmt = $pdo->prepare('DELETE FROM Position WHERE profile_id=:pid');
        $stmt->execute(array( ':pid' => $_GET['profile_id']));
        $rank = 1;
        for($i=1; $i<=9; $i++){
            if ( ! isset($_POST['year'.$i]) ) continue;
            if ( ! isset($_POST['desc'.$i]) ) continue;
            $year = $_POST['year'.$i];
            $desc = $_POST['desc'.$i];
            $profile_id = $_GET['profile_id'];
            $stmt = $pdo->prepare('INSERT INTO Position (profile_id, rank_, year, description) VALUES ( :pid, :rank, :year, :desc)');
            $stmt->execute(array(
                ':pid' => $profile_id,
                ':rank' => $rank,
                ':year' => $year,
                ':desc' => $desc)
            );
            $rank++;
        }
        $_SESSION['success'] = 'Profile updated';
        header('Location:index.php');
        return ;
    }else{
        $_SESSION['error'] = 'All fields are required';
        header('Location:edit.php');
        return;
    }

    }else if(isset($_POST['cancel'])){
        header('Location:index.php');
        return ;
    }

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
?>
<!DOCTYPE html>
<html>
<head>
<title>Moaz Basheer's Profile Edit</title>
<?php include_once 'bootstrap.php' ?>
</head>
<body>
    <div class="container">
    <h1>Editing Profile for UMSI</h1>
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
    <input type="text" name="first_name" size="60"
    value="<?php echo htmlentities($row['first_name']); ?>"
    /></p>
    <p>Last Name:
    <input type="text" name="last_name" size="60"
    value="<?php echo htmlentities($row['last_name']); ?>"
    /></p>
    <p>Email:
    <input type="text" name="email" size="30"
    value="<?php echo htmlentities($row['email']); ?>"
    /></p>
    <p>Headline:<br/>
    <input type="text" name="headline" size="80"
    value="<?php echo htmlentities($row['headline']); ?>"
    /></p>
    <p>Summary:<br/>
    <textarea name="summary" rows="8" cols="80">
    <?php echo htmlentities($row['summary']); ?></textarea>
    <p>
    <input type="hidden" name="profile_id"
    value="4696"
    />
    Position: <input type="submit" id="addPos" value="+">
    <div id="position_fields">
    <?php
        $stmt = $pdo->prepare("select * from Position where profile_id = :pi");
        $stmt->execute(array(':pi' => $_GET['profile_id']));
        $cnt = 0;
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        echo "<div id='position" . $row['rank_'] . "'> ";
            echo "<p>Year: <input type='text' name='year" . $row['rank_'] . "' value='". htmlentities($row['year']) . "' />";
            echo "<input type='button' value='-' onclick=\"$('#position" . $row['rank_'] ."').remove();return false;\"></p>";
            echo "<textarea name='desc". $row['rank_'] ."' rows='8' cols='80' >". htmlentities($row['description']) ."</textarea>";
            echo "</div>";
        $cnt = $row['rank_'];
        }
    ?>
    </div>
    </p>
    <p>
    <input type="submit" name="save" value="Save">
    <input type="submit" name="cancel" value="Cancel">
    </p>
    </form>
</div>
<script>
countPos = <?php echo $cnt; ?>;

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
</form>
</div>

</body>
</html>

<?
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";  

$conn = dbconnect($host, $dbid, $dbpass, $dbname);

mysqli_query($conn, "set autocommit = 0");
mysqli_query($conn, "set session transaction isolation level serializable");
mysqli_query($conn, "start transaction");

if (array_key_exists("userID", $_GET)) {
    $userID = $_GET["userID"];
    $query = "select * from user where userID = '$userID'";
    $result = mysqli_query($conn, $query);
    if (!$result) {
    	mysqli_query($conn, "rollback");
    	msg("ERROR! Try Again");
    	echo "<meta http-equiv='refresh' content='0;url=index.php'>";
    }
    $user = mysqli_fetch_assoc($result);
    if (!$user) {
    	mysqli_query($conn, "rollback");
        msg("User with ID $userID do not exist.");
        echo "<script>location.replace('userInfo.php?userID={$user['userID']}&mode=$mode');</script>";
    }
}

$action = "classApplication.php";

?>

<div class="container">
    <form name="userForm" action="<?=$action?>" method="post" class="fullwidth">
    	<input type="hidden" name="userID" value="<?=$user['userID']?>"/>
    	<h3>Class Application</h3>
    	<h2>Usr Info</h2>
        <p>
            <label for="userID">User ID</label>
            <input readonly type="text" id="userID" name="userID" value="<?= $user['userID'] ?>"/>
        </p>

        <h3>Class Info</h3>		
        <div class="container">
        	
        	<p>
            	<label for="Search">Search</label>
            	<input type="text" id="search_keyword" name="search_keyword" placeholder="Search"/>
            	<button class="button primary small" type = "submit" formaction="applicationForm.php?userID=<?=$user['userID']?>&key=<?php $key=$_POST["search_keyword"]; ?>">Class Search</button>
        	</p>
        	
    		<?
    		$query = "select * from class natural join section";
    		if (array_key_exists("search_keyword", $_POST)) {  // array_key_exists() : Checks if the specified key exists in the array
        		$search_keyword = $_POST["search_keyword"];
        		if ("{$search_keyword}" != '')
    				$query .= " where className like '%$search_keyword%' or classTime like '%$search_keyword%' or classTeacher like '%$search_keyword%'";
    		}
    		$result = mysqli_query($conn, $query);
    
			if (!$result) {
    			mysqli_query($conn, "rollback");
    			msg("ERROR! Try Again");
    			echo "<meta http-equiv='refresh' content='0;url=index.php'>";
    		}
    		?>
    	

        <table class="table table-striped table-bordered">
            <tr>
                <th>No.</th>
                <th>Class Name</th>
                <th>Section ID</th>
                <th>Section Day</th>
                <th>Class Time</th>
                <th>Class Room</th>
                <th>Class Teacher</th>
                <th>Max</th>
                <th>Current</th>
                <th>Apply</th>
            </tr>
            <?
            $row_index = 1;
            while ($row = mysqli_fetch_array($result)) {
                echo "<tr>";
                echo "<td>{$row_index}</td>";
                echo "<td>{$row['className']}</td>";
                echo "<td>{$row['sectionID']}</td>";
                echo "<td>{$row['sectionDay']}</td>";
                echo "<td>{$row['classTime']}</td>";
                echo "<td>{$row['classRoom']}</td>";
                echo "<td>{$row['classTeacher']}</td>";
                echo "<td>{$row['classMax']}</td>";
                echo "<td>{$row['sectionCurrent']}</td>";
                echo "<td align = 'center'>
				<button type='submit' class='button primary small' formaction='classApplication.php?userID={$user['userID']}&sectionID={$row['sectionID']}'>Apply</button></td>";
                echo "</tr>";
                $row_index++;
            }
            mysqli_query($conn, "commit");
            ?>
         </div>   
        </table>
    </form>
</div>
<? include("footer.php") ?>

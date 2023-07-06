<?
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";  

$conn = dbconnect($host, $dbid, $dbpass, $dbname);

mysqli_query($conn, "set autocommit = 0");
mysqli_query($conn, "set session transaction isolation level serializable");
mysqli_query($conn, "start transaction");

$mode = $_GET["mode"];

if ($mode == "User") {
	$action = "userSearch.php?mode=User";
}
else if ($mode == "Coupon") {
	$action = "userSearch.php?mode=Coupon";
}
else if ($mode == "Application") {
	$action = "userSearch.php?mode=Application";
}

mysqli_query($conn, "commit");
?>

<div class="container">
    <form name="userForm" action="<?=$action?>" method="post" class="fullwidth">
        <input type="hidden" name="userID" value="<?=$user['userID']?>"/>
        <h3>User Search</h3>
        <p>
            <label for="userID">User ID</label>
            <input type="text" placeholder="Write User ID" id="userID" name="userID" value="<?=$user['userID']?>"/>
        </p>

        <p align="center"><button class="button primary large" onclick="javascript:return validate();">Search</button></p>
        
    </form>
</div>
	
<? include("footer.php") ?>

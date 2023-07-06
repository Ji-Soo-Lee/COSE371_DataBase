<?
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";  

$conn = dbconnect($host, $dbid, $dbpass, $dbname);

mysqli_query($conn, "set autocommit = 0");
mysqli_query($conn, "set session transaction isolation level serializable");
mysqli_query($conn, "start transaction");

$mode = "Register";
$action = "userRegister.php";

mysqli_query($conn, "commit");
?>

<div class="container">
    <form name="userForm" action="<?=$action?>" method="post" class="fullwidth">
        <input type="hidden" name="userID" value="<?=$user['userID']?>"/>
        <h3>User <?=$mode?></h3>
        <p>
            <label for="userID">User ID</label>
            <input type="text" placeholder="Write User ID" id="userID" name="userID" value="<?=$user['userID']?>"/>
        </p>
        
        <p>
            <label for="userName">User Name</label>
            <input type="text" placeholder="Write User Name" id="userName" name="userName" value="<?=$user['userName']?>"/>
        </p>
        
        <p>
            <label for="userPhone">User Phone Number</label>
            <input type="text" placeholder="Write User Phone Number" id="userPhone" name="userPhone" value="<?=$user['userPhone']?>"/>
        </p>

        <p align="center"><button class="button primary large" onclick="javascript:return validate();"><?=$mode?></button></p>

        <script>
            function validate() {
                if(document.getElementById("userID").value == "") {
                    alert ("Need to Write User ID"); return false;
                }
                else if(document.getElementById("userName").value == "") {
                    alert ("Need to Write User Name"); return false;
                }
                return true;
            }
        </script>

    </form>
</div>
	
<? include("footer.php") ?>

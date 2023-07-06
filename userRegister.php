<?
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$conn = dbconnect($host,$dbid,$dbpass,$dbname);

mysqli_query($conn, "set autocommit = 0");
mysqli_query($conn, "set session transaction isolation level serializable");
mysqli_query($conn, "start transaction");

$userID = $_POST['userID'];
$userName = $_POST['userName'];
$userPhone = $_POST['userPhone'];

$result = mysqli_query($conn, "insert into user (userID, userName, userPhone) values('$userID', '$userName', '$userPhone')");
if(!$result)
{
	mysqli_query($conn, "rollback");
    msg("ERROR! Try Again");
    echo "<script>location.replace('registerForm.php');</script>";
}
else
{
	mysqli_query($conn, "commit");
    s_msg ("Success!"."\\n".
    		"User ID: $userID"."\\n".
    		"User Name: $userName"."\\n".
    		"User Phone Number: $userPhone");
    echo "<script>location.replace('registerForm.php');</script>";
}
?>

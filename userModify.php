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

$result = mysqli_query($conn, "update user set userName = '$userName', userPhone = '$userPhone' where userID = '$userID'");

if(!$result)
{
    mysqli_query($conn, "rollback");
	msg("ERROR! Try Again");
    echo "<script>location.replace('userInfo.php?userID={$userID}&mode=User');</script>";
}
else
{
	mysqli_query($conn, "commit");
    s_msg ("Success!");
    echo "<script>location.replace('userInfo.php?userID={$userID}&mode=User');</script>";
}

?>

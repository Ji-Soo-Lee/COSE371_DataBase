<?
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$conn = dbconnect($host,$dbid,$dbpass,$dbname);

mysqli_query($conn, "set autocommit = 0");
mysqli_query($conn, "set session transaction isolation level serializable");
mysqli_query($conn, "start transaction");

$userID = $_POST['userID'];

$result = mysqli_query($conn, "select * from user where userID = '$userID'");
$user = mysqli_fetch_assoc($result);

$mode = $_GET["mode"];

if(!$user) {
	mysqli_query($conn, "rollback");
    s_msg("User with ID $userID do not exist.");
    echo "<script>location.replace('searchForm.php?mode=$mode');</script>";
}
else {
	if ($mode == "Application") {
		echo "<script>location.replace('applicationForm.php?userID={$user['userID']}&key=');</script>";
	}
	else {
    	echo "<script>location.replace('userInfo.php?userID={$user['userID']}&mode=$mode');</script>";
	}
	mysqli_query($conn, "commit");
}
?>

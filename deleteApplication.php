<?
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$conn = dbconnect($host,$dbid,$dbpass,$dbname);

mysqli_query($conn, "set autocommit = 0");
mysqli_query($conn, "set session transaction isolation level serializable");
mysqli_query($conn, "start transaction");

$registerID = $_GET['registerID'];
$sectionID = $_GET['sectionID'];

$ret = mysqli_query($conn, "delete from useCoupon where registerID = $registerID and sectionID = '$sectionID'");

if(!$ret)
{
	mysqli_query($conn, "rollback");
  	msg("ERROR! Try Again");
   	echo "<meta http-equiv='refresh' content='0;url=index.php'>";
}

else
{	
	$query = "update section set sectionCurrent = sectionCurrent - 1 where sectionID = '$sectionID'";
    $result = mysqli_query($conn, $query);
    if (!$result) {
    	mysqli_query($conn, "rollback");
    	msg("NOT MODIFIED");
    }
        				
    $query = "update register set registerCouponNum = registerCouponNum + 1 where registerID = $registerID";
    $result = mysqli_query($conn, $query);
    if (!$result) {
    	mysqli_query($conn, "rollback");
    	msg("NOT MODIFIED");
    }
    	
	s_msg ('Success Deleting');
	$query = "select * from register where registerID = $registerID";
	$result = mysqli_query($conn, $query);
	$user = mysqli_fetch_assoc($result);
	if(!$user) {
		mysqli_query($conn, "rollback");
  		msg("ERROR! Try Again");
		echo "<meta http-equiv='refresh' content='0;url=index.php'>";
	}
	mysqli_query($conn, "commit");

	echo "<script>location.replace('classDetail.php?userID={$user['userID']}');</script>";
}	

?>

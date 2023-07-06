<?
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$conn = dbconnect($host,$dbid,$dbpass,$dbname);

mysqli_query($conn, "set autocommit = 0");
mysqli_query($conn, "set session transaction isolation level serializable");
mysqli_query($conn, "start transaction");

$userID = $_POST['userID'];
$couponID = $_POST['couponID'];
$registerExpiry = $_POST['registerExpiry'];
$registerCouponNum = $_POST['registerCouponNum'];

$result = mysqli_query($conn, "insert into register (userID, couponID, registerExpiry, registerCouponNum) values('$userID', '$couponID', '$registerExpiry', $registerCouponNum)");

if(!$result)
{
    mysqli_query($conn, "rollback");
    msg("ERROR! Try Again");
    echo "<script>location.replace('userInfo.php?userID={$userID}&mode=Coupon');</script>";
}
else
{
	mysqli_query($conn, "commit");
    s_msg ("Success!"."\\n".
    		"User ID: $userID"."\\n".
    		"Coupon ID: $couponID"."\\n".
    		"Coupon Register Expiry: $registerExpiry"."\\n".
    		"Register Couopon Number: $registerCouponNum");
    echo "<script>location.replace('userInfo.php?userID={$userID}&mode=Coupon');</script>";
}
?>

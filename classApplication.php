<?
include "config.php";
include "util.php";
?>

<div class="container">

    <?
    $conn = dbconnect($host, $dbid, $dbpass, $dbname);
    
    mysqli_query($conn, "set autocommit = 0");
	mysqli_query($conn, "set session transaction isolation level serializable");
	mysqli_query($conn, "start transaction");

    $userID = $_POST['userID'];
    $sectionID = $_GET['sectionID'];

    $available_insert = check_id($conn, $userID);
    if ($available_insert){
        $query = "select * from register natural join coupon natural join section natural join class where userID = '$userID' and sectionID = '$sectionID'";
        $register = mysqli_query($conn, $query);
        if (!$register) {
        		mysqli_query($conn, "rollback");
    			msg("No Coupon to Apply");
    		}
    	
        while($row = mysqli_fetch_array($register)) {
        	if ("{$row['sectionCurrent']}" < "{$row['classMax']}" && "{$row['registerCouponNum']}" > 0) {
				$query = "insert into useCoupon values ('{$row['registerID']}', '{$row['sectionID']}')";
        		$result = mysqli_query($conn, $query);
        		if ($result) {
        			$query = "update section set sectionCurrent = sectionCurrent + 1 where sectionID = '$sectionID'";
        			$result = mysqli_query($conn, $query);
        			if (!$result) {
        				mysqli_query($conn, "rollback");
        				msg("NOT MODIFIED");
        			}
        				
        			$query = "update register set registerCouponNum = registerCouponNum - 1 where registerID = '{$row['registerID']}'";
        			$result = mysqli_query($conn, $query);
        			if (!$result) {
        				mysqli_query($conn, "rollback");
        				msg("NOT MODIFIED");
        			}
        				
        			$query = "select * from register natural join coupon natural join section natural join class where registerID = {$row['registerID']} and sectionID = '$sectionID'";
        			$new = mysqli_query($conn, $query);
        			$row = mysqli_fetch_assoc($new);
        			s_msg ("Application Success"."\\n".
    						"User ID: $userID"."\\n".
    						"Register ID: {$row['registerID']}"."\\n".
    						"Coupon ID: {$row['couponID']}"."\\n".
    						"Remaining Coupon Number: {$row['registerCouponNum']}"."\\n".
    						"Section ID: $sectionID"."\\n".
    						"Current Section: {$row['sectionCurrent']}");
    				mysqli_query($conn, "commit");
        			break;
        		}
        	}
        }
        
        $row = mysqli_fetch_assoc($register);
        if (!$new) {
        	mysqli_query($conn, "rollback");
        	msg("Cannot Apply");
        }
        
        echo "<script>location.replace('classDetail.php?userID=$userID');</script>";
    }
    
    else{
    	mysqli_query($conn, "rollback");
        msg("No such User");
    }
    ?>

</div>

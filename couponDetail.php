<?
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";  

$userID = $_POST['userID'];

$conn = dbconnect($host, $dbid, $dbpass, $dbname);

mysqli_query($conn, "set autocommit = 0");
mysqli_query($conn, "set session transaction isolation level serializable");
mysqli_query($conn, "start transaction");

?>

<div class="container">
    <?
    $query = "select * from register natural join coupon where userID = '$userID'";
    $result = mysqli_query($conn, $query);
    if (!$result) {
        mysqli_query($conn, "rollback");
        msg("ERROR! Try Again");
		echo "<meta http-equiv='refresh' content='0;url=index.php'>";
    }
    
    $query = "select * from user where userID = '$userID'";
    $user = mysqli_query($conn, $query);
    if (!$user) {
        mysqli_query($conn, "rollback");
        msg("ERROR! Try Again");
		echo "<meta http-equiv='refresh' content='0;url=index.php'>";
    }
    
    mysqli_query($conn, "commit");
    ?>
    
	<h3>User Registered Coupon Detail</h3>
	<h2>User Info</h2>
    <table class="table table-striped table-bordered">
    	<tr>
        	<th>user ID</th>
            <th>User Name</th>
            <th>User Phone</th>
        </tr>
        <?php
        	$row = mysqli_fetch_assoc($user);
            echo "<tr>";
            echo "<td>{$row['userID']}</td>";
            echo "<td>{$row['userName']}</td>";
           	echo "<td>{$row['userPhone']}</td>";
            echo "</tr>";
       	?>
    </table>
	<h2>Coupon Info</h2>
    <table class="table table-striped table-bordered">
        <tr>
        	<th>No.</th>
            <th>Register ID</th>
            <th>Coupon ID</th>
            <th>Coupon Type</th>
        	<th>Expriy Date</th>
            <th>Number</th>
        </tr>
        	<?php
        		$row_index = 1;
        		while ($row = mysqli_fetch_array($result)) {
        			if ("{$row['registerCouponNum']}" > 0) {
            			echo "<tr>";
            			echo "<td>{$row_index}</td>";
            			echo "<td>{$row['registerID']}</td>";
            			echo "<td>{$row['couponID']}</td>";
          				echo "<td>{$row['classMax']}</td>";
           				echo "<td>{$row['registerExpiry']}</td>";
        				echo "<td>{$row['registerCouponNum']}</td>";
            			echo "</tr>";
            			$row_index++;
        				}
        		}
        	?>
    </table>  
</div>
        				
<? include("footer.php") ?>

<?
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$conn = dbconnect($host, $dbid, $dbpass, $dbname);

mysqli_query($conn, "set autocommit = 0");
mysqli_query($conn, "set session transaction isolation level serializable");
mysqli_query($conn, "start transaction");

if (array_key_exists("userID", $_GET)) {
    $userID = $_GET["userID"];
    $query = "select * from user where userID = '$userID'";
    $result = mysqli_query($conn, $query);
    $user = mysqli_fetch_assoc($result);
    if (!$user) {
    	mysqli_query($conn, "rollback");
        msg("User with ID $userID do not exist.");
        echo "<script>location.replace('userInfo.php?userID={$user['userID']}&mode=$mode');</script>";
    }
}

$mode = $_GET["mode"];

if ($mode == "User") {
	$action = "userModify.php";
}
else if ($mode == "Coupon") {
	$action = "couponRegister.php";
}

?>

<div class="container">
    <form name="userForm" action="<?=$action?>" method="post" class="fullwidth">
    	<?php
    		if ($mode == "Coupon") { ?>
    			<h3>Coupon Register</h3>
    	<?php
    		} else { ?>
    			<h3>User Information Deatil</h3>
    	<?php
            } ?>
    		
        <p>
            <label for="userID">User ID</label>
            <input readonly type="text" id="userID" name="userID" value="<?= $user['userID'] ?>"/>
        </p>
        
        <?php
            if ($mode == "Coupon") { ?>
                <?php
    				$query = "select * from coupon";
					$result = mysqli_query($conn, $query);
					if(!$result) {
						mysqli_query($conn, "rollback");
						msg("ERROR! Try Again");
				 		echo "<meta http-equiv='refresh' content='0;url=index.php'>";
					}

					while($row = mysqli_fetch_array($result)) {
    					$coupon[$row['couponID']] = $row['classMax'];
					}
    			?>
            	<p>
            		<label for="couponID">Coupon ID</label>
            		<select name="couponID" id="couponID">
                    	<option value="-1">선택해 주십시오.</option>
                    	<?
                        	foreach($coupon as $couponID => $classMax) {
                            	if($couponID == $coupon['couponID']){
                                	echo "<option value='{$couponID}' selected>$couponID: $classMax</option>";
                            	} else {
                                	echo "<option value='{$couponID}'>$couponID: $classMax</option>";
                            	}
                        	}
                    	?>
                	</select>
            	</p>
            	
            	<p>
            		<label for="registerExpiry">Coupon Register Expiry Date</label>
            		<input type="date" id="registerExpiry" name="registerExpiry" value="<?= $coupon['registerExpiry'] ?>"/>
        		</p>
        		
        		<p>
            		<label for="registerCouponNum">Register Coupon Number</label>
            		<input type="number" id="registerCouponNum" name="registerCouponNum" value="<?= $coupon['registerCouponNum'] ?>"/>
        		</p>
        		
        		<div class="container">
    				<?php
    					$conn = dbconnect($host, $dbid, $dbpass, $dbname);
    					$query = "select * from register natural join coupon where userID = '$userID'";
    					$result = mysqli_query($conn, $query);
						if(!$result) {
							mysqli_query($conn, "rollback");
							msg("ERROR! Try Again");
				 			echo "<meta http-equiv='refresh' content='0;url=index.php'>";
						}
    				?>

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
        				?>
        <?php
        	mysqli_query($conn, "commit");
            } ?>
        
        <?php
            if ($mode == "User") { 
            	$mode = "Modify"; ?>
            	<p>
            		<label for="userName">User Name</label>
            		<p><input type="text" id="userName" name="userName" value="<?= $user['userName'] ?>"/></p>
            	</p>
            	
            	<p>
            		<label for="userPhone">User Phone Number</label>
            		<p><input type="text" id="userPhone" name="userPhone" value="<?= $user['userPhone'] ?>"/></p>
            	</p>
            	
            	<?php
            		$classURL = "classDetail.php?userID=$userID";
            	?>
            	<p align="center">
        			<button class="button primary large" type = "submit" formaction=<?php echo $classURL ?>>Class Search</button>
        			<button class="button primary large" type = "submit" formaction="couponDetail.php">Coupon Search</button>
        		</p>
        <?php
        	mysqli_query($conn, "commit");
            } ?>
        
        <p align="center"><button class="button primary large" onclick="javascript:return validate();"><?=$mode?></button></p>
        
</div>
<? include "footer.php" ?>

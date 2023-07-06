<?
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$conn = dbconnect($host, $dbid, $dbpass, $dbname);

mysqli_query($conn, "set autocommit = 0");
mysqli_query($conn, "set session transaction isolation level serializable");
mysqli_query($conn, "start transaction");

if (array_key_exists("classID", $_GET)) {
    $classID = $_GET["classID"];
    $query = "select * from class natural join section where classID = '$classID'";
    $result = mysqli_query($conn, $query);
    $class = mysqli_fetch_assoc($result);
    if (!$result) {
    	mysqli_query($conn, "rollback");
    	msg("ERROR! Try Again");
    	echo "<meta http-equiv='refresh' content='0;url=index.php'>";
    }
}

mysqli_query($conn, "commit");

?>
    <div class="container fullwidth">

        <h3>Class Info Detail</h3>

        <p>
            <label for="classID">Class ID</label></label>
            <input readonly type="text" id="classID" name="classID" value="<?= $class['classID'] ?>"/>
        </p>
        
        <p>
            <label for="classID">Class Name</label></label>
            <input readonly type="text" id="className" name="className" value="<?= $class['className'] ?>"/>
        </p>
        
        <p>
            <label for="classTime">Class Time</label></label>
            <input readonly type="text" id="classTime" name="classTime" value="<?= $class['classTime'] ?>"/>
        </p>
        
        <p>
            <label for="sectionDay">Section Day</label></label>
            <input readonly type="text" id="sectionDay" name="sectionDay" value="<?= $class['sectionDay'] ?>"/>
        </p>  


		<p>
            <label for="classRoom">Class Room</label></label>
            <input readonly type="text" id="classRoom" name="classRoom" value="<?= $class['classRoom'] ?>"/>
        </p>
        
        <p>
            <label for="sectionID">Section ID</label></label>
            <input readonly type="text" id="sectionID" name="sectionID" value="<?= $class['sectionID'] ?>"/>
        </p>  
        
        <p>
            <label for="classMax">Class Max</label></label>
            <input readonly type="text" id="classMax" name="classMax" value="<?= $class['classMax'] ?>"/>
        </p>   
        
        <p>
            <label for="sectionCurrent">Section Current</label></label>
            <input readonly type="text" id="sectionCurrent" name="sectionCurrent" value="<?= $class['sectionCurrent'] ?>"/>
        </p>  
        
        <p>
            <label for="classTeacher">Class Teacher</label></label>
            <input readonly type="text" id="classTeacher" name="classTeacher" value="<?= $class['classTeacher'] ?>"/>
        </p>
    </div>
<? include "footer.php" ?>

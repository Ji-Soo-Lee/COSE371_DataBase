<?
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수
?>
<div class="container">
    <?
    $conn = dbconnect($host, $dbid, $dbpass, $dbname);
    
    mysqli_query($conn, "set autocommit = 0");
	mysqli_query($conn, "set session transaction isolation level serializable");
	mysqli_query($conn, "start transaction");

    $query = "select * from section natural join class";
    if (array_key_exists("search_keyword", $_POST)) {  // array_key_exists() : Checks if the specified key exists in the array
        $search_keyword = $_POST["search_keyword"];
        $query .= " where className like '%$search_keyword%' or classTime like '%$search_keyword%' or classTeacher like '%$search_keyword%'";
    }
    $result = mysqli_query($conn, $query);
    if (!$result) {
    	mysqli_query($conn, "rollback");
    	msg("ERROR! Try Again");
    	echo "<meta http-equiv='refresh' content='0;url=index.php'>";
    }
    ?>

    <table class="table table-striped table-bordered">
    	<h3>Class List</h3>
        <tr>
            <th>No.</th>
            <th>Class Name</th>
            <th>Class Time</th>
            <th>Class Room</th>
            <th>Section Day</th>
            <th>Class Max</th>
            <th>Section Current</th>
        </tr>
        <?
        $row_index = 1;
        while ($row = mysqli_fetch_array($result)) {
            echo "<tr>";
            echo "<td>{$row_index}</td>";
            echo "<td><a href='classView.php?classID={$row['classID']}'>{$row['className']}</a></td>";
			echo "<td>{$row['classTime']}</td>";
			echo "<td>{$row['classRoom']}</td>";
			echo "<td>{$row['sectionDay']}</td>";
			echo "<td>{$row['classMax']}</td>";
			echo "<td>{$row['sectionCurrent']}</td>";
            echo "</tr>";
            $row_index++;
            }
        mysqli_query($conn, "commit");
        ?>
    </table>
</div>
<? include("footer.php") ?>

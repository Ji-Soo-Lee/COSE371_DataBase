<!DOCTYPE html>
<html lang='ko'>
<head>
    <title>JS Ballet Academy</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<form action="classList.php" method="post">
    <div class='navbar fixed'>
        <div class='container'>
            <a class='pull-left title' href="index.php">JS Ballet Academy</a>
            <ul class='pull-right'>
                <li>
                    <input type="text" name="search_keyword" placeholder="Search">
                </li>
                <li><a href='registerForm.php'>User Register</a></li>
                <li><a href='searchForm.php?mode=User'>User Information</a></li>
                <li><a href='searchForm.php?mode=Coupon'>Coupon Register</a></li>
                <li><a href='searchForm.php?mode=Application'>Class Application</a></li>
                <li><a href='classList.php'>Class List</a></li>
                <li><a href='JSBalletAcademyDB.php'>DB</a></li>
            </ul>
        </div>
    </div>
</form>

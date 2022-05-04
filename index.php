<?php
if (empty(session_id())) {
    session_start();
}
//$_SESSION['user'] = 'user';

include('db.php');

if (isset($_POST['username']) && isset($_POST['password'])) {
    $sql = "SELECT * FROM `users` WHERE `username` = '" . $_POST['username'] . "'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
    if(!strcmp($_POST['password'], $row['password'])) {
        $_SESSION['user'] = $_POST['username'];
    }
} else if (isset($_SESSION['user']) && isset($_POST['upload'])) {
    $stmt = mysqli_prepare($conn, "INSERT INTO `songs` (`title`, `user`, `album`, `artist`) VALUES (?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "ssss", $title, $user, $album, $artist);
    $title = $_POST['title'];
    $user = $_SESSION['user'];
    $album = $_POST['album'];
    $artist = $_POST['artist'];
    mysqli_stmt_execute($stmt);
    $id = mysqli_insert_id($conn);

    $uploadsDir = 'uploads/';
    $mp3TargetFile = $uploadsDir . $id . '.mp3';
    $coverTargetFile = $uploadsDir . $id . '.png';
    $uploadOk = 1;

    $mp3UploadOk = move_uploaded_file($_FILES["mp3"]["tmp_name"], $mp3TargetFile);
    $coverUploadOk = move_uploaded_file($_FILES["cover"]["tmp_name"], $coverTargetFile);

    if (!$mp3UploadOk) {
        $uploadOk = 0;
        $stmt = mysqli_prepare($conn, "DELETE FROM `songs` WHERE `id` = ?");
        mysqli_stmt_bind_param($stmt, "s", $id);
        mysqli_stmt_execute($stmt);
    } else if (!$coverUploadOk) {
        copy('generic.png', $coverTargetFile);
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>STREEM</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <style>
        table {
            border-collapse: collapse;
            border: 1px solid black;
            text-align: center;
        }
    </style>
</head>

<body>
    <div id="container">
        <div id="header">
            <?php include('header.php'); ?>
        </div>
        <div id="menu">
            <?php include('menu.php'); ?>
            <?php
            if (isset($_POST['upload'])) {
                if ($uploadOk == 1) {
                    echo '<center>Song uploaded successfully!</center>';
                } else {
                    echo '<center>Song failed to upload!</center>';
                }
            }
            ?>
        </div>
        <div id="main">
            <?php
            if (!isset($_SESSION["user"])) {
                include('login.php');
            } else {
                include('playlists.php');
            }
            ?>
        </div>
        <div id="player">
            <?php include('player.php'); ?>
        </div>
    </div>
    <script src="script.js"></script>
</body>

</html>
<?php
if (empty(session_id())) {
    session_start();
}
include('db.php');

if(!isset($_SESSION['user'])) {
    include('login.php');
} else {
?>

<div style="width: 100vw;">
    <center>
        <h1>Upload a track</h1>
        <form action="" method="POST" enctype="multipart/form-data">
            MP3 file: <input type="file" accept=".mp3" name="mp3">
            <br><br>
            Cover image: <input type="file" accept=".png" name="cover">
            <br><br>
            <input type="text" name="title" placeholder="Title">
            <br><br>
            <input type="text" name="artist" placeholder="Artist">
            <br><br>
            <input type="text" name="album" placeholder="Album">
            <br><br>
            <input type="submit" name="upload" value="Upload">
        </form>
    </center>
</div>

<?php
}
?>
<?php
if (empty(session_id())) {
    session_start();
}
include('db.php');

if (!isset($_SESSION['user'])) {
    include('login.php');
} else {
    if (isset($_POST['artist'])) {
        $sql = "SELECT * FROM `songs` WHERE `user` = '" . $_SESSION['user'] . "' AND `artist` = '" . $_POST['artist'] . "'";
    } else if (isset($_POST['album'])) {
        $sql = "SELECT * FROM `songs` WHERE `user` = '" . $_SESSION['user'] . "' AND `album` = '" . $_POST['album'] . "'";
    } else if (isset($_POST['text'])) {
        $sql = "SELECT * FROM `songs` WHERE `user` = '" . $_SESSION['user'] . "' AND (LOWER(`title`) LIKE LOWER('" . $_POST['text'] . "%') OR LOWER(`title`) LIKE LOWER('%" . $_POST['text'] . "%'))";
    } else {
        $sql = "SELECT * FROM `songs` WHERE `user` = '" . $_SESSION['user'] . "'";
    }

    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_array($result)) {

?>

        <div class="card" onclick="playSong('<?php echo $row['id']; if(isset($_POST['album'])) echo '\', \'' . $_POST['album']; ?>')">
            <img class="card-thumbnail" src="<?php echo 'uploads/' . $row['id'] . '.png'; ?>">
            <span class="card-title"><?php echo $row['title']; ?></span>
            <br>
            <span class="card-artist"><?php echo $row['artist']; ?></span>
        </div>

<?php
    }
}
?>

<div style="width: 10000px; height: 1px; color: transparent;"></div>
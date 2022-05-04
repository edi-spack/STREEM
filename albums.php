<?php
if (empty(session_id())) {
    session_start();
}
include('db.php');

if (!isset($_SESSION['user'])) {
    include('login.php');
} else {
    $sql = "SELECT DISTINCT `album` FROM `songs` WHERE `user` = '" . $_SESSION['user'] . "'";
    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_array($result)) {
        $sql2 = "SELECT DISTINCT `id` FROM `songs` WHERE `user` = '" . $_SESSION['user'] . "' AND `album` = '" . $row['album'] . "' LIMIT 1";
        $result2 = mysqli_query($conn, $sql2);
        $row2 = mysqli_fetch_array($result2);
?>

    <div class="card" onclick="showAlbum('<?php echo $row['album']; ?>')">
        <img class="card-thumbnail" src="<?php echo 'uploads/' . $row2['id'] . '.png'; ?>">
        <span class="card-title"><?php echo $row['album']; ?></span>
        <br>
        <span class="card-artist"></span>
    </div>

<?php
    }
}
?>

<div style="width: 10000px; height: 1px; color: transparent;"></div>
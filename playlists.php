<?php
if (empty(session_id())) {
    session_start();
}
include('db.php');

if (!isset($_SESSION['user'])) {
    include('login.php');
} else if(isset($_POST['showPlaylist'])) {
?>

    <div class="card" onclick="newSong('<?php echo $_POST['showPlaylist']; ?>')">
        <img class="card-thumbnail" src="new.png">
        <span class="card-title">Add a new song</span>
        <br>
        <span class="card-artist"></span>
    </div>

<?php
    $sql = "SELECT * FROM `playlists` WHERE `user` = '" . $_SESSION['user'] . "' AND `id` = '" . $_POST['showPlaylist'] . "'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
    $tok = strtok($row['songs'], ",");
    while ($tok !== false) {
        $sql2 = "SELECT * FROM `songs` WHERE `user` = '" . $_SESSION['user'] . "' AND `id` = '" . $tok . "'";
        $result2 = mysqli_query($conn, $sql2);
        $row2 = mysqli_fetch_array($result2);
        $tok = strtok(",");
?>

    <div class="card">
        <div onclick="playSong('<?php echo $row2['id']; ?>')">
            <img class="card-thumbnail" src="<?php echo 'uploads/' . $row2['id'] . '.png'; ?>">
            <span class="card-title"><?php echo $row2['title']; ?></span>
            <br>
            <span class="card-artist"><?php echo $row2['artist']; ?></span>
        </div>
        <span style="float: right;" onclick="removeSong('<?php echo $row2['id']; ?>', '<?php echo $_POST['showPlaylist']; ?>')"><b>Remove</b></span>
    </div>

<?php
    }
} else if(isset($_POST['newPlaylist'])) {
?>

    <div style="width: 100vw;">
        <center>
            <h1>Create a new playlist</h1>
            <input id="new-playlist-name" type="text" placeholder="Name">
            <br><br>
            <input type="submit" value="Create" onclick="addPlaylist(document.getElementById('new-playlist-name').value)">
        </center>
    </div>

<?php
} else if(isset($_POST['addPlaylist'])) {
    $stmt = mysqli_prepare($conn, "INSERT INTO `playlists` (`name`, `user`, `songs`) VALUES (?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "sss", $name, $user, $songs);
    $name = $_POST['addPlaylist'];
    $user = $_SESSION['user'];
    $songs = '';
    mysqli_stmt_execute($stmt);
?>

    <div class="card" onclick="newPlaylist()">
        <img class="card-thumbnail" src="new.png">
        <span class="card-title">Add a new playlist</span>
        <br>
        <span class="card-artist"></span>
    </div>

<?php
    $sql = "SELECT * FROM `playlists` WHERE `user` = '" . $_SESSION['user'] . "'";
    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_array($result)) {
        $tok = strtok($row['songs'], ",");
        if($tok !== false) {
            $tok = 'uploads/' . $tok . '.png';
        } else {
            $tok = 'generic.png';
        }
?>

    <div class="card">
        <div onclick="showPlaylist('<?php echo $row['id']; ?>')">
            <img class="card-thumbnail" src="<?php echo $tok; ?>">
            <span class="card-title"><?php echo $row['name']; ?></span>
            <!--br>
            <span class="card-artist"></span-->
        </div>
        <span style="float: right;" onclick="removePlaylist('<?php echo $row['id']; ?>')"><b>Remove</b></span>
    </div>

<?php
    }
} else if(isset($_POST['removePlaylist'])) {
    $sql = "DELETE FROM `playlists` WHERE `user` = '" . $_SESSION['user'] . "' AND `id` = '" . $_POST['removePlaylist'] . "'";
    mysqli_query($conn, $sql);
    ?>

    <div class="card" onclick="newPlaylist()">
        <img class="card-thumbnail" src="new.png">
        <span class="card-title">Add a new playlist</span>
        <br>
        <span class="card-artist"></span>
    </div>

<?php
    $sql = "SELECT * FROM `playlists` WHERE `user` = '" . $_SESSION['user'] . "'";
    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_array($result)) {
        $tok = strtok($row['songs'], ",");
        if($tok !== false) {
            $tok = 'uploads/' . $tok . '.png';
        } else {
            $tok = 'generic.png';
        }
?>

    <div class="card">
        <div onclick="showPlaylist('<?php echo $row['id']; ?>')">
            <img class="card-thumbnail" src="<?php echo $tok; ?>">
            <span class="card-title"><?php echo $row['name']; ?></span>
            <!--br>
            <span class="card-artist"></span-->
        </div>
        <span style="float: right;" onclick="removePlaylist('<?php echo $row['id']; ?>')"><b>Remove</b></span>
    </div>

<?php
    }
} else if(isset($_POST['newSong'])) {
    $sql = "SELECT * FROM `songs` WHERE `user` = '" . $_SESSION['user'] . "'";
    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_array($result)) {
?>

    <div class="card" onclick="addSong('<?php echo $row['id']; ?>', '<?php echo $_POST['newSong']; ?>')">
        <img class="card-thumbnail" src="<?php echo 'uploads/' . $row['id'] . '.png'; ?>">
        <span class="card-title"><?php echo $row['title']; ?></span>
        <br>
        <span class="card-artist"><?php echo $row['artist']; ?></span>
    </div>

<?php
    }
} else if(isset($_POST['addSong'])) {
    $sql = "SELECT * FROM `playlists` WHERE `user` = '" . $_SESSION['user'] . "' AND `id` = '" . $_POST['playlistId'] . "'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
    $newSongs = $row['songs'] . $_POST['addSong'] . ',';
    $sql2 = "UPDATE `playlists` SET `songs` = '" . $newSongs . "' WHERE `user` = '" . $_SESSION['user'] . "' AND `id` = '" . $_POST['playlistId'] . "'";
    mysqli_query($conn, $sql2);
?>

    <div class="card" onclick="newSong('<?php echo $_POST['playlistId']; ?>')">
        <img class="card-thumbnail" src="new.png">
        <span class="card-title">Add a new song</span>
        <br>
        <span class="card-artist"></span>
    </div>

<?php
    $sql = "SELECT * FROM `playlists` WHERE `user` = '" . $_SESSION['user'] . "' AND `id` = '" . $_POST['playlistId'] . "'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
    $tok = strtok($row['songs'], ",");
    while ($tok !== false) {
        $sql2 = "SELECT * FROM `songs` WHERE `user` = '" . $_SESSION['user'] . "' AND `id` = '" . $tok . "'";
        $result2 = mysqli_query($conn, $sql2);
        $row2 = mysqli_fetch_array($result2);
        $tok = strtok(",");
?>

    <div class="card">
        <div onclick="playSong('<?php echo $row2['id']; ?>')">
            <img class="card-thumbnail" src="<?php echo 'uploads/' . $row2['id'] . '.png'; ?>">
            <span class="card-title"><?php echo $row2['title']; ?></span>
            <br>
            <span class="card-artist"><?php echo $row2['artist']; ?></span>
        </div>
        <span style="float: right;" onclick="removeSong('<?php echo $row2['id']; ?>', '<?php echo $_POST['playlistId']; ?>')"><b>Remove</b></span>
    </div>

<?php
    }
} else if(isset($_POST['removeSong'])) {
    $sql = "SELECT * FROM `playlists` WHERE `user` = '" . $_SESSION['user'] . "' AND `id` = '" . $_POST['playlistId'] . "'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
    $tok = strtok($row['songs'], ",");
    $newSongs = '';
    while ($tok !== false) {
        if(strcmp($tok, $_POST['removeSong']) != 0) {
            $newSongs = $newSongs . $tok . ',';
        }
        $tok = strtok(",");
    }
    $sql2 = "UPDATE `playlists` SET `songs` = '" . $newSongs . "' WHERE `user` = '" . $_SESSION['user'] . "' AND `id` = '" . $_POST['playlistId'] . "'";
    mysqli_query($conn, $sql2);
?>

    <div class="card" onclick="newSong('<?php echo $_POST['playlistId']; ?>')">
        <img class="card-thumbnail" src="new.png">
        <span class="card-title">Add a new song</span>
        <br>
        <span class="card-artist"></span>
    </div>

<?php
    $sql = "SELECT * FROM `playlists` WHERE `user` = '" . $_SESSION['user'] . "' AND `id` = '" . $_POST['playlistId'] . "'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
    $tok = strtok($row['songs'], ",");
    while ($tok !== false) {
        $sql2 = "SELECT * FROM `songs` WHERE `user` = '" . $_SESSION['user'] . "' AND `id` = '" . $tok . "'";
        $result2 = mysqli_query($conn, $sql2);
        $row2 = mysqli_fetch_array($result2);
        $tok = strtok(",");
?>

    <div class="card">
        <div onclick="playSong('<?php echo $row2['id']; ?>')">
            <img class="card-thumbnail" src="<?php echo 'uploads/' . $row2['id'] . '.png'; ?>">
            <span class="card-title"><?php echo $row2['title']; ?></span>
            <br>
            <span class="card-artist"><?php echo $row2['artist']; ?></span>
        </div>
        <span style="float: right;" onclick="removeSong('<?php echo $row2['id']; ?>', '<?php echo $_POST['playlistId']; ?>')"><b>Remove</b></span>
    </div>

<?php
    }
} else {
?>

    <div class="card" onclick="newPlaylist()">
        <img class="card-thumbnail" src="new.png">
        <span class="card-title">Add a new playlist</span>
        <br>
        <span class="card-artist"></span>
    </div>

<?php
    $sql = "SELECT * FROM `playlists` WHERE `user` = '" . $_SESSION['user'] . "'";
    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_array($result)) {
        $tok = strtok($row['songs'], ",");
        if($tok !== false) {
            $tok = 'uploads/' . $tok . '.png';
        } else {
            $tok = 'generic.png';
        }
?>

    <div class="card">
        <div onclick="showPlaylist('<?php echo $row['id']; ?>')">
            <img class="card-thumbnail" src="<?php echo $tok; ?>">
            <span class="card-title"><?php echo $row['name']; ?></span>
            <!--br>
            <span class="card-artist"></span-->
        </div>
        <span style="float: right;" onclick="removePlaylist('<?php echo $row['id']; ?>')"><b>Remove</b></span>
    </div>

<?php
    }
}
?>

<div style="width: 10000px; height: 1px; color: transparent;"></div>
<?php
if (empty(session_id())) {
    session_start();
}
include('db.php');

if (!isset($_SESSION['user']) || !isset($_POST['songId'])) {
?>

    <div id="buttons-container">
        <button id="prev-button" disabled>Prev</button>
        <button id="play-button" disabled>Play</button>
        <button id="next-button" disabled>Next</button>
    </div>
    <div id="seek-container">
        <span id="elapsed-time">0:00</span>
        <input id="seekbar" type="range" value="0" disabled>
        <span id="total-time">0:00</span>
    </div>
    <div></div>

<?php
} else {
    $sql = "SELECT * FROM `songs` WHERE `user` = '" . $_SESSION['user'] . "' AND `id` = '" . $_POST['songId'] . "'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);

    if (isset($_POST['album'])) {
        $sql2 = "SELECT * FROM `songs` WHERE `user` = '" . $_SESSION['user'] . "' AND `album` = '" . $_POST['album'] . "'";
        $result2 = mysqli_query($conn, $sql2);
        $inTheAlbum = false;
        $inTheBeginning = false;
        $inTheEnd = false;
        $index = 0;
        $found = 999999999;
        $prv = null;
        $nxt = null;
        while ($row2 = mysqli_fetch_array($result2)) {
            $nxt = $row2['id'];
            if($index > $found + 1) {
                break;
            }
            if(strcmp($row2['id'], $_POST['songId']) == 0) {
                $inTheAlbum = true;
                $found = $index;
            }
            if(!$inTheAlbum) {
                $prv = $row2['id'];
            }
            $index++;
        }
        if($inTheAlbum) {
            if($found == 0) {
                $inTheBeginning = true;
            } else if($found == mysqli_num_rows($result2) - 1) {
                $inTheEnd = true;
            }
        }
    }
?>

    <div id="buttons-container">
        <button id="prev-button" <?php if(!$inTheAlbum || $inTheBeginning) echo 'disabled'; else echo 'onclick="prevSong(\'' . $prv . '\', \'' . $_POST['album'] . '\')"'; ?>>Prev</button>
        <button id="play-button" onclick="playOrPause()">Play</button>
        <button id="next-button" <?php if(!$inTheAlbum || $inTheEnd) echo 'disabled'; else echo 'onclick="nextSong(\'' . $nxt . '\', \'' . $_POST['album'] . '\')"'; ?>>Next</button>
    </div>
    <div id="seek-container">
        <audio id="audio-tag" src="uploads/<?php echo $row['id']; ?>.mp3" style="display: none;" preload="auto"></audio>
        <span id="elapsed-time">0:00</span>
        <input id="seekbar" type="range" onchange="seekTo(this.value)">
        <span id="total-time">0:00</span>
    </div>
    <div id="track-container">
        <span id="player-title"><?php echo $row['title']; ?></span>
        <br>
        <span id="player-artist"><?php echo $row['artist']; ?></span>
        <img id="player-thumbnail" src="uploads/<?php echo $row['id']; ?>.png">
    </div>

<?php
}
?>
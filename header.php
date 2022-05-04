<?php
if (empty(session_id())) {
    session_start();
}
include('db.php');
?>

            <div id="logo">STREEM</div>
            <div id="search-bar">
                <input id="search-field" type="search" placeholder="Search" <?php if(!isset($_SESSION['user'])) echo "disabled"; ?>>
            </div>

            <?php
            if(!isset($_SESSION['user'])) {
            ?>

            <div><pre>                           </pre></div>
            <div id="account">
                Log in
            </div>

            <?php
            } else {
            ?>

            <div id="upload">
                Upload
            </div>
            <div id="account">
                Log out
            </div>

            <?php
            }
            ?>
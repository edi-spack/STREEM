<?php
if (empty(session_id())) {
    session_start();
}
include('db.php');
?>

<div style="width: 100vw;">
    <center>
        <h1>Log in</h1>
        <form action="" method="POST">
            <input type="text" name="username" placeholder="Username">
            <br><br>
            <input type="password" name="password" placeholder="Password">
            <br><br>
            <input type="submit" value="Log in">
        </form>
    </center>
</div>
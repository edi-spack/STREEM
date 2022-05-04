<?php
if (empty(session_id())) {
    session_start();
}
include('db.php');
?>

            <ul>
                <li id="menu-playlists" style="font-weight: bold;">Playlists</li>
                <li id="menu-artists">Artists</li>
                <li id="menu-albums">Albums</li>
                <li id="menu-songs">Songs</li>
            </ul>
            <!-- CREDIT -->
            <div style="width: 1px; height: calc(60% / 1.2);"></div>
            <center>
                <table>
                    <tr>
                        <td>Credits for music:</td>
                    </tr>
                    <tr>
                        <td>
                            <a href="https://audionautix.com/" target="_blank">Music by Audionautix.com</a>
                        </td>
                    </tr>
                </table>
            </center>
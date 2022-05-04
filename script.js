/* Event listeners */

document.addEventListener('DOMContentLoaded', onLoadCompleted);
window.addEventListener('resize', onResize);
document.getElementById('logo').addEventListener('click', onLogoHeaderClick);
document.getElementById('upload').addEventListener('click', onUploadHeaderClick);
document.getElementById('account').addEventListener('click', onAccountHeaderClick);
document.getElementById('menu-playlists').addEventListener('click', onPlaylistsMenuClick);
document.getElementById('menu-artists').addEventListener('click', onArtistsMenuClick);
document.getElementById('menu-albums').addEventListener('click', onAlbumsMenuClick);
document.getElementById('menu-songs').addEventListener('click', onSongsMenuClick);
document.getElementById('search-field').addEventListener('keyup', onSearch);

/* Event functions */

function onLoadCompleted() {
    onResize();
}

function onResize() {
    document.querySelector(':root').style.setProperty('--mainColNum', Math.ceil(document.getElementById('main').clientWidth / 250));
}

function onLogoHeaderClick() {
    window.location.href = document.location.href;
}

function onUploadHeaderClick() {
    var postParams = {};
    getSection('upload', postParams, function (data) {
        document.getElementById('main').innerHTML = data;
    });
	document.getElementById('menu-playlists').setAttribute("style", "font-weight: normal;");
	document.getElementById('menu-artists').setAttribute("style", "font-weight: normal;");
	document.getElementById('menu-albums').setAttribute("style", "font-weight: normal;");
	document.getElementById('menu-songs').setAttribute("style", "font-weight: normal;");
}

function onAccountHeaderClick() {
    var postParams = {};
    getSection('account', postParams, function (data) {
        document.getElementById('main').innerHTML = data;
        window.location.href = document.location.href;
    });
	document.getElementById('menu-playlists').setAttribute("style", "font-weight: normal;");
	document.getElementById('menu-artists').setAttribute("style", "font-weight: normal;");
	document.getElementById('menu-albums').setAttribute("style", "font-weight: normal;");
	document.getElementById('menu-songs').setAttribute("style", "font-weight: normal;");
}

function onPlaylistsMenuClick() {
    var postParams = {
        /*'key1': 'value1',
        'key2': 'value2'*/
    };
    getSection('playlists', postParams, function (data) {
        document.getElementById('main').innerHTML = data;
    });
	document.getElementById('menu-playlists').setAttribute("style", "font-weight: bold;");
	document.getElementById('menu-artists').setAttribute("style", "font-weight: normal;");
	document.getElementById('menu-albums').setAttribute("style", "font-weight: normal;");
	document.getElementById('menu-songs').setAttribute("style", "font-weight: normal;");
}

function onArtistsMenuClick() {
    var postParams = {};
    getSection('artists', postParams, function (data) {
        document.getElementById('main').innerHTML = data;
    });
	document.getElementById('menu-playlists').setAttribute("style", "font-weight: normal;");
	document.getElementById('menu-artists').setAttribute("style", "font-weight: bold;");
	document.getElementById('menu-albums').setAttribute("style", "font-weight: normal;");
	document.getElementById('menu-songs').setAttribute("style", "font-weight: normal;");
}

function onAlbumsMenuClick() {
    var postParams = {};
    getSection('albums', postParams, function (data) {
        document.getElementById('main').innerHTML = data;
    });
	document.getElementById('menu-playlists').setAttribute("style", "font-weight: normal;");
	document.getElementById('menu-artists').setAttribute("style", "font-weight: normal;");
	document.getElementById('menu-albums').setAttribute("style", "font-weight: bold;");
	document.getElementById('menu-songs').setAttribute("style", "font-weight: normal;");
}

function onSongsMenuClick() {
    var postParams = {};
    getSection('songs', postParams, function (data) {
        document.getElementById('main').innerHTML = data;
    });
	document.getElementById('menu-playlists').setAttribute("style", "font-weight: normal;");
	document.getElementById('menu-artists').setAttribute("style", "font-weight: normal;");
	document.getElementById('menu-albums').setAttribute("style", "font-weight: normal;");
	document.getElementById('menu-songs').setAttribute("style", "font-weight: bold;");
}

function onSearch(e) {
    // if(e.keyCode == 13) {...} // ENTER
    text = document.getElementById('search-field').value;
    var postParams = {
        'text': text
    };
    getSection('songs', postParams, function (data) {
        document.getElementById('main').innerHTML = data;
    });
	document.getElementById('menu-playlists').setAttribute("style", "font-weight: normal;");
	document.getElementById('menu-artists').setAttribute("style", "font-weight: normal;");
	document.getElementById('menu-albums').setAttribute("style", "font-weight: normal;");
	document.getElementById('menu-songs').setAttribute("style", "font-weight: bold;");
}

///////////////////////

function prevSong(songId, album) {
    if(songId != 'null') {
        playSong(songId, album);
        document.getElementById('play-button').innerHTML = 'Pause';
        document.getElementById("audio-tag").play();
    }
}

function playOrPause() {
    if (document.getElementById("audio-tag").paused) {
        document.getElementById('play-button').innerHTML = 'Pause';
        document.getElementById("audio-tag").play();
    } else {
        document.getElementById('play-button').innerHTML = 'Play';
        document.getElementById("audio-tag").pause();
    }
}

function nextSong(songId, album) {
    if(songId != 'null') {
        playSong(songId, album);
        document.getElementById('play-button').innerHTML = 'Pause';
        document.getElementById("audio-tag").play();
    }
}

function seekTo(seconds) {
    var audioTag = document.getElementById('audio-tag');
    audioTag.currentTime = seconds;
    var hours = Math.floor(audioTag.currentTime / 3600);
    var minutes = Math.floor(Math.floor(audioTag.currentTime / 60) % 60);
    var seconds = Math.floor(Math.floor(audioTag.currentTime) % 60);
    if (seconds <= 9) {
        seconds = '0' + seconds;
    }
    if (minutes <= 9) {
        minutes = '0' + minutes;
    }
    if (hours > 0) {
        document.getElementById('elapsed-time').innerHTML = hours + ':' + minutes + ':' + seconds;
    } else {
        document.getElementById('elapsed-time').innerHTML = minutes + ':' + seconds;
    }
}

/* Action functions */

function playSong(songId) {
    var postParams = {
        'songId': songId
    };
    getSection('player', postParams, function (data) {
        document.getElementById('player').innerHTML = data;
        document.getElementById('play-button').innerHTML = 'Pause';
        document.getElementById("audio-tag").onloadedmetadata = function () {
            var audioTag = document.getElementById('audio-tag');
            var hours = Math.floor(audioTag.duration / 3600);
            var minutes = Math.floor(Math.floor(audioTag.duration / 60) % 60);
            var seconds = Math.floor(Math.floor(audioTag.duration) % 60);
            if (seconds <= 9) {
                seconds = '0' + seconds;
            }
            if (minutes <= 9) {
                minutes = '0' + minutes;
            }
            if (hours > 0) {
                document.getElementById('total-time').innerHTML = hours + ':' + minutes + ':' + seconds;
            } else {
                document.getElementById('total-time').innerHTML = minutes + ':' + seconds;
            }
            document.getElementById('seekbar').max = Math.floor(audioTag.duration);
            audioTag.play();
        };
        document.getElementById("audio-tag").ontimeupdate = function () {
            var audioTag = document.getElementById('audio-tag');
            var hours = Math.floor(audioTag.currentTime / 3600);
            var minutes = Math.floor(Math.floor(audioTag.currentTime / 60) % 60);
            var seconds = Math.floor(Math.floor(audioTag.currentTime) % 60);
            if (seconds <= 9) {
                seconds = '0' + seconds;
            }
            if (minutes <= 9) {
                minutes = '0' + minutes;
            }
            if (hours > 0) {
                document.getElementById('elapsed-time').innerHTML = hours + ':' + minutes + ':' + seconds;
            } else {
                document.getElementById('elapsed-time').innerHTML = minutes + ':' + seconds;
            }
            document.getElementById('seekbar').value = Math.floor(audioTag.currentTime);
        };
    });
}

function playSong(songId, album) {
    var postParams = {
        'songId': songId,
        'album': album
    };
    getSection('player', postParams, function (data) {
        document.getElementById('player').innerHTML = data;
        document.getElementById('play-button').innerHTML = 'Pause';
        document.getElementById("audio-tag").onloadedmetadata = function () {
            var audioTag = document.getElementById('audio-tag');
            var hours = Math.floor(audioTag.duration / 3600);
            var minutes = Math.floor(Math.floor(audioTag.duration / 60) % 60);
            var seconds = Math.floor(Math.floor(audioTag.duration) % 60);
            if (seconds <= 9) {
                seconds = '0' + seconds;
            }
            if (minutes <= 9) {
                minutes = '0' + minutes;
            }
            if (hours > 0) {
                document.getElementById('total-time').innerHTML = hours + ':' + minutes + ':' + seconds;
            } else {
                document.getElementById('total-time').innerHTML = minutes + ':' + seconds;
            }
            document.getElementById('seekbar').max = Math.floor(audioTag.duration);
            audioTag.play();
        };
        document.getElementById("audio-tag").ontimeupdate = function () {
            var audioTag = document.getElementById('audio-tag');
            var hours = Math.floor(audioTag.currentTime / 3600);
            var minutes = Math.floor(Math.floor(audioTag.currentTime / 60) % 60);
            var seconds = Math.floor(Math.floor(audioTag.currentTime) % 60);
            if (seconds <= 9) {
                seconds = '0' + seconds;
            }
            if (minutes <= 9) {
                minutes = '0' + minutes;
            }
            if (hours > 0) {
                document.getElementById('elapsed-time').innerHTML = hours + ':' + minutes + ':' + seconds;
            } else {
                document.getElementById('elapsed-time').innerHTML = minutes + ':' + seconds;
            }
            document.getElementById('seekbar').value = Math.floor(audioTag.currentTime);
        };
    });
}

function showArtist(artist) {
    var postParams = {
        'artist': artist
    };
    getSection('songs', postParams, function (data) {
        document.getElementById('main').innerHTML = data;
    });
	document.getElementById('menu-playlists').setAttribute("style", "font-weight: normal;");
	document.getElementById('menu-artists').setAttribute("style", "font-weight: bold;");
	document.getElementById('menu-albums').setAttribute("style", "font-weight: normal;");
	document.getElementById('menu-songs').setAttribute("style", "font-weight: normal;");
}

function showAlbum(album) {
    var postParams = {
        'album': album
    };
    getSection('songs', postParams, function (data) {
        document.getElementById('main').innerHTML = data;
    });
	document.getElementById('menu-playlists').setAttribute("style", "font-weight: normal;");
	document.getElementById('menu-artists').setAttribute("style", "font-weight: normal;");
	document.getElementById('menu-albums').setAttribute("style", "font-weight: bold;");
	document.getElementById('menu-songs').setAttribute("style", "font-weight: normal;");
}

////

function newPlaylist() {
    var postParams = {
        'newPlaylist': 'yes'
    };
    getSection('playlists', postParams, function (data) {
        document.getElementById('main').innerHTML = data;
    });
	document.getElementById('menu-playlists').setAttribute("style", "font-weight: bold;");
	document.getElementById('menu-artists').setAttribute("style", "font-weight: normal;");
	document.getElementById('menu-albums').setAttribute("style", "font-weight: normal;");
	document.getElementById('menu-songs').setAttribute("style", "font-weight: normal;");
}

function addPlaylist(name) {
    var postParams = {
        'addPlaylist': name
    };
    getSection('playlists', postParams, function (data) {
        document.getElementById('main').innerHTML = data;
    });
	document.getElementById('menu-playlists').setAttribute("style", "font-weight: bold;");
	document.getElementById('menu-artists').setAttribute("style", "font-weight: normal;");
	document.getElementById('menu-albums').setAttribute("style", "font-weight: normal;");
	document.getElementById('menu-songs').setAttribute("style", "font-weight: normal;");
}

function showPlaylist(playlistId) {
    var postParams = {
        'showPlaylist': playlistId
    };
    getSection('playlists', postParams, function (data) {
        document.getElementById('main').innerHTML = data;
    });
	document.getElementById('menu-playlists').setAttribute("style", "font-weight: bold;");
	document.getElementById('menu-artists').setAttribute("style", "font-weight: normal;");
	document.getElementById('menu-albums').setAttribute("style", "font-weight: normal;");
	document.getElementById('menu-songs').setAttribute("style", "font-weight: normal;");
}

function removePlaylist(playlistId) {
    var postParams = {
        'removePlaylist': playlistId
    };
    getSection('playlists', postParams, function (data) {
        document.getElementById('main').innerHTML = data;
    });
	document.getElementById('menu-playlists').setAttribute("style", "font-weight: bold;");
	document.getElementById('menu-artists').setAttribute("style", "font-weight: normal;");
	document.getElementById('menu-albums').setAttribute("style", "font-weight: normal;");
	document.getElementById('menu-songs').setAttribute("style", "font-weight: normal;");
}

function newSong(playlistId) {
    var postParams = {
        'newSong': playlistId
    };
    getSection('playlists', postParams, function (data) {
        document.getElementById('main').innerHTML = data;
    });
	document.getElementById('menu-playlists').setAttribute("style", "font-weight: bold;");
	document.getElementById('menu-artists').setAttribute("style", "font-weight: normal;");
	document.getElementById('menu-albums').setAttribute("style", "font-weight: normal;");
	document.getElementById('menu-songs').setAttribute("style", "font-weight: normal;");
}

function addSong(songId, playlistId) {
    var postParams = {
        'addSong': songId,
        'playlistId': playlistId
    };
    getSection('playlists', postParams, function (data) {
        document.getElementById('main').innerHTML = data;
    });
	document.getElementById('menu-playlists').setAttribute("style", "font-weight: bold;");
	document.getElementById('menu-artists').setAttribute("style", "font-weight: normal;");
	document.getElementById('menu-albums').setAttribute("style", "font-weight: normal;");
	document.getElementById('menu-songs').setAttribute("style", "font-weight: normal;");
}

function removeSong(songId, playlistId) {
    var postParams = {
        'removeSong': songId,
        'playlistId': playlistId
    };
    getSection('playlists', postParams, function (data) {
        document.getElementById('main').innerHTML = data;
    });
	document.getElementById('menu-playlists').setAttribute("style", "font-weight: bold;");
	document.getElementById('menu-artists').setAttribute("style", "font-weight: normal;");
	document.getElementById('menu-albums').setAttribute("style", "font-weight: normal;");
	document.getElementById('menu-songs').setAttribute("style", "font-weight: normal;");
}

/* AJAX */

function getSection(section, postParams, callback) {
    fetch(section + ".php", {
        method: 'POST',
        body: new URLSearchParams(postParams),
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        }
    }).then(response => {
        return response.text();
    }).then(data => {
        callback(data);
    });/*.catch((error) => {
        console.log(error)
    });*/
}
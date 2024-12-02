<?php
function playlistCover($array)
{
    $arrayDiff = array_values(array_diff($array, array('default.png')));
    $image = count($arrayDiff) > 0 ? URL::to('/uploads/tracks/' . $arrayDiff[0]) : URL::to('/uploads/playlists/default.png');
    return $image;
}
function trackCover($art, $album = null, $artist = null)
{
    if ($art != 'default.png') {
        return URL::to('/uploads/tracks/' . $art);
    } elseif ($album) {
        return URL::to('/uploads/covers/albums/' . $album);
    } elseif ($artist) {
        return URL::to('/uploads/avatars/' . $artist);
    } else {
        return URL::to('/uploads/tracks/' . $art);
    }
}
function deleteImages($image, $type)
{
    // Type 0: Delete covers
    // Type 1: Delete avatars
    // Type 2: Delete album art

    if ($type == 1) {
        $path = 'avatars';
    } elseif ($type == 2) {
        $path = 'media';
    } else {
        $path = 'covers';
    }

    foreach ($image as $name) {
        if ($name !== 'default.png') {
            if (file_exists(public_path('uploads/' . $path . '/' . $name))) {
                unlink(public_path('uploads/' . $path . '/' . $name));
            }
        }
    }
}
?>

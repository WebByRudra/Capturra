<?php
require 'config/database.php';
$id = 17;
$res = mysqli_query($conn, 'SELECT photo_path FROM photos WHERE id=' . intval($id));
if ($res && $row = mysqli_fetch_assoc($res)) {
    echo $row['photo_path'];
} else {
    echo 'NOT FOUND';
}

<?php
$file = 'config.txt'; 
if (file_exists($file)) {
    $frequency = file_get_contents($file);
    echo $frequency;
} else {
    echo "File không tồn tại.";
}
?>

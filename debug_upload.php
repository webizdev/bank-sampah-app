<?php
$dir = 'uploads/articles';
if (!is_dir($dir)) {
    if (mkdir($dir, 0777, true)) {
        echo "Successfully created $dir<br>";
    } else {
        echo "Failed to create $dir<br>";
    }
} else {
    echo "$dir already exists<br>";
}

$test_file = $dir . '/test.txt';
if (file_put_contents($test_file, 'test')) {
    echo "Successfully wrote to $test_file<br>";
    unlink($test_file);
} else {
    echo "Failed to write to $test_file<br>";
}

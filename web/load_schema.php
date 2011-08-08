<?php
$env = json_decode(file_get_contents('/home/dotcloud/environment.json'), true);
$host = $env['DOTCLOUD_MYSQL_MYSQL_HOST'];
$port = $env['DOTCLOUD_MYSQL_MYSQL_PORT'];
$password = $env['DOTCLOUD_MYSQL_MYSQL_PASSWORD'];
$link = mysql_connect($host . ':' . $port, 'root', $password);
mysql_query('CREATE DATABASE siwapp');
mysql_select_db('siwapp');
$schema_path = '/home/dotcloud/code/data/sql/schema.sql';
$sql = explode(';', file_get_contents($schema_path), -1);
$name = 'admin';
$salt = md5(rand(100000, 999999) . $name);
$pass = sha1($salt . 'admin');
$guard_user_sql = "INSERT INTO sf_guard_user (id, username,algorithm,salt,password,is_active,is_super_admin,created_at,updated_at) VALUES (1, '$name', 'sha1', '$salt', '$pass', 1, 1,now(),now())";
$sql[] = $guard_user_sql;
foreach ($sql as $query) { mysql_query($query, $link); }
?>
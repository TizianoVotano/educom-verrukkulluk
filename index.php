<?php

require_once("lib/database.php");
require_once("lib/artikel.php");
require_once("lib/user.php");

/// INIT
$db = new database();
$art = new artikel($db->getConnection());
$user = new user($db->getConnection());


/// VERWERK 
$data = $art->selecteerArtikel(8);
$dataUsers = $user->selecteerUser(2);

/// RETURN
var_dump($data);
var_dump($dataUsers);
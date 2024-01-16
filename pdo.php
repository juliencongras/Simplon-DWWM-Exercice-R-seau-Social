<?php

$user = 'machin';
$pass = 'mdp123';
$host = '127.0.0.1';
$db   = 'evalRS';

$pdo = new PDO("mysql:host=$host;dbname=$db;", $user, $pass);
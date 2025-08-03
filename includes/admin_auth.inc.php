<?php

require_once "config_session.inc.php";
require_once "dbh.inc.php";

if (!isset($_SESSION['user_id']) || !isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== True) {
    header("Location: ../Login.php");
    exit();
}
<?php
session_start();
$_SESSION['user_id'] = 1;
$_SESSION['user_role'] = 'ADMIN';

require_once 'includes/db_connect.php';
require_once 'api/manage_admin.php';

// Simulate manage_admin.php logic for handleArticles
$_GET['entity'] = 'articles';
$method = 'GET';
$action = '';
$data = [];

header('Content-Type: application/json');
handleArticles($pdo, $method, $action, $data);

<?php
// Include AuthController
require_once '../app/Controllers/AuthController.php';

$authController = new AuthController();
$authController->logout();
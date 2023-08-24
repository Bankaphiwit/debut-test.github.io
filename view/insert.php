<?php
require_once('../load.php');

use Model\Employee;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_POST["submitAddEmployee"])) {
    $employee = new Employee();
    $employee->addEmployee($_POST['no'], $_POST['name'], $_POST['position']);
  }
}

header("location: /");
die();

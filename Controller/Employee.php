<?php

namespace Controller;

use Model\Employee as EmployeeModel;

class Employee
{
  private $employee;
  public function __construct()
  {
    $this->employee = new EmployeeModel();
  }

  public function getAllEmployee()
  {
    return $this->employee->getAllEmployee();
  }

  public function getFirstEmployee($allEmployee = null)
  {
    if ($allEmployee  === null) {
      $allEmployee = $this->employee->getAllEmployee();
    }
    if ($allEmployee && !empty($allEmployee)) {
      return $allEmployee[0];
    }
    return array();
  }

  public function getAllPosition($allEmployee = null)
  {
    if ($allEmployee  === null) {
      $allEmployee = $this->employee->getAllEmployee();
    }
    if ($allEmployee && !empty($allEmployee)) {
      $position = array();
      foreach ($allEmployee as $item) {
        array_push($position, $item['position']);
      }
      return array_unique($position);
    }
    return array();
  }

  public function getEmployeeByQuery($query, $params = array())
  {
    return $this->employee->getEmployeeByQuery($query, $params);
  }
}

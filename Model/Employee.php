<?php

namespace Model;

use Classes\DB;

class Employee
{
  const TABLE = 'employee';
  private $db;

  public function __construct()
  {
    $this->db = new DB();
    $this->createTable();
  }

  private function createTable()
  {
    if ($this->db->tableExists(self::TABLE) === true) return;
    $sql = "CREATE TABLE `" . self::TABLE . "` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `no` varchar(16) NOT NULL,
      `name` varchar(254) NOT NULL,
      `start_date` timestamp NOT NULL,
      `salary` decimal(10, 2) NOT NULL,
      `position` varchar(255) NOT NULL,
      `dep_no` varchar(16) NOT NULL,
      `head_no` varchar(16) NOT NULL,
      PRIMARY KEY (`id`) USING BTREE,
      KEY `no`(`no`),
      KEY `dep_no`(`dep_no`),
      KEY `head_no`(`head_no`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
    $this->db->createTable($sql);
    $this->initData();
  }

  private function initData()
  {
    $sql = "INSERT INTO `" . self::TABLE . "` (`no`, `name`, `start_date`, `salary`, `position`, `dep_no`, `head_no`) VALUES
    ('0001', 'Kanjana', '1994-07-10 00:00:00', '50000.00', 'Managing Director', '0', ''),
    ('1001', 'Surasit', '1994-03-15 00:00:00', '30000.00', 'Manager', '10', '0001'),
    ('1002', 'Jintana', '1993-10-31 00:00:00', '20000.00', 'Supervisor', '10', '1001'),
    ('1003', 'Siriwan', '1993-06-13 00:00:00', '9000.00', 'Clerk', '10', '1001'),
    ('2001', 'Ternjai', '1994-11-01 00:00:00', '24000.00', 'Manager', '20', '0001'),
    ('2002', 'Chai', '1993-05-14 00:00:00', '14000.00', 'Clerk', '20', '2001'),
    ('3001', 'Benjawan', '1994-06-11 00:00:00', '29000.00', 'Manager', '30', '0001'),
    ('3002', 'Tanachote', '1994-06-14 00:00:00', '25000.00', 'Supervisor', '30', '3001'),
    ('3003', 'Arlee', '1993-08-15 00:00:00', '17000.00', 'Salesman', '30', '3001'),
    ('3004', 'Mitree', '1993-12-05 00:00:00', '13000.00', 'Salesman', '30', '3001'),
    ('3005', 'Tawatchai', '1994-07-03 00:00:00', '10000.00', 'Salesman', '30', '3001'),
    ('4001', 'Wichai', '1993-12-26 00:00:00', '33000.00', 'Manager', '40', '0001'),
    ('4002', 'Thidarat', '1994-12-01 00:00:00', '9000.00', 'Clerk', '40', '4001');";
    $this->db->insert($sql);
  }

  public function getAllEmployee()
  {
    $sql = "SELECT e.*, d.`name` AS department, d.`location`
      FROM `" . self::TABLE . "` AS e
        LEFT JOIN `department` AS d
          ON e.dep_no = d.no";
    return $this->db->fetchAll($sql);
  }

  public function addEmployee($no, $name, $position)
  {
    $sql = "INSERT INTO `" . self::TABLE . "`
    (`no`, `name`, `position`) VALUES
    (?, ?, ?)
    ";
    return $this->db->insert($sql, array($no, $name, $position));
  }

  public function getEmployeeByQuery($query, $params = array())
  {
    return $this->db->fetchAll($query, $params);
  }
};

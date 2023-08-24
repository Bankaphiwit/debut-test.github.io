<?php

namespace Model;

use Classes\DB;

class Department
{
  const TABLE = 'department';
  private $db;

  public function __construct()
  {
    $this->db = new DB();
    $this->createTable();
  }

  private function createTable()
  {
    if ($this->db->tableExists(self::TABLE) === true) return;
    $sql = "CREATE TABLE `self::TABLE` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `no` varchar(16) NOT NULL,
        `name` varchar(254) NOT NULL,
        `location` varchar(254) NOT NULL
        PRIMARY KEY (`id`) USING BTREE,
        KEY `no`(`no`),
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
    $this->db->createTable($sql);
    $this->initData();
  }

  private function initData()
  {
    $sql = "INSERT INTO `department` (`no`, `name`, `location`) VALUES
    ('0', 'Executive', 'Silom'),
    ('10', 'Accounting', 'Silom'),
    ('20', 'Administration', 'Sukhumvit'),
    ('30', 'Sales', 'Ratchada'),
    ('40', 'Marketing', 'Silom'),
    ('50', 'Research', 'Sukhumvit');";
    $this->db->insert($sql);
  }
};

<?php

namespace Classes;

class DB
{
  private $host;
  private $username;
  private $password;
  private $database;
  private $connection;
  private $connected = false;
  private $errors = true;

  function __construct()
  {
    try {
      $this->host = DB_HOST;
      $this->username = DB_USER;
      $this->password = DB_PASS;
      $this->database = DB_NAME;
      $this->connected = true;

      $this->connection = new \PDO("mysql:host=" . $this->host . ";dbname=" . $this->database, $this->username, $this->password);
      $this->connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
      $this->connection->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);
      $this->connection->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
    } catch (\PDOException $e) {
      $this->connected = false;
      if ($this->errors === true) {
        return $this->error($e->getMessage());
      } else {
        return false;
      }
    }
  }

  function __destruct()
  {
    $this->connected = false;
    $this->connection = null;
  }

  public function error($error)
  {
    echo $error;
  }

  public function query($query, $parameters = array())
  {
    if ($this->connected === true) {
      try {
        $query = $this->connection->prepare($query);
        $query->execute($parameters);
      } catch (\PDOException $e) {
        if ($this->errors === true) {
          return $this->error($e->getMessage());
        } else {
          return false;
        }
      }
    } else {
      return false;
    }
  }

  public function fetch($query, $parameters = array())
  {
    if ($this->connected === true) {
      try {
        $query = $this->connection->prepare($query);
        $query->execute($parameters);
        return $query->fetch();
      } catch (\PDOException $e) {
        if ($this->errors === true) {
          return $this->error($e->getMessage());
        } else {
          return false;
        }
      }
    } else {
      return false;
    }
  }

  public function fetchAll($query, $parameters = array())
  {
    if ($this->connected === true) {
      try {
        $query = $this->connection->prepare($query);
        $query->execute($parameters);
        return $query->fetchAll();
      } catch (\PDOException $e) {
        if ($this->errors === true) {
          return $this->error($e->getMessage());
        } else {
          return false;
        }
      }
    } else {
      return false;
    }
  }

  public function count($query, $parameters = array())
  {
    if ($this->connected === true) {
      try {
        $query = $this->connection->prepare($query);
        $query->execute($parameters);
        return $query->rowCount();
      } catch (\PDOException $e) {
        if ($this->errors === true) {
          return $this->error($e->getMessage());
        } else {
          return false;
        }
      }
    } else {
      return false;
    }
  }

  public function createTable($query, $parameters = array())
  {
    if ($this->connected === true) {
      return $this->query($query, $parameters);
    } else {
      return false;
    }
  }

  public function insert($query, $parameters = array())
  {
    if ($this->connected === true) {
      return $this->query($query, $parameters);
    } else {
      return false;
    }
  }

  public function update($query, $parameters = array())
  {
    if ($this->connected === true) {
      return $this->query($query, $parameters);
    } else {
      return false;
    }
  }

  public function delete($query, $parameters = array())
  {
    if ($this->connected === true) {
      return $this->query($query, $parameters);
    } else {
      return false;
    }
  }

  public function tableExists($table)
  {
    if ($this->connected === true) {
      try {
        $query = $this->count("SHOW TABLES LIKE '$table'");
        return ($query > 0) ? true : false;
      } catch (\PDOException $e) {
        if ($this->errors === true) {
          return $this->error($e->getMessage());
        } else {
          return false;
        }
      }
    } else {
      return false;
    }
  }
}

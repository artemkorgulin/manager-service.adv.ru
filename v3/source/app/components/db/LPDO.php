<?php
namespace Synergy\lander\app\components\db;
use Synergy\lander\app\BaseComponent;

class LPDO extends BaseComponent
{
    public $dsn;
    public $user;
    public $password;

    private $_pdo;

    private $_stmt;

    public function init()
    {
        $this->_pdo = new \PDO($this->dsn, $this->user, $this->password);
        $this->_pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    public function prepare($sql)
    {
        $this->_stmt = $this->_pdo->prepare($sql);
        return $this;
    }

    public function execute($argv = null)
    {
        $this->_stmt->execute($argv);
        return $this;
    }

    public function fetch($mode = \PDO::FETCH_ASSOC)
    {
        return $this->_stmt->fetch($mode);
    }

    public function fetchAll($mode = \PDO::FETCH_ASSOC)
    {
        return $this->_stmt->fetchAll($mode);
    }
}
<?php

namespace Examples;

require 'common.php';

use MongoDB\Exception as MongoDBException;
use MongoFriend\MongoFriend;

class Database
{

    /**
     * DB hostname
     * @var string $db_host
     */
    protected $db_host;
    /**
     * added by h for new conn
     */
    protected $db_type;
    protected $db_port;
    /**
     * DB name
     * @var string $db_name
     */
    protected $db_name;

    /**
     * DB user password
     * @var string $db_pass
     */
    protected $db_pass;

    /**
     * DB username
     * @var string $db_user
     */
    protected $db_user;

    /**
     * PDOStatement of last query
     * @var \PDOStatement $last
     */
    protected $last;

    /**
     * Mysql db connection identifer
     * @var \PDO $pdo
     * @see pdo()
     */
    protected $mongo;

    /**
     * Connect status
     * @var boolean
     * @see connect()
     */
    protected $status = false;

    /**
     * Constructor
     *
     * @param string $host
     * @param string $user
     * @param string $pass
     * @param string $db
     */
    public function __construct($type = null, $port = null, $host = null, $user = null, $pass = null, $db = null)
    {
        if ($host != null && $user != null && $pass != null && $db != null && $type != null && $port != null) {
            $this->db_host = $host;
            $this->db_name = $db;
            $this->db_user = $user;
            $this->db_pass = $pass;
            $this->db_type = $type;
            $this->db_port = $port;
            $this->connect();
        } elseif (defined('PSM_DB_HOST') && defined('PSM_DB_USER') && defined('PSM_DB_PASS') && defined('PSM_DB_NAME')) {
            $this->db_host = PSM_DB_HOST;
            $this->db_name = PSM_DB_NAME;
            $this->db_user = PSM_DB_USER;
            $this->db_pass = PSM_DB_PASS;
            $this->db_type = 'mongo';
            $this->db_port = '27017';
            $this->connect();
        }
    }

    public function query($query, $fetch = true)
    {
        // Execute query and process results
        try {
            $this->last = $this->pdo()->query($query);
        } catch (\MongoDBException $e) {
            $this->error($e);
        }

        //result
        if ($fetch && $this->last != false) {
            $cmd = strtolower(substr($query, 0, 6));

            switch ($cmd) {
                case 'insert':
                    // insert query, return insert id
                    $result = $this->getLastInsertedId();
                    break;
                case 'update':
                case 'delete':
                    // update/delete, returns rowCount
                    $result = $this->getNumRows();
                    break;
                default:
                    $result = $this->last->fetchAll(\PDO::FETCH_ASSOC);

                    $result = [];

                    $options = ['sort' => ['age' => -1], 'limit' => 2];
                    $users = $mongo->table("users");
                    $rows = $users->find($filter, $options);
                    foreach ($rows as $row) {
                        $result[] = $row;
                    }

                    break;
            }
        } else {
            $result = $this->last;
        }
        //$this->disconnect();
        return $result;
    }

    public function select($table, $where = null, $fields = null, $limit = '', $orderby = null, $direction = 'ASC')
    {
        // build query
        $query_parts = array();
        $query_parts[] = 'SELECT ';

        // Fields
        if ($fields !== null && !empty($fields)) {
            $query_parts[] = "`" . implode('`,`', $fields) . "`";
        } else {
            $query_parts[] = ' * ';
        }

        // From
        $query_parts[] = "FROM `{$table}`";

        // Where clause
        $query_parts[] = $this->buildSQLClauseWhere($table, $where);

        // Order by
        if ($orderby) {
            $query_parts[] = $this->buildSQLClauseOrderBy($orderby, $direction);
        }

        // Limit
        if ($limit != '') {
            $query_parts[] = 'LIMIT ' . $limit;
        }

        $query = implode(' ', $query_parts);

        return $this->query($query);
    }

    public function selectRow($table, $where = null, $fields = null, $orderby = null, $direction = 'ASC')
    {
        $collection = $this->mongo->table($table);

        //where clause
        $where = ["age" => "27"];
        //$where = ["firstname" => ['$regex' => 'm']];

        //fields to show
        if ($fields) {
            $fields_built = [];
            foreach ($fields as $field) {
                $fields_built[$field] = 1;
            }
            $options['projection'] = $fields_built;
        }

        //order by
        if ($orderby) {
            $orderby_built = [];
            $dirs = ['ASC' => 1, 'DESC' => -1];
            $dir = $dirs[strtoupper($direction)];
            foreach ($orderby as $field) {
                $orderby_built[$field] = $dir;
            }

            $options['sort'] = $orderby_built;
        }

        //limit, offset
        $options['limit'] = 1;

        //result
        $rows = $collection->find($where, $options);
        foreach ($rows as $row) {
            return $row;
        }

        return 0;
    }

    public function delete($table, $where = null)
    {
        $users = $mongo->table("users");
        $filter = ["age" => "30"];
        $rows = $users->delete($filter);

        return $this->exec($sql);

        
        $result = $this->getNumRows();
    }

    //update
    public function save($table, array $data, $where = null)
    {
        $users = $mongo->table("users");
        $filters = [];
        $changes = ["age" => 85]; // age is integer
        $users->update($filters, $changes);

        
        $result = $this->getNumRows();
    }

    public function insertMultiple($table, array $data)
    {
        $users = $mongo->table("users");

        $user = generateFakeUser();
        var_dump($user);
        $userId = $users->add($user);
        var_dump($userId);

        if (empty($data)) {
            return false;
        }

        // prepare first part
        $query = "INSERT INTO `{$table}` ";
        $fields = array_keys($data[0]);
        $query .= "(`" . implode('`,`', $fields) . "`) VALUES ";

        // prepare all rows to be inserted with placeholders for vars (\?)
        $q_part = array_fill(0, count($fields), '?');
        $q_part = "(" . implode(',', $q_part) . ")";

        $q_part = array_fill(0, count($data), $q_part);
        $query .= implode(',', $q_part);

        $pst = $this->pdo()->prepare($query);

        $i = 1;
        foreach ($data as $row) {
            // make sure the fields of this row are identical to first row
            $diff_keys = array_diff_key($fields, array_keys($row));

            if (!empty($diff_keys)) {
                continue;
            }
            foreach ($fields as $field) {
                $pst->bindParam($i++, $row[$field]);
            }
        }

        try {
            $this->last = $pst->execute();
        } catch (\MongoDBException $e) {
            $this->error($e);
        }
        return $this->last;
    }

    /**
     * Check if a certain table exists.
     * @param string $table
     * @return boolean
     */
    public function ifTableExists($table)
    {
        $table = $this->quote($table);
        $db = $this->quote($this->getDbName());

        $if_exists = "SELECT COUNT(*) AS `cnt`
			FROM `information_schema`.`tables`
			WHERE `table_schema` = {$db}
			AND `table_name` = {$table};
		";
        $if_exists = $this->query($if_exists);

        if (isset($if_exists[0]['cnt']) && $if_exists[0]['cnt'] == 1) {
            return true;
        } else {
            false;
        }
    }

    /**
     * Quote a string
     * @param string $value
     * @return string
     */
    public function quote($value)
    {
        return $this->pdo()->quote($value);
    }

    /**
     * Get the PDO object
     * @return \PDO
     */
    public function pdo()
    {
        return $this->pdo;
    }
    /**
     * Get number of rows of last statement
     * @return int number of rows
     */
    public function getNumRows()
    {
        return $this->last->rowCount();
    }

    /**
     * Get the last inserted id after an insert
     * @return int
     */
    public function getLastInsertedId()
    {
        return $this->pdo()->lastInsertId();
    }

    /**
     * Build WHERE clause for query
     * @param string $table table name
     * @param mixed $where can be primary id (eg '2'), can be string (eg 'name=pepe') or can be array
     * @return string sql where clause
     * @see buildSQLClauseOrderBy()
     */
    public function buildSQLClauseWhere($table, $where = null)
    {
        $query = '';

        if ($where !== null) {
            if (is_array($where)) {
                $query .= " WHERE ";

                foreach ($where as $field => $value) {
                    $query .= "`{$table}`.`{$field}`={$this->quote($value)} AND ";
                }
                $query = substr($query, 0, -5);
            } else {
                if (strpos($where, '=') === false) {
                    // no field given, use primary field
                    $primary = $this->getPrimary($table);
                    $query .= " WHERE `{$table}`.`{$primary}`={$this->quote($where)}";
                } elseif (strpos(strtolower(trim($where)), 'where') === false) {
                    $query .= " WHERE {$where}";
                } else {
                    $query .= ' ' . $where;
                }
            }
        }
        return $query;
    }

    /**
     * Build ORDER BY clause for a query
     * @param mixed $order_by can be string (with or without order by) or array
     * @param string $direction
     * @return string sql order by clause
     * @see buildSQLClauseWhere()
     */
    public function buildSQLClauseOrderBy($order_by, $direction)
    {
        $query = '';
        if ($order_by !== null) {
            if (is_array($order_by)) {
                $query .= " ORDER BY ";

                foreach ($order_by as $field) {
                    $query .= "`{$field}`, ";
                }
                // remove trailing ", "
                $query = substr($query, 0, -2);
            } else {
                if (strpos(strtolower(trim($order_by)), 'order by') === false) {
                    $query .= " ORDER BY {$order_by}";
                } else {
                    $query .= ' ' . $order_by;
                }
            }
        }
        if (strlen($query) > 0) {
            // check if "ASC" or "DESC" is already in the order by clause
            if (strpos(strtolower(trim($query)), 'asc') === false && strpos(strtolower(trim($query)), 'desc') === false) {
                $query .= ' ' . $direction;
            }
        }

        return $query;
    }

    /**
     * Get the host of the current connection
     * @return string
     */
    public function getDbHost()
    {
        return $this->db_host;
    }

    /**
     * Get the db name of the current connection
     * @return string
     */
    public function getDbName()
    {
        return $this->db_name;
    }

    /**
     * Get the db user of the current connection
     * @return string
     */
    public function getDbUser()
    {
        return $this->db_user;
    }

    /**
     * Get status of the connection
     * @return boolean
     */
    public function status()
    {
        return $this->status;
    }

    /**
     * Connect to the database.
     *
     * @return resource mysql resource
     */
    protected function connect()
    {
        try {
            $mongo = new MongoFriend([
                'host' => $this->db_host,
                'dbname' => $this->db_name,
                'uname' => $this->db_user,
                'upass' => $this->db_pass,
            ]);

            $this->status = true;
        } catch (\MongoDBException $e) {
            $this->status = false;
            return false;
        }
        return $this->mongo;
    }

    /**
     * Is called after connection failure
     */
    protected function onConnectFailure(\MongoDBException $e)
    {
        trigger_error('MySQL connection failed: ' . $e->getMessage(), E_USER_WARNING);
        return false;
    }

    /**
     * Disconnect from current link
     */
    protected function disconnect()
    {
        $this->pdo = null;
    }

    protected function error(\MongoDBException $e)
    {
        trigger_error('SQL error: ' . $e->getMessage(), E_USER_WARNING);
    }
}

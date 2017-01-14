<?php
/*
	--------------------------
	documented by Andriawan on January 7, 2017
	--------------------------
	AndDatabase class merupakan kelas untuk menangani pembentukan query sql
	dengan bersih dan aman

	forked from (di ambil dan dimodifikasi):

	@author		Author: Vivek Wicky Aswal. (https://twitter.com/#!/VivekWickyAswal)
 	@git 		https://github.com/indieteq/PHP-MySQL-PDO-Database-Class
 	@version    0.2ab

 	thanks for Vivek Wicky Aswal

 	from: Andriawan

 	tested = 60% fine


	*/
		
class AndDatabase{
	
	// Variabel untuk menangani pembentukan PDO
	private $pdo;

	// configurasi database yang dibutuhkan konstruktor PDO
	private $config;

	// menyimpan statement object PDO
	private $statement;

	// indikasi koneksi database
	private $isCon = false;

	// menangani kelas report, untuk pencatatan error
	private $report;

	public $param;

	//const PDO
	
	function __construct(){

		$this->report = new AndReport();
		$this->connect();
		$this->param = array();
		
	}

	function connect(){
		
		$this->config = parse_ini_file("config/AndMysql.ini");
		$dsn = 'mysql:dbname=' . $this->config["dbname"] . ';host=' . $this->config["host"] . '';

		try{

			$this->pdo = new PDO($dsn, $this->config["db_user"], $this->config["db_password"], array(
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

			# We can now log any exceptions on Fatal error. 
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            # Disable emulation of prepared statements, use REAL prepared statements instead.
            $this->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            
            # Connection succeeded, set the boolean to true.
            $this->isCon = true;
			
		} catch (PDOException $e){

			# Write into log
            echo $this->exceptionReport($e->getMessage());
            die();			
		}


	}


	public function closeConnection(){

        # Set the PDO object to null to close the connection
        # http://www.php.net/manual/en/pdo.connections.php
        $this->pdo = null;
    }


    public function starterQuery($query, $param=''){

    	# check connection
    	if (!$this->isCon){

    		$this->connect();

    	}

    	try{

    		$this->statement = $this->pdo->prepare($query);
    		$this->bindMore($param);

    		if (!empty($this->param)){

    			foreach ($this->param as $pparam => $value){

    				$type = PDO::PARAM_STR;
    				switch ($value[1]) {

    					case is_int($value[1]):
    						$type = PDO::PARAM_INT;
    						break;

    					case is_bool($value[1]):
    						$type = PDO::PARAM_BOOL;
    						break;

    					case is_null($value[1]):
    						$type = PDO::PARAM_NULL;
    						break;
    		
    				}

    				$this->statement->bindValue($value[0], $value[1], $type);
    				
    			}
    		}

    		$this->statement->execute();

    	}catch (PDOException $e){

            # Write into log and display Exception
            echo $this->exceptionReport($e->getMessage(), $query);
            die();
        }

        $this->param = array();

    }


    public function query($query, $params = null, $fetchMode = PDO::FETCH_ASSOC){

    	$query = trim(str_replace("\r", " ", $query));
    	$this->starterQuery($query, $params);
    	$rawStatement = explode(" ", preg_replace("/\s+|\t+|\n+/", " ", $query));
    	$statement = strtolower($rawStatement[0]);

    	if($statement === 'select' || $statement === 'show'){

    		return $this->statement->fetchAll($fetchMode);

    	}elseif($statement === 'insert' || $statement === 'update' || $statement === 'delete'){

    		return $this->statement->rowCount();

    	}else{

    		return NULL;
    	}
    	
    }



    public function queryObj($query, $params = null, $fetchMode = PDO::FETCH_OBJ){

    	$query = trim(str_replace("\r", " ", $query));
    	$this->starterQuery($query, $params);
    	$rawStatement = explode(" ", preg_replace("/\s+|\t+|\n+/", " ", $query));
    	$statement = strtolower($rawStatement[0]);

    	if($statement === 'select' || $statement === 'show'){

    		return $this->statement->fetchAll($fetchMode);

    	}elseif($statement === 'insert' || $statement === 'update' || $statement === 'delete'){

    		return $this->statement->rowCount();

    	}else{

    		return NULL;
    	}
    	
    }


    /**
     *  Returns the last inserted id.
     *  @return string
     */
    public function lastInsertId(){

        return $this->pdo->lastInsertId();

    }
    
    /**
     * Starts the transaction
     * @return boolean, true on success or false on failure
     */
    public function beginTransaction(){

        return $this->pdo->beginTransaction();

    }
    
    /**
     *  Execute Transaction
     *  @return boolean, true on success or false on failure
     */
    public function executeTransaction(){

        return $this->pdo->commit();

    }
    
    /**
     *  Rollback of Transaction
     *  @return boolean, true on success or false on failure
     */
    public function rollBack(){

        return $this->pdo->rollBack();

    }
    
    /**
     *	Returns an array which represents a column from the result set 
     *
     *	@param  string $query
     *	@param  array  $params
     *	@return array
     */


    /**
     *	Returns an array which represents a column from the result set 
     *
     *	@param  string $query
     *	@param  array  $params
     *	@return array
     */
    public function column($query, $params = null){

        $this->starterQuery($query, $params);
        $Columns = $this->statement->fetchAll(PDO::FETCH_NUM);        
        $column = null;
        
        foreach ($Columns as $cells) {
            $column[] = $cells[0];
        }
        
        return $column;
        
    }


    /**
     *	Returns an array which represents a row from the result set 
     *
     *	@param  string $query
     *	@param  array  $params
     *  @param  int    $fetchmode
     *	@return array
     */
    public function row($query, $params = null, $fetchMode = PDO::FETCH_ASSOC){

        $this->starterQuery($query, $params);
        $result = $this->statement->fetch($fetchMode);
        $this->statement->closeCursor(); // Frees up the connection to the server so that other SQL statements may be issued,
        return $result;

    }


    public function rowObj($query, $params = null, $fetchMode = PDO::FETCH_OBJ){

        $this->starterQuery($query, $params);
        $result = $this->statement->fetch($fetchMode);
        $this->statement->closeCursor(); // Frees up the connection to the server so that other SQL statements may be issued,
        return $result;

    }


    /**
     *	Returns the value of one single field/column
     *
     *	@param  string $query
     *	@param  array  $params
     *	@return string
     */
    public function single($query, $params = null){

        $this->starterQuery($query, $params);
        $result = $this->statement->fetchColumn();
        $this->statement->closeCursor(); // Frees up the connection to the server so that other SQL statements may be issued
        return $result;

    }


    function bind($para, $value){

    	$this->param[sizeof($this->param)] = [":" . $para , $value];
    }


    function bindMore($parray){

    	if (empty($this->param) && is_array($parray)) {
          
            $columns = array_keys($parray);
            foreach ($columns as $i => $column) {
                $this->bind($column, $parray[$column]);
            }
        }
    	
    }


    private function exceptionReport($message, $sql = ""){

        $exception = 'Unhandled Exception. <br />';
        $exception .= $message;
        $exception .= "<br /> You can find the error back in the log.";
        
        if (!empty($sql)) {
            # Add the Raw SQL to the Log
            $message .= "\r\nRaw SQL : " . $sql;
        }
        # Write into log
        $this->report->writeReport($message);
        
        return $exception;

    }


}
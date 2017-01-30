<?php

use mondrakeNG\dbol\DbConnection;
use mondrakeNG\dbol\Dbol;
use mondrakeNG\dbol\DbolEntry;
use mondrakeNG\mm\core\MMDiag;
use mondrakeNG\mm\core\MMUtils;

class drupalTableObj {
	protected static $dbol = null;
	protected static $dbObj = array();
	protected static $childObjs = array();
	protected $diag = null;
	protected $tableName;    

	public function __construct($table = null) {	
		if (self::$dbol === NULL)     {
			$params = array(
                'decimalPrecision' 	=> DB_DECIMALPRECISION,
                'perfLogging'	 	=> DB_QUERY_PERFORMANCE_LOGGING,
                'perfThreshold' 	=> DB_QUERY_PERFORMANCE_THRESHOLD,
                );
			self::$dbol = new Dbol(DBOL_CONNECTION_NAME, $params);
		}
		$this->diag = new MMDiag;
		if ($table and !isset(self::$dbObj[$table])) {
			$this->tableName = $table;
			self::$dbObj[$this->tableName] = new dbolEntry;
			self::$dbObj[$this->tableName]->table = $table;
			self::$dbObj[$this->tableName]->tableProperties['auditLogLevel'] = 0;
			self::$dbObj[$this->tableName]->tableProperties['listOrder'] = null;
			self::$dbObj[$this->tableName]->tableProperties['environmentDependent'] = false;
			self::$dbObj[$this->tableName]->tableProperties['clientTracking'] = false;
			self::$dbObj[$this->tableName]->tableProperties['readBackOnChange'] = false;
			self::$dbObj[$this->tableName]->tableProperties['performanceTracking'] = false;
			self::$dbObj[$this->tableName]->tableProperties['sequencing'] = false;
			DbConnection::fetchAllColumnsProperties(DBOL_CONNECTION_NAME, $this->tableName, self::$dbObj[$this->tableName]);

		}
	}
 
	public function getdbol()	{
		return self::$dbol;
	}

	public function getDbObj()	{
		return self::$dbObj[$this->tableName];
	}

	public function fetchAllTables()	{
		return self::$dbol->fetchAllTables();
	}
	
	public function setSessionContext($params) {
	 	self::$dbol->setSessionContext($params);
	}

	public function getSessionContext($var = NULL) {
	 	return self::$dbol->getSessionContext($var);
	}

	public function setColumnProperty($cols, $prop, $value)     {
		return self::$dbol->setColumnProperty(self::$dbObj[$this->tableName], $cols, $prop, $value);
	}

	public function getColumnProperties()	{
		return self::$dbol->getColumnProperties(self::$dbObj[$this->tableName]);
	}

	public function setPKColumns($cols)     {
		return self::$dbol->setPKColumns(self::$dbObj[$this->tableName], $cols);
	}

	public function compactPKIntoString() {
		return self::$dbol->compactPKIntoString($this, self::$dbObj[$this->tableName]);
	}

	public function read($pk) {
		//$whereClause = self::$dbol->explodePKStringIntoWhere(self::$dbObj[$this->tableName], $pk);
		//return self::readSingle($whereClause);
    return self::$dbol->readSinglePK($this, self::$dbObj[$this->tableName], $pk);
	}
 
	public function readSingle($whereClause) {
		$ret = self::$dbol->readSingle($this, self::$dbObj[$this->tableName], $whereClause);
		return $ret;
	}
	
	public function readMulti($whereClause = NULL, $orderClause = NULL, $limit = NULL, $offset = NULL) {
		$ret = self::$dbol->readMulti($this, self::$dbObj[$this->tableName], $whereClause, $orderClause, $limit, $offset);
		return $ret;
	}

	public function listAll($whereClause = NULL, $limit = NULL, $offset = NULL) {
		return $this->readMulti($whereClause, self::$dbObj[$this->tableName]->tableProperties['listOrder'], $limit, $offset);
	}

	public function create($clientPKMap = false) {
		//$sessionContext = self::$dbol->getSessionContext();

		if ($this->validate() > 3)	{
			$table = $this->getDbObj()->table;
			throw new Exception("Validation error on create - Table: $table - PK: $this->primaryKeyString");
		}

		$res = self::$dbol->create($this, self::$dbObj[$this->tableName]);
		
		return $res;
	}

	public function createMulti($arr) {
		$res = 0;
		foreach ($arr as $c => $obj)	{
				$res += $obj->create();
		}
		return $res;
	}

	public function update() {
		//$sessionContext = self::$dbol->getSessionContext();
		return self::$dbol->update($this, self::$dbObj[$this->tableName]);
	}
		
	public function delete($clientPKMap = false) {
		//$sessionContext = self::$dbol->getSessionContext();
		$res = self::$dbol->delete($this, self::$dbObj[$this->tableName]);
		return $res;
	} 

	public function query($sqlq, $limit = NULL, $offset = NULL, $sqlId = NULL)	{
		return self::$dbol->query($sqlq, $limit, $offset, $sqlId);
	}

	public function beginTransaction()	{
		return self::$dbol->beginTransaction();
	}

	public function commit()	{
		return self::$dbol->commit();
	}

	public function executeSql($sqlq)	{
		return self::$dbol->executeSql($sqlq);
	}
	
	protected function validate() {
	}
	
	protected function diagLog($severity, $id, $params, $tableName = null, $throwExceptionOnError = FALSE) {
		if (empty($tableName))	{
			$tableName = get_class($this);
		}
		$this->diag->sLog($severity, $tableName, $id, $params);
		if ($severity == 4)	{
		   // prepares msg for exception
			foreach ($this->diag->get(FALSE) as $a)	{
				$msg .= $a->time . ' - ' . $a->severity . ' - ' . $a->tableName . ' - ' . $a->id . ' - ' . $a->fullText . " \n";
			}
			// logs backtrace
			if ($link->backtrace)	{
				foreach ($link->backtrace as $a => $b)	{
					$this->diag->sLog(4, 'backtrace', 0, array('#text' => $a . ' ' . $b['class'] . '/' . $b['function'] . ' in ' . $b['file'] . ' line ' . $b['line'],));
				}
			}
			if ($throwExceptionOnError)	{
				throw new Exception($msg);
			}
		}
    }

	public function startWatch($id)	{
		return $this->diag->startWatch($id);
	}

	public function getLog()	{
		return $this->diag->get();
	}

	public function __call($name, $args)
    {
        throw new Exception ('Undefined method ' . get_class($this) . '.' . $name . ' called');
    }

}
?>
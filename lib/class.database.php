<?php
//////////////////////////////////////////////////////////////////////////
// +------------------------------------------------------------------+ //
// + Project  : Upject Framework <http://www.upject.at> 	          + //
// + Copyright: (c) 2005, Upject Framework Authors/Developers         + //
// + Author(s): Michael Aufreiter <ma@zive.at>                        + //
// +            Matthias Zauner <mz@zive.at>                          + //
// +------------------------------------------------------------------+ //
//////////////////////////////////////////////////////////////////////////

/**
 * 
 * 
 * @filesource 
 * @author Upject Framework Authors/Developers
 * @copyright Copyright (c) 2005, Upject Framework Authors/Developers
 * @version $Id$
 *
 */

class databaseLocal {
  var $conn=0;
  var $port=3306;
  var $host="localhost";
  var $database="vvvv_js_lab";
  var $username="root";
  var $password="";
  var $result=0; // stores the result of a mysql query
  var $resrow=""; // stores one row of the result
  var $insertid=-1;
  
  function databaseLocal()
  {
  	$this->conn=$this->connect();
  }
  
  function connect()
  {
    $this->conn = mysql_connect($this->host, $this->username, $this->password);
    if ($this->conn)
      return mysql_select_db($this->database);
    else 
      return $this->conn;
  }
  
  function query($qry)
  {
  	$tim = microtime(true);
    if (!$this->conn)
    {
      $this->conn=$this->connect();
    }
    if ($this->conn)
    {
      $this->result=mysql_query($qry);
      $this->insertid=mysql_insert_id();
      
      if (!$this->result)
      {
      	echo "<b>$qry</b><br/>\n";
        echo mysql_error()."<br/>\n";
      }
      return $this->result;
    }
    
    
    
    
  }
  
  function get($id)
  {
    if ($this->resrow=="") return "";
    return $this->resrow[$id];
  }
  
  function f($id)  // just for upgrading purpose, delete later
  {
    return $this->get($id);
  }
  
  function next_record()
  {
    if ($this->conn==0)
      echo "ERROR: First issue a query !!!\n";
    if ($this->result==0)
      echo "ERROR: First issue a query !!!\n";
    $this->resrow=mysql_fetch_array($this->result);
    return $this->resrow;
  }
  
  function insert_id()
  {
    return $this->insertid;
  }
  
  function num_rows()
  {
    return mysql_num_rows($this->result);
  }
  
  
  
  function add($tablename, $object) {
  	
  	$qry = "INSERT INTO $tablename (".implode(", ", array_keys($object)).") VALUES('".implode("', '", $object)."')";
  	$this->query($qry);
  	
  }
  
  function save($tablename, $object, $keycolumn) {
  	$setstr = "";
  	foreach ($object as $column => $value) {
  		$columnstmts[] = $column."='".$value."'";
  	}
  	$qry = "UPDATE $tablename SET ".implode(", ",$columnstmts)." WHERE $keycolumn='".$object[$keycolumn]."'";
  	$this->query($qry);
  }
 
}

/*class database_local extends databaseLocal {
	
}*/
?>

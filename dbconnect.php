<?php

class DB{
    private $con = null;    
    public function __construct(){
        $this->con = mysql_connect("localhost", "cantas_ise2","Password1!");
        if(!$this->con){
           $this->db_error("Connection...."); 
        }
        mysql_query("SET NAMES 'latin5'", $this->con);
        mysql_query("SET CHARACTER SET latin5", $this->con);
        mysql_query("SET COLLATION_COLLECTION='latin5_turkish_ci'", $this->con);
        mysql_select_db("cantas_ise", $this->con);
    }
    public function db_error($text){
        echo "Eroor: ".$text."<br>";
        echo "mysql Error : ".mysql_error($this->con);        
    }
    public function __destruct() {
        if($this->con != null){
            mysql_close($this->con);
            $this->con = null;
        }        
    }
    public function query($sql){
        return mysql_query($sql, $this->con);
    }
    public function fetchAssoc($result)
    {
        return mysql_fetch_assoc($result);        
    }
    
    public function fetchArr($result)
    {
        return mysql_fetch_array($result);        
    }
    function size($result){
        return mysql_num_rows($result);
    } 
    function sizeColumn($result){
        return mysql_numfields($result);
    }
}

$dbObj = new DB();         

?>

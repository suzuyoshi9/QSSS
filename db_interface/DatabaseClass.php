<?php
require 'dbpass.php';
class Database{
    var $dbServer;
    var $dbName;
    var $dbUser;
    var $dbPass;
    var $link;
    var $stmt;
    var $insert_id;

    function Database(){
        $this->dbServer=$GLOBALS["dbServer"];
        $this->dbName=$GLOBALS["dbName"];
        $this->dbUser=$GLOBALS["dbUser"];
        $this->dbPass=$GLOBALS["dbPass"];

        $this->connect();	
    }

    private function connect(){
        $this->link=new mysqli($this->dbServer,$this->dbUser,$this->dbPass,$this->dbName);
        if($this->link->connect_error) die("Connect Error:".'('.$this->link->connect_errno.')'.$this->link->connect_error);
        $this->link->set_charset("utf8");
    }

    public function close(){
        $this->link->close();
        $this->link=null;
    }

    public function query($query){
        if(isset($this->stmt)) $this->stmt->reset();
        $this->stmt=$this->link->prepare($query) or exit($this->getError());
        $this->stmt->execute() or exit($this->getError());
        $this->insert_id=$this->stmt->insert_id;
        $this->stmt->store_result();
        return $this->stmt;
    }

    public function prepare($query){
        if(isset($this->stmt)) $this->stmt->reset();
        $this->stmt=$this->link->prepare($query) or exit($this->getError());
    }

    public function bind_param(){
        $params=func_get_args();
        call_user_func_array(array($this->stmt,'bind_param'),$this->refValues($params)) or exit($this->getError());
    }

    public function execute(){
        $this->stmt->execute() or exit($this->getError());
        $this->insert_id=$this->stmt->insert_id;
        $this->stmt->store_result();
        return $this->stmt;
    }

    public function getuid($user){
        if(isset($this->stmt)) $this->stmt->reset();
        $this->stmt=$this->link->prepare("select id from user where login_name= ?");
        $this->stmt->bind_param('s',$user);
        $this->stmt->execute() or exit($this->getError());
        $this->stmt->bind_result($result);
        $this->stmt->fetch();
        return $result;	
    }

    public function gettid($tag){
        if(isset($this->stmt)) $this->stmt->reset();
        $this->stmt=$this->link->prepare("select id from tag where name= ?");
        $this->stmt->bind_param('s',$tag);
        $this->stmt->execute() or exit($this->getError());
        $this->stmt->bind_result($result);
        $this->stmt->fetch();
        return $result;
    }

    public function __destruct(){
        $this->close();
    }

    private function refValues($arr){ 
        //http://stackoverflow.com/questions/16120822/mysqli-bind-param-expected-to-be-a-reference-value-given
        if (strnatcmp(phpversion(),'5.3') >= 0) //Reference is required for PHP 5.3+
        {
            $refs = array();
            foreach($arr as $key => $value)
                $refs[$key] = &$arr[$key];
            return $refs;
        }
        return $arr;
    }

    private function getError(){
        return "Error:".'('.$this->link->errno.')'.$this->link->error;
    }
}
?>

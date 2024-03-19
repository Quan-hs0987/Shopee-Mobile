<?php 
    class DBController{
        protected $host = 'localhost';
        protected $user = 'root';
        protected $password = '';
        protected $database = 'shopee';

        public $conn = null;

        public function __construct(){
            $this->conn = mysqli_connect($this->host, $this->user, $this->password, $this->database);
            if($this->conn->connect_error){
                echo 'Fail'.$this->conn->connect_error;
            }
        }

        protected function closeConn(){
            if ($this->conn != null){
                $this->conn->close();
                $this->conn = null;
            }
        }

        public function __destruct(){
            $this->closeConn();
        }
    }

?>
<?php

    class DbConnect {
        private $server = "sql6.freesqldatabase.com"
        private $dbname = 'sql6460553';
        private $user = sql6460553
        private $pass = 'eRUmkwXs1c';


        public function connect() {
            try {
                $conn = new PDO ('mysql:host=' .$this->server.';dbname='
                . $this->dbname, $this->user, $this->pass);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                return $conn; 
            } catch (Exception $e) {
                echo "Database Error: " . $e->getMessage();
            }
        }
    }
?>
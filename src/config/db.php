<?php
    class db{
        private $dbHost = '67.227.237.216';
        private $dbUser = 'cernetco_magon';
        private $dbPassword = 'fovwat-7cobne-kovsIr';
        private $dbName = 'cernetco_magon';

        //Conexion 
        public function conexionDB(){
            $mysqlConnect = "mysql:host=$this->dbHost;dbname=$this->dbName";
            $dbConnection = new PDO($mysqlConnect, $this->dbUser, $this->dbPassword);
            $dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return $dbConnection;
        }
    }
?>
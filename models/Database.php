<?php
    class Database{
        private $serverName;
        private $username;
        private $password;
        private $dbName;
        private $connection;

        function __construct($serverName, $username, $password, $dbName){
            $this->serverName = $serverName;
            $this->username = $username;
            $this->password = $password;
            $this->dbName = $dbName;
			
			//Test the connection by immediately connecting then disconnecting
            try{
                $this->Connect();
                $this->Disconnect();
            } catch(Exception $e){
                //Usually, logging of the exception is best to go here
                //Throw the exception in this object to be caught by the object instance
                throw $e;
            }
        }

        //Connect to database
        private function Connect(){
            $dsn = "mysql:host=" . $this->serverName . ";dbname=" . $this->dbName;
            $this->connection = new PDO($dsn, $this->username, $this->password);
        }
        
        //Disconnect to database
        private function Disconnect(){
            $this->connection = NULL;
        }
		
		//PHP doesn't support method overloading
        //Execute a Regular SQL Query
        public function ExecuteSQL($query, $params = null, $className = null){
            //Connect to database
            $this->Connect();

            //Prepare query
            $sql = $this->connection->prepare($query);

            //If params exist, bind them to query
            if(!is_null($params)){
                foreach($params as $param => $value){
                    $sql->bindParam($param, $value);
                }
            }

			//Set fetch mode to class if required
            //Fields in database must match EXACTLY to properties in Class
			if(!is_null($className)){
				$sql->setFetchMode(PDO::FETCH_CLASS, $className);
		 	} else{
				$sql->setFetchMode(PDO::FETCH_ASSOC);
			}
       
            $sql->execute();

            //Disconnect from database
            $this->Disconnect();

            //Return results
            return $sql->fetchAll();
        }

        //Execute a Scalar SQL query (DELETE, INSERT, etc)
        public function ScalarSQL($query, $params = null){
            $this->Connect();

            $sql = $this->connection->prepare($query);

            if(!is_null($params)){
                foreach($params as $param => $value){
                    $sql->bindParam($param, $value);
                }
            }

            $sql->execute();

            //If row count doesn't equal 1, an error must have occured
            if($sql->rowCount() != 1){
                //Format error info in a readable fashion
                $errorInfo = $sql->errorInfo();
                $errorMessage = "MariaDB Error Code: " . $errorInfo[1] . "\nError Message: " . $errorInfo[2];
                
                //Disconnect from database
                $this->Disconnect();

                //Return error message
                return $errorMessage;
            }

            //Else, disconnect database
            $this->Disconnect();

            //Only a failed query will return a value
        }
    }
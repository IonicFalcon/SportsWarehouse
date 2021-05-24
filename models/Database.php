<?php  
    /**
     * Generic class for dealing with a Database using PDO. Includes functionality for sending different SQL requests, including Scalar queries
     */
    class Database{
        private $serverName;
        private $username;
        private $password;
        private $dbName;
        private $connection;
        
        /**
         * Creates and tests Database object and connection. 
         *
         * @param  string $serverName
         * @param  string $username
         * @param  string $password
         * @param  string $dbName
         * @return Database|Exception A failed connection cause by incorrect Database details with throw an Exception
         */
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

        /**
         * Connects to Database by creating PDO object
         */
        private function Connect(){
            $dsn = "mysql:host=" . $this->serverName . ";dbname=" . $this->dbName;
            $this->connection = new PDO($dsn, $this->username, $this->password);
        }
        
        /**
         * Destroys PDO object, hence disconnecting Database
         */
        private function Disconnect(){
            $this->connection = NULL;
        }
		
        /**
         * Execute SQL Query and returns values in the form of an array
         *
         * @param string $query
         * @param array $params Parameters for the query in an Associative Array
         * @param string $className Class name for filling returned values into a Class
         * @return array
         */
        public function ExecuteSQL($query, $params = null, $className = null){
            //Connect to database
            $this->Connect();
            //Prepare query
            $sql = $this->connection->prepare($query);

            //If params exist, bind them to query
            if(!is_null($params)){
                foreach($params as $param => $value){
                    //Value can be an array that holds the value and the PDO datatype (PDO::PARAM_INT, etc)
                    if(is_array($value)){
                        $sql->bindValue($param, $value[0], $value[1]);
                    } else{ 
                        $sql->bindValue($param, $value);
                    }
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
        
        /**
         * Execute SQL Query and return a single value
         *
         * @param string $query
         * @param array $params Parameter for query in associative array
         * @return mixed
         */
		public function ExecuteSQLSingleVal($query, $params = null){
			$this->Connect();
			
			$sql = $this->connection->prepare($query);
			
			if(!is_null($params)){
				foreach($params as $param => $value){
					if(is_array($value)){
						$sql->bindValue($param, $value[0], $value[1]);
					} else{
						$sql->bindValue($param, $value);
					}
				}
			}
			
			$sql->execute();
			
			$this->Disconnect();
			
			return $sql->fetchColumn();
		}

        /**
         * Execute a Scalar SQL Query (DELETE, INSERT, etc)
         *
         * @param string $query 
         * @param array $params Parameters for the query in associative array
         * @return void|string   Returns string on error, else returns nothing
         */
        public function ScalarSQL($query, $params = null){
            $this->Connect();

            $sql = $this->connection->prepare($query);

            if(!is_null($params)){
                foreach($params as $param => $value){
                    if(is_array($value)){
                        $sql->bindValue($param, $value[0], $value[1]);
                    } else{ 
                        $sql->bindValue($param, $value);
                    }
                }
            }

            $sql->execute();

            //If row count doesn't equal 1, an error must have occured
            if($sql->rowCount() != 1){
                //Format error info in a readable fashion
                $errorInfo = $sql->errorInfo();

                //No row was affected, but no error occured. No changes have been made
                if($errorInfo[0] == "00000"){
                    return $this->Disconnect();
                }

                //Foreign key constraint error, should be treated differently as caused by user
                if($errorInfo[0] == "23000"){
                    throw new Exception($errorInfo[2], $errorInfo[0]);
                }

                $errorMessage = "MariaDB Error Code: " . $errorInfo[1] . " Error Message: " . $errorInfo[2];
                
                //Disconnect from database
                $this->Disconnect();

                //Return error message
                return $errorMessage;
            }

            //Else, disconnect database
            $this->Disconnect();

            //Only a failed query will return a value
        }
        
        /**
         * Executes a Scalar SQL Query and returns auto-generated ID of row affected
         *
         * @param  mixed $query
         * @param  mixed $params Parameters for the query in an associative array
         * @return array Returns array with first value determining success and second value either being the returned ID or an error message
         */
        public function ScalarSQLReturnID($query, $params = null){
            $this->Connect();

            $sql = $this->connection->prepare($query);

            if(!is_null($params)){
                foreach($params as $param => $value){
                    if(is_array($value)){
                        $sql->bindValue($param, $value[0], $value[1]);
                    } else{ 
                        $sql->bindValue($param, $value);
                    }
                }
            }

            $sql->execute();

            //If row count doesn't equal 1, an error must have occured
            if($sql->rowCount() != 1){
                //Format error info in a readable fashion
                $errorInfo = $sql->errorInfo();
                $errorMessage = "MariaDB Error Code: " . $errorInfo[1] . " Error Message: " . $errorInfo[2];
                
                //Disconnect from database
                $this->Disconnect();

                //Return error message
                return [
                    false,
                    $errorMessage
                ];
                
            }

            $id = $this->connection->lastInsertId();
            //Else, disconnect database
            $this->Disconnect();

            return [
                true,
                $id
            ];
        }
    }
    
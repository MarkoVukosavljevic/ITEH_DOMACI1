<?php     
    class Author
    {
        public $_Connection;
        public $_AuthorId;
        public $_FirstName;
        public $_LastName;
        public $_InsertedOn;
        public $_DeletedOn; 
        public $_Books;
        public function __construct($id, $firstname, $lastName, $insertedOn, $deletedOn, $connection) {
            $this->_AuthorId = $id;
            $this->_FirstName = $firstname;
            $this->_LastName = $lastName;
            $this->_InsertedOn = $insertedOn;
            $this->_DeletedOn = $deletedOn;
            $this->_Connection = $connection;
        
        }

        public function printAuthor()
        {
            echo  $this->_AuthorId . " "
                  . $this->_FirstName . " "
                  . $this->_LastName . " "
                  . $this->_InsertedOn . " "
                  . $this->_DeletedOn . " ";
                  
        }

        public function getById($id)
        {
            $query = "SELECT * FROM Authors where AuthorId = $id  and e.DeletedOn is null";
            $authorsDB  = $_Connection->query($query);
        
            $authors = array();
            foreach ($authorsDB->fetch_all(MYSQLI_ASSOC) as $author ) 
            {             
                $authors[]= new Author( $author['AuthorId'],  $author['FirstName'],  $author['LastName'] ,  $author['InsertedOn'], $author['DeletedOn'], $connection);
            }
    
        
            return $authors;
        }

        public function insert()
        {
            $temp = new DateTime($this->_InsertedOn);
            $this->_InsertedOn =  $temp->format('Y-m-d H:i:s');
            $query =  "INSERT INTO Authors ( FirstName, LastName, InsertedOn, DeletedOn)
            VALUES ('$this->_FirstName', '$this->_LastName', '$this->_InsertedOn', null)";
            $this->_Connection->query($query);
            $this->_AuthorId =  $this->_Connection->insert_id;            
            
        }
       

        public function update()
        {
            $temp = new DateTime($this->_InsertedOn);
            $this->_InsertedOn =  $temp->format('Y-m-d H:i:s');
            $query =  "UPDATE Authors set AuthorId = $this->_AuthorId , FirstName = '$this->_FirstName', LastName = '$this->_LastName', InsertedOn = '$this->_InsertedOn'  where AuthorId = $this->_AuthorId";
            $this->_Connection->query($query);
            $_AuthorId;            
        }


        public function deleteById($id)
        {
            $query = "UPDATE Authors set DeletedOn = now() where AuthorId= $id";
            echo $query;
            $this->_Connection->query($query);
        }

        public function delete($id)
        {
            $query = "DELETE FROM Authors  where AuthorId= $id";
            echo $query;
            $this->_Connection->query($query);
        }

    }



?>
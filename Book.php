
<?php 

    class Book
    {
        public $_Connection;
        
        public $_BookId;
        public $_Caption;
        public $_Genre;
        public $_Author;
        public $_PublishedOn;
        public $_InsertedOn;
        public $_DeletedOn; 
        
        public function __construct($bookId, $caption, $genre, $author, $publishedOn, $insertedOn, $deletedOn , $connection) {
            $this->_BookId = $bookId;
            $this->_Caption = $caption;
            $this->_Genre = $genre;
            $this->_Author = $author;
            $this->_PublishedOn = $publishedOn;
            $this->_InsertedOn = $insertedOn;            
            $this->_DeletedOn = $deletedOn;      
            $this->_Connection = $connection;
        }

        public function printBook()
        {
            echo  $this->_BookId . " "
                  . $this->_Caption . " "
                  . $this->_Genre . " "
                  . $this->_PublishedOn . " "
                  . $this->_InsertedOn . " "
                  . $this->_DeletedOn . " ";
                  
        }
        public function getById($id)
        {
            $query = "SELECT * FROM Books where BookId= $id where DeletedOn is null";
            $booksDB  = $_Connection->query($query);
        
            $books = array();
            foreach ($booksDB->fetch_all(MYSQLI_ASSOC) as $book ) 
            {             
               // $author  = new Author($book['AuthorId'],  $book['FirstName'],  $book['LastName'] ,  $book['InsertedOn'], $book['DeletedOn'], null, $connection);
                $books[]= new Book( $book['BookId'],  $book['Caption'],  $book['Genre'] , $author , $book['PusblishedOn'],  $book['InsertedOn'],  $book['DeletedOn'], $connection);
            }
    
        
            return $books;
        }

        public function insert()
        {
            $author = $this->_Author;
           
            $temp = new DateTime($this->_PublishedOn);
            $this->_PublishedOn = $temp->format('Y-m-d H:i:s');
            $temp = new DateTime($this->_InsertedOn);
            $this->_InsertedOn =  $temp->format('Y-m-d H:i:s');
            echo $this->_DeletedOn;
            if($this->_DeletedOn === "")
            {
                $this->_DeletedOn = null;
            }
            else
            {
                $temp = new DateTime($this->_DeletedOn);
                $this->_DeletedOn = $temp->format('Y-m-d H:i:s');
            }
                
          
            $query =  "INSERT INTO Books (AuthorId,Caption, Genre, PublishedOn, InsertedOn)
            VALUES ('$author->_AuthorId','$this->_Caption', '$this->_Genre','$this->_PublishedOn','$this->_InsertedOn')";
            $this->_Connection->query($query);
            $this->_BookId =  $this->_Connection->insert_id;            
            
        }
       

        public function updateById($id)
        {
            $author = $this->_Author;
            $temp = new DateTime($this->_PublishedOn);
            $this->_PublishedOn = $temp->format('Y-m-d H:i:s');
            $temp = new DateTime($this->_InsertedOn);
            $this->_InsertedOn =  $temp->format('Y-m-d H:i:s');
            $query =  "UPDATE Books set AuthorId = $author->_AuthorId, Caption = '$this->_Caption ', Genre = '$this->_Genre', PublishedOn =  '$this->_PublishedOn', InsertedOn = '$this->_InsertedOn' where BookId = $id";
            $this->_Connection->query($query);
            $id;            
        }


        public function deleteById($id)
        {
            $query = "UPDATE Books set DeletedOn = now() where BookId= $id";
            echo $query;
            $this->_Connection->query($query);
        }

        public function delete($id)
        {
            $query = "DELETE FROM Books where BookId= $id";
            echo $query;
            $this->_Connection->query($query);
        }
    }


?>
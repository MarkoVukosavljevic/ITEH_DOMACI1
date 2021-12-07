
<?php 
include 'Book.php';
include 'Author.php';

function selectAllAuthors($connection)
{
        $query = "SELECT * FROM Authors a where a.DeletedOn is null ";
        $authorsDB  = $connection->query($query);
        
        $authors = array();
        
      
     
        $author = null;
        $books = array();
        $i = 0;
        $authorIds = array();
        foreach ($authorsDB->fetch_all(MYSQLI_ASSOC) as $author ) 
        {         
              
            $authors []  = new Author($author['AuthorId'],  $author['FirstName'],  $author['LastName'] ,  $author['InsertedOn'], $author['DeletedOn'], null, $connection);
            
        }
        
        return $authors;
}


function selectAllBooks($connection)
{
    $query = "SELECT * FROM Books b join Authors a on b.AuthorId = a.AuthorId  where b.DeletedOn is null";
    $booksDB  = $connection->query($query);
    
    $books = array();
     //echo '<pre>' .print_r($booksDB->fetch_all(MYSQLI_ASSOC)) . '<pre>';
    foreach ($booksDB->fetch_all(MYSQLI_ASSOC) as $book ) 
    {             
        $author  = new Author($book['AuthorId'],  $book['FirstName'],  $book['LastName'] ,  $book['InsertedOn'], $book['DeletedOn'], null, $connection);
        $books[]= new Book($book['BookId'], $book['Caption'],  $book['Genre'], $author , $book["PublishedOn"],  $book['InsertedOn'] ,  null, $connection);
    }

    
    return $books;
}?>
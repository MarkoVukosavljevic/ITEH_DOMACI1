<?php
    include 'Author.php';
    include 'Book.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
        $firstName = $_POST['firstname']; 
        $lastname = $_POST['lastname']; 
        $insertedOn = $_POST['insertedOn']; 
        $deletedOn = null;
        $id = $_POST['editable-id'];

        $conn = new mysqli('localhost', 'root', '', 'library');


        if($conn->connect_error)
        {
            die("connection failed:" + $conn->connect_error );
        }

       /*
        
        $authorId = null;
        if($id !== "")
            $authorId = $id;
*/
            
        $author = new Author($id, $firstName, $lastname, $insertedOn, $deletedOn, $conn);
      
        if($id === ""){
            $author->insert();
            echo json_encode($author->_AuthorId);
        }
        else{
            $author->update();
            echo $id;
        }
    }
?>
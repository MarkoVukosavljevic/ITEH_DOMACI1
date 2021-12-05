<?php include 'Author.php';


    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        $id = $_GET['id'];
        $conn = new mysqli('localhost', 'root', '', 'library');


        if($conn->connect_error)
        {
            die("connection failed:" + $conn->connect_error );
        }

        $author = new Author($id,null,null,null,null,$conn);

        $author->deleteById($id);
  
    }
?>
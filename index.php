<?php 
include 'getAll.php';

    $conn = new mysqli('localhost', 'root', '', 'library');


    if($conn->connect_error)
    {
        die("connection failed:" + $conn->connect_error );
    } ?>

<html>
        <head>
            <title>Domaci 1</title>
            <!-- <link rel="stylesheet" href="bootstrap.min.css"> -->
            <link rel="stylesheet" href="/css/bootstrap.min.css">
            <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.css">
            <link href="./bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" type="text/css" media="all" rel="stylesheet">
            <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.min.js"></script>


            <link rel="stylesheet" type="text/css" href="custom.css">
        </head>
        
        <body style="" >
        <div class="content-cont" style="background-image:url('library.jpg');height:100%;width:100%; " >
        <script src="jquery.js"></script> <!-- ucitamo jquery  -->
        <script src="/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="./bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
      
        <script src="custom.js"></script> <!-- ucitamo , to je nasa skripta  -->
            
            <header>
                <div class="container">
                    <nav class="nav-bar ">
                        <ul>
                            <li>
                                <a style="color: #fff !important;"  href="/index.php">Books</a>
                            </li>
                            <li>
                                <a style="color: #fff !important;" href="/authors.php">Authors</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </header>

            <div class="container">
                <section class="center-block" >
                    <div class="text-right">
                        <button type="button" data-toggle="modal" data-target="#add_edit_Modal"   class="btn btn-info add-book btn-add"  >
                            Add book
                        </button> 
                    </div>
                    <table class="table ">
                        <thead>
                            <tr>
                                <td>
                                    <span>Caption</span>
                                </td>
                                <td>
                                    <span>Genre</span>
                                </td>
                                <td>
                                    <span> Author</span>
                                </td>
                                <td>
                                <span> Published </span>
                                </td>
                                <td>
                                   <span>Added On</span>
                                </td>
                                
                                <td>
                                
                                </td>
                            </tr>
                        </thead>
                        <tbody id="table-cont">

                            <?php 
                            
                            $books = selectAllBooks($conn) ;

                            //echo '<pre>' . print_r($students).'</pre>';
                                foreach($books as $book)
                                {
                                    $author = $book->_Author;
                                    $authorName = $author->_FirstName . " " . $author->_LastName;
                                ?>
                                
                                    <tr class="tbl_row tr-<?php echo $book->_BookId; ?>" >
                                        
                                        <td>
                                         <span><?php echo $book->_Caption; ?></span>
                                        </td>
                                        <td>
                                            <span><?php echo $book->_Genre; ?></span>
                                        </td>
                                        <td>
                                         <span><?php echo $authorName; ?></span>
                                        </td>
                                        <td>
                                        <span>
                                            <?php 
                                                $dt = new DateTime($book->_PublishedOn);

                                                $date = $dt->format('m/d/Y');
                                                echo $date; 
                                            ?>
                                            </span>
                                        </td>
                                        <td>
                                        <span>
                                            <?php 
                                                $dt = new DateTime($book->_InsertedOn);

                                                $date = $dt->format('m/d/Y');
                                                echo $date; 
                                                 ?>
                                                 </span>
                                        </td>
                                        
                                        <td>
                                        <span>
                                            <button type="button" data-toggle="modal" data-target="#add_edit_Modal" data-id='<?php echo $book->_BookId; ?>' id='<?php echo $book->_BookId; ?>'  class="btn btn-info edit-book btn-edit editable <?php echo $book->_BookId; ?>"  >
                                                Edit
                                            </button>                                           
                                            
                                            <button  id='<?php echo $book->_BookId; ?>'  class="btn btn-danger delete-book btn-delete <?php echo $book->_BookId; ?>"  >
                                                Delete
                                            </button>
                                </span>
                                        </td>
                                    </tr>

                            <?php
                                }    
                            ?>
                        </tbody>
                    </table>
                </section>

                <div style="color:#6c757d !important;" class="modal fade" id="add_edit_Modal" tabindex="-1" role="dialog" aria-labelledby="add_edit_ModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <form id="add-form" class="form col-md-12 " action="add_update_book.php"  method="POST"  >
                            <div class="modal-content">
                        
                                <div class="modal-header">
                                    <h5 class="modal-title" id="add_edit_ModalLabel">Add/Edit book</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                <div class="add-cont col-md-12">
                                         <?php $currentDate =  date('Y-m-d'); ?>
                                    
                                    
                                    <div class="form-group row">
                                        <label class="col-md-6" for="caption">Caption</label>
                                        <input type="text" class="col-md-6" name="caption"  id="caption" placeholder="Enter caption..." required>
                                    </div>  
                                    <div class="form-group row">
                                        <label class="col-md-6" for="genre">Genre</label>
                                        <input type="text" class="col-md-6"  name="genre" id="genre" placeholder="Enter genre..." required>
                                    </div>  
                                    <div class="form-group row">
                                    <label class="col-md-6" for="select-author">Author:</label>
                                    <select class="col-md-6"  name="authorId" id="select-author">
                                   <?php 
                                            $auhtors = selectAllAuthors($conn); 
                                            foreach($auhtors as $auth){?>
                                                <option value="<?php echo  $auth->_AuthorId; ?>"><?php echo $auth->_FirstName . ' ' .$auth->_LastName; ?></option>
                                    <?php   } ?>
                                    </select>
                                </div> 
                                    <div class="form-group row">
                                            <label class="col-md-6" for="input-published-book-on">Piblished on</label>
                                        <div class="input-group date col-md-6" id="input_publ_cont">
                                            <input type="text" name="publishedOn" id="publishedOn" value="<?php echo $currentDate; ?>" class="col-md-10" required=""/>
                                            <div class="input-group date col-md-2" id="input-added-book-on">                                                
                                            
                                                <div class="input-group-addon ">
                                                    <div class="input-group-text">
                                                        <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                                                    </div>
                                                </div>

                                            </div>
                                        </div> 
                                    </div> 
                                    <div class="form-group row">
                                        <label class="col-md-6" for="input-added-book-on">Added on</label>
                                        <div  class="input-group date col-md-6" id="input_add_cont">
                                        
                                        <input type="text" name="insertedOn" id="insertedOn" value="<?php echo $currentDate; ?>" class="col-md-10" required=""/>
                                        <div class="input-group date col-md-2" id="input-add-book-on">                                                
                                        
                                        <div class="input-group-addon ">
                                            <div class="input-group-text">
                                                <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <input type="hidden" class="editable-id" name="editable-id" value="" >
                                
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary btn-close" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary btn-submit">Save changes</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
           

   
        </div>
        </body>
</html>
<?php
$conn->close();
?>
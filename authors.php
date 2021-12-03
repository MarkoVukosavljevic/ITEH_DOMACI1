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


            <link rel="stylesheet" href="custom.css">
        </head>
        
        <body >
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
                                <a style="color: #fff !important;" href="/index.php">Books</a>
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
                        <button type="button" data-toggle="modal" data-target="#add_edit_Modal"   class="btn btn-info add-author btn-add"  >
                            Add author
                        </button> 
                    </div>
                    <table class="table ">
                        <thead>
                            <tr>
                                <td>
                                   <span> First name</span> 
                                </td>
                                <td>
                                    <span>  Last name</span> 
                                </td>
                                <td>
                                 <span>  Inserted date</span> 
                                </td>                                                              
                                <td>
                                
                                </td>
                            </tr>
                        </thead>
                        <tbody id="table-cont">

                            <?php 
                            
                            $authors = selectAllAuthors($conn) ;

                            //echo '<pre>' . print_r($students).'</pre>';
                                foreach($authors as $author)
                                { ?>
                                
                                    <tr class="tbl_row tr-<?php echo $author->_AuthorId; ?>" >
                                        
                                        <td>
                                            <span>  <?php echo $author->_FirstName; ?> </span> 
                                        </td>
                                        <td>
                                            <span> <?php echo $author->_LastName; ?> </span> 
                                        </td>
                                        <td>
                                            <span> 
                                            <?php 
                                                $dt = new DateTime($author->_InsertedOn);

                                                $date = $dt->format('m/d/Y');
                                                echo $date; 
                                                 ?>
                                            </span> 
                                        </td>
                                        
                                        <td>
                                            <span> 
                                                <button type="button" data-toggle="modal" data-target="#add_edit_Modal" data-id='<?php echo $author->_AuthorId; ?>' id='<?php echo $author->_AuthorId; ?>'  class="btn btn-info edit-book btn-edit editable <?php echo $author->_AuthorId; ?>"  >
                                                    Edit
                                                </button>                                           
                                                
                                                <button  id='<?php echo $author->_AuthorId; ?>'  class="btn btn-danger delete-author btn-delete <?php echo $author->_AuthorId; ?>"  >
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

                <div class="modal fade" id="add_edit_Modal" tabindex="-1" role="dialog" aria-labelledby="add_edit_ModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <form id="add-form" class="form col-md-12 " action="add_update_author.php"  method="POST"  >
                            <div class="modal-content">
                        
                                <div class="modal-header">
                                    <h5 class="modal-title" id="add_edit_ModalLabel">Add/Edit author</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                <div class="add-cont col-md-12">
                                         <?php $currentDate =  date('Y-m-d'); ?>
                                    
                                    
                                    <div class="form-group row">
                                        <label class="col-md-6" for="firstname">FirstName</label>
                                        <input type="text" class="col-md-6" name="firstname"  id="firstname" placeholder="Enter firstname..." required>
                                    </div>  
                                    <div class="form-group row">
                                        <label class="col-md-6" for="lastname">LastName</label>
                                        <input type="text" class="col-md-6"  name="lastname" id="lastname" placeholder="Enter lastname..." required>
                                    </div>  
                                    
                                    
                                    <div class="form-group row">
                                        <label class="col-md-6" for="input-added-author-on">Added on</label>
                                        <div  class="input-group date col-md-6" id="input_add_cont">
                                        
                                        <input type="text" name="insertedOn" id="insertedOn" value="<?php echo $currentDate; ?>" class="col-md-10" required=""/>
                                        <div class="input-group date col-md-2" id="input-add-author-on">                                                
                                        
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
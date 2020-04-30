<?php

    require('db.php');
    $id = $name = $cooking_time = $ingredients = $photo = $difficulty = $advices = "";

    function renderForm($id = '', $name = '', $cooking_time = '', $ingredients = '', $photo = '', $difficulty = '', $advices = "") {

        require('header.php');
        require('nav.php');

        ?>

        <div class="container">
            <div class="row mt-5">
                <div class="col text-center">
                    <h2>Formular</h2>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <form action="" method="post"  enctype="multipart/form-data">                      
                        <div class="modal-body">                        
                            <div class="row">
                                <?php // if ($id != '') { ?>
                                    <!--
                                    <input type="hidden" name="id" value="<?php //echo $id; ?>" >                                    
                                -->
                                <?php // } ?>
                                <div class="col">
                                    <div class="form-group row">
                                        <label class="col-sm-3 text-right" for="name">Nom de recette:</label>
                                        <input class="form-control col-sm-8" type="text" name="name" id="name" value="<?php echo($name) ?>">
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 text-right" for="cooking_time">Cooking_times:</label>
                                        <input class="form-control col-sm-8" type="text" name="cooking_time" id="cooking_time" value="<?php echo($cooking_time) ?>">
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 text-right" for="ingredients">Ingredients:</label>                    
                                        <textarea class="form-control col-sm-8" id="ingredients" rows="3" name="ingredients"><?php echo($ingredients) ?></textarea>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 text-right" for="uploaded_file">Votre photo</label>
                                        <input type="file" class="form-control-file col-sm-8" id="uploaded_file" name="uploaded_file">
                                    </div>                                       
                                    <div class="form-group row">
                                        <label class="col-sm-3 text-right" for="difficulty">Difficulty:</label>
                                        <input class="form-control col-sm-8" type="text" name="difficulty" id="difficulty" value="<?php echo($difficulty) ?>">
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 text-right" for="advice">Advice:</label>                    
                                        <textarea class="form-control col-sm-8" id="advice" rows="3" name="advices"><?php echo($advices) ?></textarea>                                                               
                                    </div>                                                                                          
                                    <div class="form-group row">
                                        <label class="col-sm-3 text-right" for="submit"></label>                                                    
                                        <button type="submit" id="submit" class="form-control col-sm-8 btn btn-primary" name="submit">Submit</button>                              
                                    </div>            
                                </div>            
                            </div>             
                        </div>
                    </form>
                </div>
            </div>
        </div>
    
        <?php 
            require('footer.php');
    }
    

    $id ="";
    $name = $cooking_time = $ingredients = $photo = $difficulty = $advices = "";

    /* edit record */
    if (isset($_GET['id'])) {   

        if (isset($_POST['submit'])) { 
            $id = $_GET['id'];
            $name = $_POST["name"];
            $cooking_time = $_POST["cooking_time"];
            $ingredients = $_POST["ingredients"];
            $photo = $_POST["uploaded_file"];
            $difficulty = $_POST["difficulty"];
            $advices = $_POST["advices"];
            
            $stmt = $pdo->prepare("UPDATE recipes SET name = :name, cooking_time = :cooking_time, ingredients = :ingredients, photo = :photo, difficulty = :difficulty, advices = :advices) VALUES (:name, :cooking_time, :ingredients, :photo, :difficulty, :advices WHERE id = :id");
            $stmt->execute([
                'name'          => $name, 
                'cooking_time'  => $cooking_time,
                'ingredients'   => $ingredients,
                'photo'         => $photo, 
                'difficulty'    => $difficulty, 
                'advices'       => $advices    
            ]);
            header("Location: http://localhost/index.php");
        
        } else {
            $id = $_GET['id'];
            if (is_numeric($_GET['id']) && $_GET['id'] > 0) {

                $stm = $pdo->query('SELECT * from recipes WHERE id ='.$id);
                $result = $stm->fetch();

                $name = $result["name"];
                $cooking_time = $result["cooking_time"];
                $ingredients = $result["ingredients"];
                $photo = $result["photo"];
                $difficulty = $result["difficulty"];
                $advices = $result["advices"];
                
                renderForm($id, $name, $cooking_time, $ingredients, $photo, $difficulty, $advices);

            } else {
                header("Location: http://localhost/index.php");
            }
        }
    
    /* add new record */
    } else {
            
        if (isset($_POST['submit'])) { 
           

            /*
            if(isset($_FILES['uploaded_file'])){
                $errors= array();
                $file_name = $_FILES['uploaded_file']['name'];
                $file_size =$_FILES['uploaded_file']['size'];
                $file_tmp =$_FILES['uploaded_file']['tmp_name'];
                $file_type=$_FILES['uploaded_file']['type'];
                $file_ext=strtolower(end(explode('.',$_FILES['uploaded_file']['name'])));
                
                $expensions= array("jpeg","jpg","png");
                
                if(in_array($file_ext,$expensions)=== false){
                   $errors[]="extension not allowed, please choose a JPEG or PNG file.";
                }
                
                if($file_size > 2097152){
                   $errors[]='File size must be excately 2 MB';
                }
                
                if(empty($errors)==true){
                   move_uploaded_file($file_tmp,"upload/".$file_name);
                   echo "Success";
                }else{
                   print_r($errors);
                }
            }
            */
            
            $uploaddir = 'upload/';            
            $uploadfile = $uploaddir . basename($_FILES['uploaded_file']['name']);
            $photo = null;
            if (move_uploaded_file($_FILES['uploaded_file']['tmp_name'], $uploadfile)) {
                $photo = $uploadfile;
            }
            $photo = $uploadfile;

            $name = htmlentities($_POST['name'], ENT_QUOTES);            
            $cooking_time = htmlentities($_POST['cooking_time'], ENT_QUOTES);
            $ingredients = htmlentities($_POST['ingredients'], ENT_QUOTES);
            //$photo = htmlentities($_POST['uploaded_file'], ENT_QUOTES);
            $difficulty = htmlentities($_POST['difficulty'], ENT_QUOTES);
            $advices = htmlentities($_POST['advices'], ENT_QUOTES);

            $stmt = $pdo->prepare("INSERT INTO recipes (name, cooking_time, ingredients, photo, difficulty, advices) VALUES (:name, :cooking_time, :ingredients, :photo, :difficulty, :advices)");
            $stmt->bindParam(':name', $name); 
            $stmt->bindParam(':cooking_time', $cooking_time);
            $stmt->bindParam(':ingredients', $ingredients);
            $stmt->bindParam(':photo', $photo); 
            $stmt->bindParam(':difficulty', $difficulty); 
            $stmt->bindParam(':advices', $advices);    
            $stmt->execute();

            header("Location: http://localhost/index.php"); 
            
        } else {
            renderForm();
        } 
    }

?>
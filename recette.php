<?php

    require('db.php');
    require('header.php');
    require('nav.php');

    $id ="";
    $name = $cooking_time = $ingredients = $photo = $difficulty = $advices = "";
    
    if (isset($_GET['id'])) {        
        $id = $_GET['id'];
        $stm = $pdo->query('SELECT * from recipes WHERE id ='.$id);
        $result = $stm->fetch();
        
        $name = $result['name'];
        $cooking_time =  $result['cooking_time'];
        $ingredients =  $result['ingredients'];
        $photo =  $result['photo'];
        $difficulty =  $result['difficulty'];
        $advices =  $result['advices'];

    } else {
        $id = null;
    }
?>

<div class="container">
    <div class="row d-flex flex-row justify-content-center align-items-center mt-5 mb-2">
        <div class="col text-center">
            <h1>RECETTES</h1>
        </div>    
    </div>
    <div class="row my-5">
        <div class="col">  
            <h2><?php echo($name); ?></h2>         
            <br><br>            
            <div class="row my-3">
                <div class="col-2">
                    <?php if ($photo!="" && $photo!=null) {?>
                        <img src="<?php echo($photo); ?>" alt="">                        
                    <?php } else {?>
                        <!-- No photo
                            <img src="<?php //echo($photo); ?>" alt="">                        
                        -->
                    <?php } ?>                    
                </div>
                <div class="col-10">
                    <strong>Cooking_time</strong>: <?php echo($cooking_time); ?> 
                    <br>
                    <strong>Ingredients</strong>: <?php echo($ingredients); ?> 
                    <br>
                    <strong>Difficulty</strong>: <?php echo($difficulty); ?>
                </div>
            </div>
            <div class="row my-3">
                <div class="col">
                    <strong>Advices</strong>: <?php echo($advices); ?>
                </div>
            </div>            
        </div>
    </div>
    <div class="row">
        <div class="col text-left">
            <a href="index.php" class="btn btn-primary mb-1"> Retournez à Home page </a>        
        </div>
    </div>
    <br><br>
</div>


<?php require('footer.php'); ?>
<?php   

require('db.php');
require('header.php');
require('nav.php');

$id = null;
$status = null;

$name = $cooking_time = $ingredients = $photo = $difficulty = $advices = "";
$limit = 10;
    
$res = $pdo->prepare("SELECT * FROM recipes");
$res->execute();
$allResp = $res->fetchAll(PDO::FETCH_ASSOC);
$total_results = $res->rowCount();
$total_pages = ceil($total_results/$limit);

if (!isset($_GET['page'])) {
    $page = 1;
} else{
    $page = $_GET['page'];
}
$start = ($page-1)*$limit;
$stmt = $pdo->prepare("SELECT * FROM recipes ORDER BY id DESC LIMIT $start, $limit");
$stmt->execute();

// set the resulting array to associative
$stmt->setFetchMode(PDO::FETCH_OBJ);
$results = $stmt->fetchAll();   
$conn = null;
$no = $page > 1 ? $start+1 : 1;

?>

<div class="container">
    <div class="row d-flex flex-row justify-content-center align-items-center mt-5 mb-2">
        <div class="col text-center">
            <h1>RECETTES</h1>
        </div>    
    </div>
    <div class="row">
        <div class="col-6 text-right">
            <input type="text" class="form-control" name="search">            
        </div>
        <div class="col-3 text-left">            
            <a href="formular.php" class="btn btn-secondary mb-1">Search</a>        
        </div>
        <div class="col-3 text-right">
        
        <a href="formular.php" class="btn btn-success mb-1"><i class="far fa-file" ></i> Ajouter</a>        
        </div>
    </div>
    <div class="row">
        <div class="col">           
            <table class="table table-hover table-bordered">
                <thead class="thead-dark border">
                    <tr>                            
                        <th>No.</th>
                        <th>Photo</th>                        
                        <th>Nom</th>
                        <th>Difficulte</th>
                        <th>Temps</th>                        
                        <th width="160px">Action</th>
                    </tr>
                </thead>
                <tbody> 
                    <?php foreach($results as $result){?>
                        <tr>
                            <td><?php echo ($no); ?></td>
                            <td><img src="<?php echo ($result->photo); ?>" width="100px" style="object-fit: cover;" alt=""></td>
                            <td> 
                                <a href="recette.php?id=<?php echo ($result->id); ?>">
                                    <?php echo ("<strong>" . $result->name . "</strong><br>"); ?>
                                </a>                                   
                                <?php echo ($result->ingredients); ?>                        
                            </td>
                            <td><?php echo ($result->difficulty); ?></td>
                            <td><?php echo ($result->cooking_time); ?></td>                                                        
                            <td>                                           
                                <a href=".php?id=<?php echo ($result->id); ?>" class="btn btn-primary mb-1"><i class="far fa-file-alt"></i></a>    
                                <a href="formular.php?id=<?php echo ($result->id); ?>" class="btn btn-warning mb-1"><i class="far fa-edit"></i></a>    
                                <a href="delete_recette.php?id=<?php echo ($result->id); ?>" class="btn btn-danger mb-1"><i class="far fa-trash-alt"></i></a>                                
                            </td>
                        </tr>
                    <?php $no++; } ?>
                </tbody>
            </table>        
        </div> 
    </div>   
    <div class="row">
        <div class="col text-center">
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center">
                    <li class="page-item"><a class="page-link" href="?page=1">Première page</a></li>
                    <?php for($p=1; $p<=$total_pages; $p++){?>                
                        <li class="page-item"><a class="page-link" href="<?= '?page='.$p; ?>"><?= $p; ?></a></li>
                    <?php }?>
                    <li class="page-item"><a class="page-link" href="?page=<?= $total_pages; ?>">Dernière page</a></li>
                </ul>
            </nav>
        </div>
    </div>
</div>

<?php require('footer.php'); ?>
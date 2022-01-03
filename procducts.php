<?php



include_once 'con.php';

$products = R::findAll('products');
?>

<html>
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>

<div class="container">
    <div class="row">
        <?php foreach ($products as $product){
       ?>
        <div class="col-md-4">
            <div class="card" style="width: 18rem;">
                <img class="card-img-top" src="<?= $product->image ?>"  onerror="this.onerror=null;this.src='images/default.jpg';" alt="Card image cap">
                <div class="card-body">
                    <h5 class="card-title"><?= $product->title ?></h5>
                    <a href="/detail/<?= $product->id ?>" class="btn btn-primary">Detail</a>
                </div>
            </div>
        </div>
        <?php }  ?>
    </div>
</div>


</body>
</html>

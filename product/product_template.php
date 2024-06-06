<?php
function displayProduct($product) {
    $productName = htmlspecialchars($product['productName']);
    $productDescription = htmlspecialchars($product['productDescription']);
    $productCategory = htmlspecialchars($product['productCategory']);
    $productStock = htmlspecialchars($product['productStock']);
    $productSize = htmlspecialchars($product['productSize']);
    $productDimensions = htmlspecialchars($product['productDimensions']);
    $productImage = base64_encode($product['productImage']); // Convertir l'image en base64 pour l'afficher
    ?>
    <div class="product">
        <div class="product-image">
            <img src="data:image/jpeg;base64,<?= $productImage ?>" alt="<?= $productName ?>">
        </div>
        <div class="product-details">
            <h2><?= $productName ?></h2>
            <p><strong>Catégorie :</strong> <?= $productCategory ?></p>
            <p><strong>Description :</strong> <?= $productDescription ?></p>
            <p><strong>Stock :</strong> <?= $productStock ?></p>
            <p><strong>Taille :</strong> <?= $productSize ?></p>
            <p><strong>Dimensions :</strong> <?= $productDimensions ?></p>
        </div>
    </div>
    <?php
}
?>
<style>
.product {
    border: 1px solid #ddd;
    padding: 16px;
    margin: 16px 0;
    display: flex;
    flex-direction: row;
}
.product-image img {
    max-width: 150px;
    max-height: 150px;
    object-fit: cover;
}
.product-details {
    margin-left: 16px;
}
.product-details h2 {
    margin: 0 0 8px 0;
}
.product-details p {
    margin: 4px 0;
}
</style>

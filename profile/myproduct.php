
<?php
if (!empty($products)) {
    foreach ($products as $product) {
        displayProduct($product); // Utiliser le template pour afficher chaque produit
    }
} else {
    echo "<p>Aucun produit trouvé.</p>";
}
?>

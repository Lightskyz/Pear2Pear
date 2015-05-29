<?php include("/modele/sessionStart.php"); ?>

<!DOCTYPE html>
<html lang="fr-FR">

	<head>
		<title>Achat - Pear2Pear</title>
		<?php include("../frames/head.php"); ?>
	</head>

	<body>
		<section class="hero">
			<?php include("../frames/menu.php"); ?>
				<section class="caption">
					<h2 class="caption">Quand le marché vient à vous</h2>
					<h3 class="properties">Fruits - Légumes à proximité de chez vous</h3>
				</section>
		</section><!--  end hero section  -->
			<?php include("../frames/search.php"); ?>

	<section class="listings">
		<div class="wrapper">
			<ul class="properties_list">

			<!-- trouver un moyen de faire un foreach et de les exposer en liste comme tel, récupérer des informations dans la base de données -->

				<li>
					<a href="#"><!-- lien vers le produit -->
						<img src="/assets/img/products/fraise.jpg" alt="" title="" class="property_img"/><!-- image du produit -->
					</a>
					<span class="price">ÉPUISÉ</span><!-- quantité ou prix du produit -->

					<div class="property_details">
						<h1>
							<a href="#">FRAISE</a> <!-- nom du produit -->
						</h1>
						<h2>Origine France<span class="property_size"></span></h2> <!-- détails/disponibilité du produit -->
					</div>
				</li>

				<li>
					<a href="#">
						<img src="/assets/img/products/framboise.jpg" alt="" title="" class="property_img" height="440px" width="300px"/>
					</a>
					<span class="price">ÉPUISÉ</span>
					<div class="property_details">
						<h1>
							<a href="#">FRAMBOISE</a>
						</h1>
						<h2>Origine France<span class="property_size"></span></h2>
					</div>
				</li>
				<li>
					<a href="#">
						<img src="/assets/img/products/aubergine.jpg" alt="" title="" class="property_img" height="440px" width="300px"/>
					</a>
					<span class="price">DISPO</span>
					<div class="property_details">
						<h1>
							<a href="#">AUBERGINE</a>
						</h1>
						<h2>Origine France <span class="property_size"></span></h2>
					</div>
				</li>
				
			</ul>
			<div class="more_listing">
				<a href="#" class="more_listing_btn">Voir plus</a>
			</div>
		</div>
	</section>	<!--  end listing section  -->

		<?php include("../frames/footer.php"); ?>

	</body>
					
</html>

<!-- Partie vu si et seulement si l'individu n'est pas connecté, à remplacer par le nom de l'utilisateur et sa photo lorsqu'il se connecte, trouver un moyen de faire apparaitre cette partie si et seulement si il n'est pas connecté sinon affiché le bon truc... Mettre du code php avec des if et echo je pense -->

<!-- Vue plutot pour les produits et non pas pour la page d'accueil -->

</html>

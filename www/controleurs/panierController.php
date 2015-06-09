<?php

/*	Payraudeau Maxime
	28/05/2015
	Version 1.0.1()
*/

/*	Fonction pour ajouter un nouveau produit au panier. 
	28/05/2015
	Version 1.0.1
*/
	function addpanier($user, $product, $quantite, $poids){	// Fonction pour ajouter un produit au panier

		include("../../modele/modele.php");  // Inclue la base de donnée + connexion.
		
		$sql = 'INSERT INTO detailcommande(id_product, id_user, quantite, poids) VALUES (:id_product , :id_user , :quantite , :poids) '; // Ajout d'une ligne dans la table detailCommande 
																													 // suivant les informations entrer dans la fonction panier.
		$reponse = $bdd->prepare($sql);			// Preparation de la requete SQL.
		$reponse -> bindParam(':id_product', $product);
		$reponse -> bindParam(':id_user', $user);
		$reponse -> bindParam(':quantite', $quantite);
		$reponse -> bindParam(':poids', $poids);
		$reponse ->execute();					// Execution de la requete SQL.

		$sql3 = 'SELECT * FROM detailcommande WHERE id_product = "'.$product.'" AND id_user ="'.$user.'" AND quantite ="'.$quantite.'" AND poids="'.$poids.'" ';
		$reponse3 = $bdd->query($sql3);
		while ($donnees = $reponse3 -> fetch())		// Mise en forme de tableau.
			{
				$id_detailCommande = $donnees['id'];
				$sql2 = 'INSERT INTO commande(id_user, id_detailCommande, date) VALUES (:id_user, :id_detailCommande, CURDATE())'; 	// Ajout d'une ligne dans la table commande
																																		// suivant les informations d'entrées
																																		// Ajout date ???
				$reponse2 = $bdd->prepare($sql2);
				$reponse2 -> bindParam(':id_user', $user);
				$reponse2 -> bindParam(':id_detailCommande', $id_detailCommande);
				$reponse2 ->execute();
			}
	}

/*	Fonction pour supprimer un produit du panier. 
	28/05/2015
	Version 1.0.1
*/
	function deletepanier($user, $product){		// Fonction pour supprimer un produit du panier

		include("../../modele/modele.php");

		$sql = 'SELECT * FROM detailcommande WHERE id_product= "'.$product.'" AND id_user= "'.$user.'" ';
		$reponse = $bdd->query($sql);
		
		while ($donnees = $reponse->fetch())
		{
			$sql2 = 'DELETE FROM commande WHERE id_user = "'.$user.'" AND id_detailCommande = "'.$donnees['id'].'"  ';
			$reponse2 = $bdd->prepare($sql2);
			$reponse2 ->execute();
		}
		$sql3 = 'DELETE FROM detailcommande WHERE id_product= "'.$product.'" AND  id_user= "'.$user.'" ';
		$reponse3 = $bdd->prepare($sql3);
		$reponse3 ->execute();

	}

/*	Fonction pour changer une quantite sur un produit. 
	28/05/2015
	Version 1.0.1
*/
	function updatepanier($user, $product, $quantite, $poids){ 		// Fonction pour update la quantite d'un produit au panier

		include("../../modele/modele.php");

		$sql = 'UPDATE `detailcommande` SET `quantite`='.$quantite.', `poids`='.$poids.' WHERE id_user='.$user.' AND id_product='.$product.' '; 
		$reponse = $bdd->prepare($sql);
		$reponse ->execute();
	}

/*	Fonction pour affiche de panier. 
	28/05/2015
	Version 1.0.1
*/
	function affichepanier($user){		// Fonction pour afficher l'ensemble des produits du panier

		include("../../modele/modele.php");

		$sql = 'SELECT * FROM commande WHERE id_user="'.$user.'" ';
		$reponse = $bdd->query($sql);
		while ($donnees = $reponse->fetch())
		{
			$detailCommande = $donnees['id_detailCommande'];
			$sql2 ='SELECT * FROM detailcommande WHERE id_user = "'.$user.'" AND id = "'.$detailCommande.'" ';
			$reponse2 = $bdd->query($sql2);
			while ($donnees2 = $reponse2->fetch())
			{
				$product = $donnees2['id_product'];
				$sql3 ='SELECT * FROM produit WHERE id="'.$product.'" ';
				$reponse3 = $bdd->query($sql3);
				while ($donnees3 = $reponse3->fetch())
				{
					$id_user=$donnees3['id_user'];
					$sql4 ='SELECT * FROM user WHERE id="'.$id_user.'" ';
					$reponse4 = $bdd->query($sql4);
					while ($donnees4 = $reponse4->fetch())
					{
						$id_categorie = $donnees3['id_categorie'];
						$sql5 ='SELECT * FROM categorie WHERE id="'.$id_categorie.'" ';
						$reponse5 = $bdd->query($sql5);
						while ($donnees5 = $reponse5->fetch())
						{
							$data = $donnees2['quantite'];
							$data2 = $donnees2['poids'];
							?>
							<form action="<?php echo "panier.php?product=".$product." "; ?> " method="POST">			<!-- On cree un formulaire qui permet de changer le nombre de produit acheter ou de delete cet item au panier -->
								<input type="number" name="quantite" step="1" placeholder="<?php echo $data; ?>" min="0" />
								<input type="number" name="poids" step="1" placeholder="<?php echo $data2; ?>" min="0" />
									<?php echo $donnees4['nom'].' '.$donnees4['prenom'].' '.$donnees5['nom'].' '.$donnees3['prix']; ?>
								<input type="submit" name="changer" value="Valider">
								<input type="submit" name="changer" value="Delete" />
							</form> </br> 
							<?php 			
						}
					}
				}
			}
		}
	}
?>
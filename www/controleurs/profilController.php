<?php
/*

*/
function afficheprofil($user){

	include("../../modele/modele.php");

	$sql = 'SELECT * FROM user WHERE email = "'.$user.'" ';
	$req = $bdd-> query($sql);
	while( $donnees = $req -> fetch())
	{
	 // Association des variable retourner par la bdd aux variables de session
		$_SESSION["id"]=$donnees["id"];
		$_SESSION["nom"]=$donnees["nom"];
		$_SESSION['prenom'] = $donnees["prenom"];
		$_SESSION['email'] = $donnees["email"];
		$_SESSION['born'] = $donnees["born"];
		$_SESSION['adresse'] = $donnees["adresse"];
		$_SESSION['cdp'] = $donnees["cdp"];
		$_SESSION['ville'] = $donnees["ville"];
		$_SESSION['telephone'] = $donnees["telephone"];
		$_SESSION['image'] = $donnees['image'];
		$_SESSION['isAdmin'] = $donnees["isAdmin"];
		$_SESSION['mdp'] = $donnees['mdp'];
		$_SESSION['age'] = floor((time() - strtotime($_SESSION['born']))/3600/24/365);

	}
}

function afficheAnnonce($user){

	include("../../modele/modele.php");

	$sql = 'SELECT * FROM produit WHERE id_user LIKE "%'.$user.'%" ORDER BY id DESC';
	$reponse = $bdd->query($sql);
	while ($donnees = $reponse->fetch())
	{
		if(($donnees['quantite'] == 0) && ($donnees['poids'] == 0)){
 
		} else {
			$sql2 = 'SELECT * FROM categorie WHERE id ="'.$donnees['id_categorie'].'" ';
			$reponse2 = $bdd->query($sql2);
			while ($donnees2 = $reponse2->fetch())
			{	
				$sql3 = 'SELECT * FROM user WHERE id ="'.$donnees['id_user'].'" ';
				$reponse3 = $bdd->query($sql3);
				while ($donnees3 = $reponse3->fetch())
				{
					$data = $donnees['id'];
					$url = '../../back/profil.php?product='.$data.' ' ;
					?>
					 <div class="bandeleteuser">
	   					<form action="<?php echo $url; ?>" method="POST">			<!-- On cree un formulaire qui permet de changer le nombre de produit acheter ou de delete cet item au panier -->
							<?php echo"<p  style='position:absolute; top:0; left:0;  padding:10px; color:white; float:left; font-size: 0.9em; font-weight: 500; text-align:left; letter-spacing: .1em; color:white; '>Vendeur : ".$donnees3['nom'].$donnees3['prenom']."<br />Categorie : ".$donnees2['nom']."<br />Prix : ".$donnees['prix']." <br />Quantité : ".$donnees['quantite']."</p>"; ?>
							<button type="submit" class="buttonProduit" name="changer" value="Supprimer" >Supprimer</button>
						</form>
					</div>
					<?php
				}
			}
		}
	}
	$reponse->closeCursor(); 
}

function deleteAnnonce($user, $product ){

	include("../../modele/modele.php");

		$sql = 'SELECT * FROM produit WHERE id_user= "'.$user.'" AND id= "'.$product.'" ';
		$reponse = $bdd->query($sql);
		
		while ($donnees = $reponse->fetch())
		{
			$sql2 = 'SELECT * FROM detailCommande WHERE id_user= "'.$user.'" AND id= "'.$product.'" AND actif = 1 ';
			$reponse2 = $bdd->query($sql2);
		
			while ($donnees2 = $reponse->fetch())
			{
				$id_detailCommande = $donnees2['id'];
				
				$sql3 = 'DELETE FROM commande WHERE id_user = "'.$user.'" AND id_detailCommande = "'.$id_detailCommande.'"  AND actif = 1 ';
				$reponse3 = $bdd->prepare($sql3);
				$reponse3 ->execute();
			}
			$sql4 = 'DELETE FROM detailCommande WHERE id_user = "'.$user.'" AND id = "'.$product.'"  AND actif = 1 ';
			$reponse4 = $bdd->prepare($sql4);
			$reponse4 ->execute();
				
		}
		$sql5 = 'DELETE FROM produit WHERE id= "'.$product.'" AND  id_user= "'.$user.'" ';
		$reponse5 = $bdd->prepare($sql5);
		$reponse5 ->execute();
}

function sedesincrire($user){

	include("../../modele/modele.php");

	$sql2 = 'SELECT * FROM produit WHERE id_user= "'.$user.'"  ';
	$reponse2 = $bdd->query($sql2);
	while ($donnees2 = $reponse->fetch())
	{
		deleteAnnonce($user, $donnees2['id']);
	}

	$sql = 'DELETE FROM user WHERE id= "'.$user.'"  ';
	$reponse = $bdd->prepare($sql);
	$reponse ->execute();
}
?>
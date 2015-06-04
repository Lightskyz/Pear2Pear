<?php

/* Maxime Payraudeau 
    28/05/2015
    Version 1.0.0
*/	

/* 
	Affiche les différents forums.
	28/05/2015
	Version 1.0.1
*/

function affichage_forum(){
	include("../../modele/modele.php");
	$sql = ' SELECT * FROM forum ORDER BY id ASC ';
	$req = $bdd -> query($sql);
	while($donnees = $req -> fetch() ){
		//Vue des forum existants !
		echo "<a href='../front/forum.php?forum=".$donnees['id']." ''><div class='forum'><p class='titre'>".$donnees['nom']."</p></br><p class='description'>".$donnees['description']."</p></div></a>" ;

	}
}

/* 
	Affiche les topic relatif au forum.
	28/05/2015
	Version 1.0.1
*/

function affichage_topic($forum){
	include("../../modele/modele.php");
	echo "<a href='../front/forum.php'><span class='accueil'>Accueil du forum</span></a></br>" ;
	$sql = ' SELECT * FROM topic WHERE id_forum = '.$forum.' ORDER BY nom ASC ';
	$req = $bdd -> query($sql);
	while($donnees = $req -> fetch() ){
		//Vue des topics dans un topic

		echo "<a href='../front/forum.php?forum=".$forum."&topic=".$donnees['id']." ''><div class='forum'><p class='titre'>".$donnees['nom']."</p><p class='description'>".$donnees['contenu']."</p></div></a>" ;
	}
	echo "<a href='../front/forum.php'><button class='button button-block2'>Retour</button></a></br>" ;
}

/* 
	Affiche les message relatif au topic.
	28/05/2015
	Version 1.0.1
*/

function affichage_message($forum, $topic){
	echo "<a href='../front/forum.php'><span class='accueil'>Accueil du forum</span></a></br>" ;
	include("../../modele/modele.php");
	$sql = ' SELECT * FROM message WHERE id_topic = '.$topic.' ORDER BY date ASC ';
	$req = $bdd -> query($sql);
	while($donnees = $req -> fetch() ){
		$user = $donnees['id_user'];
		$sql2 = ' SELECT * FROM user WHERE id = '.$user.' ';
		$req2 = $bdd -> query($sql2);
		while($donnees2 = $req2 -> fetch() ){
			//Vue des message dans un topic ! (avec le nom de l'auteur)

			//Données de l'utilisateur qui poste (récupérer la photo si possible)
		echo "<div class='reponse'><div class='auteur tout'>".$donnees2['nom']." ".$donnees2['prenom']." </div><div class='message tout'>".$donnees['message']."</div></div>";
		}
		$id = $donnees['id'];
		echo'<hr>'
		?>

		<!-- Test à faire, si erreur alors c'est due au chemin -->

		<form action="<?php echo "forum.php?forum=".$forum."&topic=".$topic."&delete=".$id." "; ?> " method="POST">
			<input type="submit" name="changer" value="Delete" />
		</form>
		<?php
	}
	echo "<a href='../front/forum.php?forum=".$_GET['forum']." ''><button class='button button-block2'>Retour</button></a></br>" ;
}

/* 
	Ajout les messages d'un utilisateur.
	28/05/2015
	Version 1.0.1
*/

function affichage_mes_messages($user){
	echo "<a href='../front/forum.php'><span class='accueil'>Accueil du forum</span></a><br /><br /><hr>" ;
	include("../../modele/modele.php");
	$sql = ' SELECT * FROM message WHERE id_user = '.$user.' ORDER BY date ASC ';
	$req = $bdd -> query($sql);
	while($donnees = $req -> fetch() ){
		$sql2 = ' SELECT * FROM topic WHERE id = '.$donnees['id_topic'].' ';
		$req2 = $bdd -> query($sql2);
		while($donnees2 = $req2 -> fetch() ){
			$sql3 = ' SELECT * FROM forum WHERE id = '.$donnees2['id_forum'].' ';
			$req3 = $bdd -> query($sql3);
			while($donnees3 = $req3 -> fetch() ){

				//Récupérer le topic tout en haut pour savoir à quoi il reponde sinon inutile ...

				//Tous les messages que l'utilisateur à écrit (récupérer nom du forum et du topic sur lequel il a posté)

				echo " Forum ".$donnees3['nom']." Topic ".$donnees2['nom']." Message ".$donnees['message']." 
				<a href='../front/forum.php?forum=".$donnees3['id']."&topic=".$donnees2['id']." '> Accéder au topic </a></br>"; 
			}
		}
	}
}

/* 
	Ajout d'un message.
	28/05/2015
	Version 1.0.1
*/

function post_message($user, $forum, $topic){
	include("../../modele/modele.php");
	if(!empty($_POST['message'])) {
		$message = $_POST['message'];
				$message = $_POST['message'];
				$sql = 'INSERT INTO `message`(`id_topic`, `id_user`, `date`, `message`) VALUES (:id_topic, :id_user, NOW() ,:message)';
				$req = $bdd->prepare($sql);
				$req -> bindParam(':id_user' , $user );
				$req -> bindParam(':id_topic' , $topic );
				$req -> bindParam(':message' , $message );
				$req->execute();
			echo " Veuillez actualiser votre page web.";
			}
}

/* 
	Ajout d'un topic.
	28/05/2015
	Version 1.0.1
*/

function ajout_topic($forum){
	include("../../modele/modele.php");
	$nom = $_POST['nom'];
	$contenu = $_POST['contenu'];
	$sql = 'INSERT INTO `topic`(`id_forum`, `nom`, `contenu`) VALUES (:id_forum,:nom,:contenu)';
				$req = $bdd->prepare($sql);
				$req -> bindParam(':id_forum' , $forum );
				$req -> bindParam(':nom' , $nom );
				$req -> bindParam(':contenu' , $contenu );
				$req -> execute(); 
}

/*
	Supprimer un commentaire 
	04/06/2015
*/
function delete_message($user, $id){
	include("../../modele/modele.php");
	$sql = 'SELECT id_user FROM message ';
	$req = $bdd -> query($sql);
	while($donnees = $req -> fetch()){
		if( $user == $donnees['id_user'] ){
			$sql2 = 'DELETE FROM message WHERE id = "'.$id.'" AND id_user="'.$user.'" ';
			$req2 = $bdd -> prepare($sql2);
			$req2 -> execute();
		} else if( $_SESSION['isAdmin'] == '1' ){
			$sql2 = 'DELETE FROM message WHERE id = "'.$id.'" ';
			$req2 = $bdd -> prepare($sql2);
			$req2 -> execute();
		}
	}
}
?>
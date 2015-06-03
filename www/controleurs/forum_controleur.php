<?php
/* 
	Maxime Payraudeau
	28/05/2015
	Version 1.0.1
*/

/* 
	Affiche les différents forums.
	28/05/2015
	Version 1.0.1
*/

function affichage_forum(){
	include("modele.php");
	$sql = ' SELECT * FROM forum ORDER BY id ASC ';
	$req = $bdd -> query($sql);
	while($donnees = $req -> fetch() ){
		echo "<a href='forum_vue.php?forum=".$donnees['id']." ''>".$donnees['nom']."</a></br>" ;

	}
}

/* 
	Affiche les topic relatif au forum.
	28/05/2015
	Version 1.0.1
*/

function affichage_topic($forum){
	include("modele.php");
	echo "<a href='forum_vue.php'>Acceuil</a></br>" ;
	$sql = ' SELECT * FROM topic WHERE id_forum = '.$forum.' ORDER BY nom ASC ';
	$req = $bdd -> query($sql);
	while($donnees = $req -> fetch() ){
		echo "<a href='forum_vue.php?forum=".$forum."&topic=".$donnees['id']." ''>".$donnees['nom']."</a></br>" ;
	}
	echo "<a href='forum_vue.php'>Retour</a></br>" ;
}

/* 
	Affiche les message relatif au topic.
	28/05/2015
	Version 1.0.1
*/

function affichage_message($forum, $topic){
	echo "<a href='forum_vue.php'>Acceuil</a></br>" ;
	include("modele.php");
	$sql = ' SELECT * FROM message WHERE id_topic = '.$topic.' ORDER BY date ASC ';
	$req = $bdd -> query($sql);
	while($donnees = $req -> fetch() ){
		$user = $donnees['id_user'];
		$sql2 = ' SELECT * FROM user WHERE id = '.$user.' ';
		$req2 = $bdd -> query($sql2);
		while($donnees2 = $req2 -> fetch() ){
			echo " ".$donnees2['nom']." ".$donnees2['prenom']." ";
		}
		echo " ".$donnees['message']." </br> ";
	}
	echo "<a href='forum_vue.php?forum=".$_GET['forum']." ''>Retour</a></br>" ;
}

/* 
	Ajout les messages d'un utilisateur.
	28/05/2015
	Version 1.0.1
*/

function affichage_mes_messages($user){
	echo "<a href='forum_vue.php'>Acceuil</a></br>" ;
	include("modele.php");
	$sql = ' SELECT * FROM message WHERE id_user = '.$user.' ORDER BY date ASC ';
	$req = $bdd -> query($sql);
	while($donnees = $req -> fetch() ){
		$sql2 = ' SELECT * FROM topic WHERE id = '.$donnees['id_topic'].' ';
		$req2 = $bdd -> query($sql2);
		while($donnees2 = $req2 -> fetch() ){
			$sql3 = ' SELECT * FROM forum WHERE id = '.$donnees2['id_forum'].' ';
			$req3 = $bdd -> query($sql3);
			while($donnees3 = $req3 -> fetch() ){
				echo " Forum ".$donnees3['nom']." Topic ".$donnees2['nom']." Message ".$donnees['message']." 
				<a href='forum_vue.php?forum=".$donnees3['id']."&topic=".$donnees2['id']." '> Accéder au topic </a></br>"; 
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
	include("modele.php");
	if(!empty($_POST['message'])) {
		$message = $_POST['message'];
				$message = $_POST['message'];
				$sql = 'INSERT INTO `message`(`id_topic`, `id_user`, `date`, `message`) VALUES (:id_topic, :id_user, NOW() ,:message)';
				$req = $bdd->prepare($sql);
				$req -> bindParam(':id_user' , $user );
				$req -> bindParam(':id_topic' , $topic );
				$req -> bindParam(':message' , $message );
				$req->execute();
			}
}

/* 
	Ajout d'un topic.
	28/05/2015
	Version 1.0.1
*/

function ajout_topic($forum){
	include("modele.php");
	$nom = $_POST['nom'];
	$contenu = $_POST['contenu'];
	$sql = 'INSERT INTO `topic`(`id_forum`, `nom`, `contenu`) VALUES (:id_forum,:nom,:contenu)';
				$req = $bdd->prepare($sql);
				$req -> bindParam(':id_forum' , $forum );
				$req -> bindParam(':nom' , $nom );
				$req -> bindParam(':contenu' , $contenu );
				$req -> execute(); 
}

?>
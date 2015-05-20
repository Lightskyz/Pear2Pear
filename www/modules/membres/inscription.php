<?php

/* Question : 
	- Ou appelle-t-on notre base de données ?
	- Table "user"
	- 

*/


// Ne pas oublier d'inclure la librairie Form
include CHEMIN_LIB.'form.php';

//"formulaire_inscription" est l'ID unique du formulaire
$form_inscription = new Form('formulaire_inscription');

$form_inscription->methode('POST');

$form_inscription->add('Text','nom_utilisateur')
				 ->label("Votre nom d'utilisateur");

$form_inscription->add('Password', 'mdp')
				 ->label("Votre mot de passe");

$form_inscription->add('Password','mdp_verif')
				 ->label("Votre mot de passe (verification)");

$form_inscription->add('Email','adresse_email')
				 ->label("Votre adresse email");

$form_inscription->add('File','avatar')
				 ->filter_extensions('jpg','png','gif')
				 ->max_size(8192) //8Kb
				 ->label("Votre avatar (facultatif)");
				 -> Required(false);

$form_inscription->add('Submit','submit')
			   	 ->value("Je veux m'inscrire !");

//Pré-remplissage avec les valeurs precedemment entrées (s'il y en a)
$form_inscription->bound($_POST);

include CHEMIN_VUE.'formulaire_inscription.php';
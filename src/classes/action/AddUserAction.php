<?php
declare(strict_types=1);

namespace iutnc\deefy\action;

class AddUserAction extends Action {
   
    public function execute() : string {
		$html = 'Créer un utilisateur : <br>';
		if ($this->http_method === 'GET') {
			$html .= <<<FIN
				<form method="post" action="?action=add-user">
					<input type="text" name="nom_user" placeholder="nom">
					<input type="email" name="email_user" placeholder="email">
					<input type="number" name="age_user" placeholder="age">
					<button type="submit">Ajouter le user</button>
				</form>
			FIN;
		
		} else {
			$nom_user = filter_var($_POST['nom_user'], FILTER_SANITIZE_SPECIAL_CHARS);
			
			if (!filter_var($_POST['email_user'], FILTER_VALIDATE_EMAIL)) {
				$html .= "email invalide<br>";
			}
			$email_user = filter_var($_POST['email_user'], FILTER_SANITIZE_EMAIL);
			
			if (!filter_var($_POST['age_user'], FILTER_VALIDATE_INT)) {
				$html .= "age invalide<br>";
			}
			$age_user = filter_var($_POST['age_user'], FILTER_SANITIZE_NUMBER_INT);
			
			$_SESSION['users'][] = [$nom_user, $email_user, $age_user];
			$html .= "Bienvenue $nom_user, $email_user, $age_user !";
		}
		return $html;
	}
    
}
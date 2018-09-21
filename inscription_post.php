
<?php

include('database_access.php');

$pseudo = htmlspecialchars($_POST['pseudo']);
$pass = htmlspecialchars($_POST['pass']);
$pass_confirmation = htmlspecialchars($_POST['pass_confirmation']);
$email = htmlspecialchars($_POST['email']);
$pass_hache = password_hash($_POST['pass'], PASSWORD_DEFAULT);


$reponse = $bdd->prepare('SELECT pseudo FROM membres WHERE pseudo = :pseudo');
$reponse->execute(array(
  'pseudo' => $pseudo
));

$donnees = $reponse->fetch();

if ($donnees['pseudo'] == $pseudo) {
  echo "Veuillez choisir un autre pseudo";
  header('refresh:2;url=inscription.php');
}else {
  if (isset($pseudo) AND !empty($pseudo) AND isset($pass) AND !empty($pass) AND isset($pass_confirmation) AND !empty($pass_confirmation)
  AND isset($email) AND !empty($email) AND preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#", $email) AND ($pass == $pass_confirmation)){

    $req = $bdd->prepare('INSERT INTO membres (pseudo, pass, email) VALUES(:pseudo, :pass, :email)');
    $req->execute(array(
        'pseudo' => $pseudo,
        'pass' => $pass_hache,
        'email' => $email,
        ));

    // Insertion of  product informations in database
    echo "Merci pour votre inscription, veuillez vous connecter";
    header('refresh:2;url=index.php');

  }
  elseif ( empty($pseudo) OR empty($pass) OR empty($pass_confirmation) OR empty($email)) {
    echo 'Merci de remplir tous les champs !.';
    header('refresh:2;url=inscription.php');
  }
  elseif ($pass != $pass_confirmation) {
    echo "Resaisissez le(s) mots de passe !";
    header('refresh:2;url=inscription.php');
  }
  elseif (!preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#", $email)) {
    echo "L'email est incorrect !";
    header('refresh:2;url=inscription.php');
  }
}

?>

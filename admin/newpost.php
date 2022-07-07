<?php
require('../inc/fonction.php');

require('../inc/pdo.php');


include('inc/header-back.php');?>

<?php
$success = false;
$errors = array();
if(!empty($_POST['submitted'])) {
    // Faille XSS
    $title = trim(strip_tags($_POST['title']));
    $content = trim(strip_tags($_POST['content']));
    $auteur = trim(strip_tags($_POST['auteur']));
    $statu = trim(strip_tags($_POST['statu']));
    // Validation
    $errors = validText($errors,$title,'title',3,100);
    $errors = validText($errors,$content,'content',10,1000);
    $errors = validText($errors,$auteur,'auteur',3,100);
    $errors = validText($errors,$statu,'statu',3,20);

    if(count($errors) === 0) {
        // insertion en BDD si aucune error
        $sql = "INSERT INTO articles (title,content,auteur,created_at,modified_at,statu) VALUES (:title,:content,:auteur,:statu,NOW())";
        $query = $pdo->prepare($sql);
        // ATTENTION INJECTION SQL
        $query->bindValue(':title',$title, PDO::PARAM_STR);
        $query->bindValue(':content',$content, PDO::PARAM_STR);
        $query->bindValue(':auteur',$auteur, PDO::PARAM_STR);
        $query->bindValue(':statu',$statu, PDO::PARAM_STR);
        $query->execute();
        $last_id = $pdo->lastInsertId();
        header('Location: index.php?id=' . $last_id);
//        $success = true;
    }
}?>


<form action="" method="post" novalidate class="wrap2">
        <label for="title">Titre</label>
        <input type="text" name="title" id="title" value="<?php if(!empty($_POST['title'])) { echo $_POST['title']; } ?>">
        <span class="error"><?php if(!empty($errors['title'])) { echo $errors['title']; } ?></span>

        <label for="content">Contenu</label>
        <textarea name="content" id="content" cols="30" rows="10"><?php if(!empty($_POST['content'])) { echo $_POST['content']; } ?></textarea>
        <span class="error"><?php if(!empty($errors['content'])) { echo $errors['content']; } ?></span>

        <label for="auteur">Auteur</label>
        <input type="text" name="auteur" id="auteur" value="<?php if(!empty($_POST['auteur'])) { echo $_POST['auteur']; } ?>">
        <span class="error"><?php if(!empty($errors['auteur'])) { echo $errors['auteur']; } ?></span>

        <label for="statu">Status</label>
        <input type="text" name="statu" id="statu" value="<?php if(!empty($_POST['statu'])) { echo $_POST['statu']; } ?>">
        <span class="error"><?php if(!empty($errors['statu'])) { echo $errors['statu']; } ?></span>

        <input type="submit" name="submitted" value="Ajouter articles">
    </form>



 <?php include('inc/footer-back.php');
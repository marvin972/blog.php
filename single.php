<?php
require('inc/pdo.php');
require('inc/request.php');
require('inc/fonction.php');


if(!empty($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];
    $article = getArticles($id);
    if(empty($article)) {
        // header('Location: 404.php');
    }
} else {
    //die('404');
    // header('Location: 404.php');
}

$sql = "SELECT * FROM comments WHERE id_articles = :id";
$query = $pdo->prepare($sql);
$query->bindValue(':id',$id,PDO::PARAM_INT);
$query->execute();
$comments = $query->fetchAll();

//debug($comments);

$errors = [];
if(!empty($_POST['submitted'])) {
    $auteur = cleanXss('auteur');
    $content = cleanXss('content');
    $errors = validText($errors,$auteur,'auteur',3, 40);
    $errors = validText($errors,$content,'content',3,2000);
    if(count($errors) == 0) {
        $sql = "INSERT INTO comments (id_articles,content, auteur, created_at,modified_at,status)
            VALUES (:id_articles,:content,:auteur,NOW(),NOW(),'new')";
        $query = $pdo->prepare($sql);
        $query->bindValue(':auteur',$auteur,PDO::PARAM_STR);
        $query->bindValue(':content',$content,PDO::PARAM_STR);
        $query->bindValue(':id_articles',$id,PDO::PARAM_INT);
        $query->execute();
        header('Location: single.php?id='.$id);
        exit();
    }
}




include('inc/header.php'); ?>
   <div class="wrap">
    <div class="one_article">
        <h2 style="font-weight: bold; text-align: center;"><?= $article['title']; ?></h2>
        <p><?= nl2br($article['content']); ?></p>
        <p>Author: <?= $article['auteur']; ?></p>
        <p>Publié le : <?= dateSite($article['created_at']); ?></p>
        <?php if($article['created_at'] !== $article['modified_at']) { ?>
            <p>Modifié le : <?= dateSite($article['modified_at']); ?></p>
        <?php } ?>
    </div>

    <h2>Ajouter un commentaire</h2>
    <form action="" method="post" class="wrap2">
        <label for="auteur">Auteur *</label>
        <input type="text" id="auteur" name="auteur" value="<?= getValue('auteur'); ?>">
        <span class="error"><?= getError($errors,'auteur'); ?></span>

        <label for="content">Commentaire *</label>
        <textarea name="content"><?= getValue('content'); ?></textarea>
        <span class="error"><?= getError($errors,'content'); ?></span>

        <input type="submit" name="submitted" value="Ajouter">
    </form>

    <?php if(!empty($comments)) { ?>
        <h2>Les commentaire</h2>
        <?php foreach ($comments as $comment) { ?>
            <div class="comment">
                <p>Auteur : <?= $comment['auteur']; ?></p>
                <p><?= $comment['content']; ?></p>
                <hr>
            </div>
        <?php } ?>
    <?php } ?>
</div>


<?php include('inc/footer.php');
<?php
require('../inc/fonction.php');
require('../inc/pdo.php');
require('../inc/request.php');




$articles = getAllArticles(3, 'ASC');
// debug($articles);

include('inc/header-back.php');?>

<h1>Liste Articles</h1>

<ul>
    <?php foreach($articles as $article) {
 ?>
    <li>
        <p><strong>ID : </strong><?php echo $article['id']; ?>
        </p>
        <h2><?php echo ucfirst($article['title']); ?></h2>
        <p><strong>Contenus : </strong><?php echo nl2br($article['content']); ?></p>
        <p><strong>Auteur : </strong><?php echo nl2br($article['auteur']); ?></p>
        <p><strong>Status : </strong><?php echo nl2br($article['statu']); ?></p>

        <p><strong>Date de création : </strong><?php echo date('d/m/Y à H:i:s', strtotime($article['created_at'])); ?>
        </p>

        <p><strong>Date modifier : </strong><?php echo date('d/m/Y à H:i:s', strtotime($article['modified_at'])); ?></p>


        <a href="editPost.php?id=<?php echo $article['id']; ?>">Modifier</a>

        <a href="deletePost.php?id=<?php echo $article['id']; ?>">Supprimer</a>


        <?php if ($article['statu'] == 'publish') { ?>
        <a href="depublierPost.php?id=<?php echo $article['id']; ?>">Dépublier</a><?php } ?>

        <?php if ($article['statu'] !== 'publish') { ?>
        <a href="publishedPost.php?id=<?php echo $article['id']; ?>">Publier</a><?php } ?>
    </li>
    <?php } ?>
</ul>
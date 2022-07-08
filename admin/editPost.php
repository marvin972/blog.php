<?php
require('../inc/fonction.php');
require('../inc/pdo.php');
require('../inc/request.php');




if(!empty($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];
    $sql_edit_articles = "SELECT * FROM articles WHERE id = :id";
    $query = $pdo->prepare($sql_edit_articles);
    $query->bindValue(':id',$id, PDO::PARAM_INT);
    $query->execute();
    $article = $query->fetch();
    

$errors = [];
if(!empty($_POST['submitted'])) {

    $title = cleanXss('title');
    $content= cleanXss('content');
    $auteur = cleanXss('auteur');
    $statu = cleanXss('statu');
    

    $errors = validText($errors,$title,'title',3,100);
    $errors = validText($errors,$content,'content',10,1000);
    $errors = validText($errors,$auteur,'auteur',3,100);
    $errors = validText($errors,$statu,'statu',3,20);

    if(count($errors) === 0) {

        $sql = "UPDATE articles SET title = :title,content = :content,auteur = :auteur,statu = :statu, modified_at = NOW() WHERE id = :id";
        $query = $pdo->prepare($sql);
        $query->bindValue(':title',$title,PDO::PARAM_STR);
        $query->bindValue(':auteur',$auteur,PDO::PARAM_STR);
        $query->bindValue(':content',$content,PDO::PARAM_STR);
        $query->bindValue(':statu',$statu,PDO::PARAM_STR);
        $query->bindValue(':id',$id,PDO::PARAM_INT);
        $query->execute();
        header('Location: listingPost.php');
       $success = true;

    }
}
}







include('inc/header-back.php');?>
<h1>Modifier un article</h1>
<form action="" method="post" novalidate class="wrap2">
    <label for="title">Titre</label>
    <input type="text" name="title" id="title" value="<?=getValue('title',$article['title'])?>">
    <span class="error"><?php if(!empty($errors['title'])) { echo $errors['title']; } ?></span>

    <label for="content">Contenu</label>
    <textarea name="content" id="content" cols="30" rows="10"><?=getValue('content',$article['content'])?></textarea>
    <span class="error"><?php if(!empty($errors['content'])) { echo $errors['content']; } ?></span>

    <label for="auteur">Auteur</label>
    <input type="text" name="auteur" id="auteur" value="<?=getValue('auteur',$article['auteur'])?>">
    <span class="error"><?php if(!empty($errors['auteur'])) { echo $errors['auteur']; } ?></span>

    <?php
        $statu = array(
            'draft' => 'brouillon',
            'publish' => 'Publié'
        );

        ?>
    <select name="statu">
        <option value=""><?=$article['statu']?></option>
        <?php foreach ($statu as $key => $value) {
                $selected = '';
                if(!empty($_POST['statu'])) {
                    if($_POST['statu'] == $key) {
                        $selected = ' selected="selected"';
                    }
                }
                ?>
        <option value="<?php echo $key; ?>" <?php echo $selected; ?>><?php echo $value; ?></option>
        <?php } ?>
    </select>
    <span class="error"><?php if(!empty($errors['statu'])) { echo $errors['statu']; } ?></span>


    <input type="submit" name="submitted" value="Modifier l'article">
</form>



<?php include('inc/footer-back.php');
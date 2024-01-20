<?php 
include 'header.php';
?>
<div class="container">
    <div class="panel-heading panel-content">
        <div class="row">
            <h1 class="text-center">Liste des fiches</h1>
            <div class="col-md-6">
                <a href="index.php?op=new" class="btn btn-info">Ajouter une nouvelle fiche</a>
            </div>
            <div class="col-md-6">
                <a href="index.php?op=listcateg" class="btn btn-info  float-right">Liste des categories</a>
            </div>
        </div>
    </div>
    <div class="panel-body">
        <table border="0" cellpadding="0" cellspacing="0" class="tasks">
            <thead>
                <tr>
                    <th>Titre</th>
                    <th>Description</th>
                    <th>User</th>
                    <th>Categorie</th>
                </tr>
            </thead>
            <tbody>
                <?php var_dump($articles);die;?>
                <?php foreach ($articles as $article) : ?>
                    <tr>
                        <td><?php print htmlentities($article['titre'], ENT_QUOTES); ?></td>
                        <td><?php print htmlentities($article['description'], ENT_QUOTES); ?></td>
                        <td><?php print htmlentities($article['name']); ?></td>
                        <td><?php print htmlentities($article['nom_categ']); ?></td>
                        <td><?php echo "<a href='index.php?op=edit&id=" . $article['id_article'] . "'class='btn btn-warning btn-sm' role='button'>" ?>edit</a>&nbsp;<a href="index.php?op=delete&id=<?php echo $article['id_article']; ?>" class="btn btn-primary btn-sm" role="button">Delete</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<br>
<div class="container">
    <?php
    $pagLink = "<ul class='pagination'>";
    for ($i = 1; $i <= $total; $i++) {
        $pagLink .= "<li class='page-item'><a class='page-link' href='index.php?page=" . $i . "'>" . $i . "</a></li>";
    }
    echo $pagLink . "</ul>";
    ?>
</div>

<br>
<div class="container">
    <div class="panel border-top">
        <div class="panel-heading panel-content">
        </div>
    </div>
</div>
<?php 
include 'footer.php';
?>

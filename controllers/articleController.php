<?php
require_once 'Models/ArticleModel.php';
require_once 'Models/CategModel.php';
require_once 'categoryController.php';
class articleController
{
    private $article = NULL;
    private $categ = NULL;

    public function __construct() {
        $this->article = new ArticleModel();
        $this->categ = new categoryController();
    }

    public function redirect($location) {
        header('Location: '.$location);
    }

    public function handleRequest() {
        $op = isset($_GET['op']) ? $_GET['op'] : NULL;
        $id = isset($_GET['id']) ? $_GET['id'] : NULL;
        try {
            if ( !$op || $op == 'list' ) {
                $this->listArticles();
            } elseif ( $op == 'new') {
                $this->saveFiche();
            } elseif ( $op == 'edit'&& $id != NULL) {
                $this->editArticle($id);
            }elseif ( $op == 'delete' && $id != NULL) {
                $this->deleteArticle($id);
            }elseif (!$op || $op == 'listcateg') {
                $this->listCateg();
            } elseif ($op == 'newcateg') {
                $this->saveCateg();
            } elseif ($op == 'editcateg' && $id != NULL) {
                $this->editCateg($id);
            } elseif ($op == 'deletecateg') {
                $this->deleteCateg($id);
            }
            else {
                $this->showError("Page not found", "Page for operation ".$op." was not found!");
            }
        } catch ( Exception $e ) {

            $this->showError("Application error", $e->getMessage());
        }
    }

    public function listArticles() {
        $paginate = 5;
        $orderby = isset($_GET['orderby']) ? $_GET['orderby'] : "titre ";
        if (isset($_GET["page"])) {
            $page  = $_GET["page"];
        }
        else{
            $page=1;
        };
        $start_from = ($page-1) * $paginate;
        $articles = $this->article->getAllArticles($orderby, $paginate, $start_from);
        $total = $this->article->paginator($paginate);
        include "Views/home.php";
    }

    public function saveArticle() {
        $id_user = '';
        $id_categ = '';
        $titre = '';
        $desc = '';
        $img = '';
        $categ = $this->getAllCateg();

        if ( isset($_POST['form-submitted']) ) {
            $id_user = $_SESSION;
            $id_categ       = isset($_POST['fiche-categorie']) ?   $_POST['fiche-categorie']  :NULL;
            $titre      = isset($_POST['titre'])?   $_POST['titre'] :NULL;
            $desc    = isset($_POST['description'])? $_POST['description']:NULL;
            $img = isset($FILES['name']) ? $FILES['name'] : NULL;
            try {
                $this->article->addArticle($id_user, $titre, $desc, $img, $id_categ);
                $this->redirect('index.php');
                return;
            } catch (Exception $exception) { echo 'Error: '. $exception->getMessage(); }
        }
        include 'Views/new-article.php';
    }

    public function editArticle($id)
    {
        $item = $this->article->getArticleById($id);
        $user = $item['id_user'];
        $titre = $item['titre'];
        $description = $item['description'];
        $img = $item['img_link'];
        $categ = $item['id_categ'];
        // $id_categorie = $this->fiche->getIdCateg($id);
        // $categ = $this->getAllCateg();

        if ( isset($_POST['form-submitted']) ) {
            $id_user      = isset($_POST['user']) ?   $_POST['user']  : NULL;
            $id_categ       = isset($_POST['article-categorie']) ?   $_POST['article-categorie']  : NULL;
            $titre      = isset($_POST['titre']) ?   $_POST['titre'] : NULL;
            $descriptions    = isset($_POST['description']) ? $_POST['description'] : NULL;
            $img    = isset($_FILES['name']) ? $_FILES['name'] : NULL;

            try {
                $this->article->updateArticle($id,$id_user, $titre, $descriptions,$img, $id_categ);
                $this->redirect('index.php');
                return;
            } catch (Exception $exception) { echo 'Error: '. $exception->getMessage(); }
        }
        include 'Views/fiche-form.php';
    }

    public function deleteArticle($id)
    {
        try {
            $this->article->deleteArticle($id);
        } catch (Exception $exception) {
            echo 'Error: ' . $exception->getMessage();
        }
        $this->redirect('index.php');
    }

    public function getAllCateg()
    {
        $categ = $this->categ->getAllCategWithoutPagination();
        return $categ;
    }

    

}

?>
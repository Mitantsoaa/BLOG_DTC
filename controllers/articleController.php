<?php
require_once 'Models/Fiches.php';
require_once 'Models/Categorie.php';
class FichesController
{
    private $fiche = NULL;
    private $categ = NULL;

    public function __construct() {
        $this->fiche = new Fiches();
        $this->categ = new Categorie();
    }

    public function redirect($location) {
        header('Location: '.$location);
    }

    public function handleRequest() {
        $op = isset($_GET['op']) ? $_GET['op'] : NULL;
        $id = isset($_GET['id']) ? $_GET['id'] : NULL;
        try {
            if ( !$op || $op == 'list' ) {
                $this->listFiches();
            } elseif ( $op == 'new') {
                $this->saveFiche();
            } elseif ( $op == 'edit'&& $id != NULL) {
                $this->editFiche($id);
            }elseif ( $op == 'delete' && $id != NULL) {
                $this->deleteFiche($id);
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
        $orderby = isset($_GET['orderby']) ? $_GET['orderby'] : "fiche_libelle ";
        if (isset($_GET["page"])) {
            $page  = $_GET["page"];
        }
        else{
            $page=1;
        };
        $start_from = ($page-1) * $paginate;
        $fiches = $this->fiche->getAllArticles($orderby, $paginate, $start_from);
        $total = $this->fiche->paginator($paginate);
        include "Views/list.php";
    }
}



    ?>
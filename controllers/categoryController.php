<?php
require_once 'Models/CategModel.php';
class categoryController
{
    private $categ = NULL;

    public function __construct() {
        $this->categ = new CategModel();
    }

    public function redirect($location) {
        header('Location: '.$location);
    }

    public function handleRequest() {
        $op = isset($_GET['op']) ? $_GET['op'] : NULL;
        $id = isset($_GET['id']) ? $_GET['id'] : NULL;
        try {
            if (!$op || $op == 'listcateg') {
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
}
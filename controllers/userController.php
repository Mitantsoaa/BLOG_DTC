<?php
require_once 'Models/UserModel.php';

class articleController
{
    private $user = NULL;

    public function __construct() {
        $this->user = new UserModel();
    }

    public function redirect($location) {
        header('Location: '.$location);
    }

    public function handleRequest() {
        $op = isset($_GET['op']) ? $_GET['op'] : NULL;
        $id = isset($_GET['id']) ? $_GET['id'] : NULL;
        try {
            if ( !$op || $op == 'listuser' ) {
                $this->listUsers();
            } elseif ( $op == 'adduser') {
                $this->saveUser();
            } elseif ( $op == 'edit'&& $id != NULL) {
                $this->editArticle($id);
            }elseif ( $op == 'delete' && $id != NULL) {
                $this->deleteArticle($id);
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
        $orderby = isset($_GET['orderby']) ? $_GET['orderby'] : "name ";
        if (isset($_GET["page"])) {
            $page  = $_GET["page"];
        }
        else{
            $page=1;
        };
        $start_from = ($page-1) * $paginate;
        $fiches = $this->user->listUser($orderby, $paginate, $start_from);
        $total = $this->user->paginator($paginate);
        include "Views/user/listUser.php";
    }

    public function saveUser()
    {
        $name = '';
        $id_role = '';

        if ( isset($_POST['form-submitted']) ) {
            $name       = isset($_POST['user-name']) ?   $_POST['user-name']  :NULL;
            $id_role      = isset($_POST['id-role']) ?   $_POST['id-role']  :NULL;

            try {
                $this->user->addUser($name, $id_role);
                $this->redirect('index.php');
                return;
            } catch (Exception $exception) { echo 'Error: '. $exception->getMessage(); }
        }
        include 'Views/user/new-user.php';
    }

    public function deleteUser($id)
    {
        try {
            $this->user->deleteUser($id);
        } catch (Exception $exception) {
            echo 'Error: ' . $exception->getMessage();
        }
        $this->redirect('index.php');
    }

    public function updateUser($id,$name,$id_role)
    {
        $item = $this->user->getUserById($id);
        $name = $item['name'];
        $id_role = $item['id_role'];

        if ( isset($_POST['form-submitted']) ) {
            $name      = isset($_POST['user-name']) ?   $_POST['user-name']  : NULL;
            $id_role      = isset($_POST['id-role']) ?   $_POST['id-role']  : NULL;

            try {
                $this->user->updateUser($id,$name,$id_role);
                $this->redirect('index.php');
                return;
            } catch (Exception $exception) { echo 'Error: '. $exception->getMessage(); }
        }
        include 'Views/user/user-form.php';
    }
}
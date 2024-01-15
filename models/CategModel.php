<?php
require_once ('Database.php');

class CategModel
{
    public function getAllCateg($order = 'nom_categ', $paginate, $start_from){
        try {
            $pdo = DataBase::connect();
            $sth = $pdo->prepare("SELECT * FROM categories ORDER BY $order LIMIT $start_from, $paginate");
            $sth->execute();
            $result = $sth->fetchAll();
            DataBase::disconnect();
        } catch (PDOException  $e ){
            echo "Error: ".$e;
        }
        return $result;
    }

     public function getAllCategWithoutPagination() {
        try {
            $pdo = DataBase::connect();
            $sth = $pdo->prepare("SELECT * FROM categories");
            $sth->execute();
            $result = $sth->fetchAll();
            DataBase::disconnect();
        } catch (PDOException  $e) {
            echo "Error: " . $e;
        }
        return $result;
    }

    public function getCateg($id) {
        try{
            $pdo = DataBase::connect();
            $sth = $pdo->prepare("SELECT * FROM categories WHERE id_categ = $id");
            $sth->execute();
            $result = $sth->fetch();

            DataBase::disconnect();
        }catch(PDOException  $e ){
            echo "Error: ".$e;
        }
        return ($result);
    }

    
}

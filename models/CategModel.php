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

    public function deleteCateg($id_categ) {
         try {
             $pdo = DataBase::connect();
             $stmt = $pdo->prepare(
                 "DELETE FROM categories WHERE id_categ = ?");
             $stmt->execute([$id_categ]);
             DataBase::disconnect();
         } catch (Exception $e) {
             DataBase::disconnect();
             throw $e;
         }
    }

    public function paginator ($limit)
    {
        try {
            $pdo = DataBase::connect();
            $sth = $pdo->prepare("SELECT COUNT(id_categ) FROM categories");
            $sth->execute();
            $result = $sth->fetchColumn();

            DataBase::disconnect();
            $total_pages = ceil($result / $limit);
            return $total_pages;
        } catch (PDOException  $e ){
            echo "Error: ".$e;
        }
    }
}

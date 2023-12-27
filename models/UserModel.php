<?php
require 'autoload.php';

    class UserModel
    {
        public function listUser($order = 'nom', $paginate, $start_from)
        {
            try {
                $pdo = DataBase::connect();
                $sql = $pdo->prepare("SELECT * FROM users u GROUP BY u.id_user ORDER BY $order LIMIT $start_from, $paginate");
                $sql->execute();
                $result = $sql->fetchAll();
                DataBase::disconnect();
            } catch (PDOException  $e ){
                echo "Error: ".$e;
            }

            return $result;
        }

        public function addUser($nom,$id_role)
        {
            try {
                $pdo = DataBase::connect();
                $sql = $pdo->prepare("INSERT INTO users ( nom, id_role) VALUES ('".$nom."','".$id_role."')");
                $sql->execute();
                DataBase::disconnect();
            } catch (Exception $e) {
                DataBase::disconnect();
                throw $e;
            }
        }

        public function updateUser($id)
        {

        }

        public function removeUser($id)
        {

        }

        public function paginator ($limit)
        {
            try {
                $pdo = DataBase::connect();
                $sth = $pdo->prepare("SELECT COUNT(id_user) FROM users");
                $sth->execute();
                $result = $sth->fetchColumn();
                DataBase::disconnect();
                $total_pages = ceil($result / $limit);

                return $total_pages;
            } catch (PDOException  $e ){
                echo "Error: ".$e;
            }
        }

        public function getUserRole($id)
        {
            try {
                $pdo = DataBase::connect();
                $sql = $pdo->prepare("SELECT id_role, role FROM users u INNER JOIN roles r ON u.id_role = roles.id_role WHERE u.id_user =".$id);
                $sql->execute();
                $result = $sql->fetchAll();
                DataBase::disconnect();
            } catch (PDOException  $e ){
                echo "Error: ".$e;
            }

            return $result;
        }

    }
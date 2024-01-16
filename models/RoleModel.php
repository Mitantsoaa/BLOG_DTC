<?php
    class RoleModel
    {
        public function deleteRole($id_role) {
            try {
                $pdo = DataBase::connect();
                $stmt = $pdo->prepare(
                    "DELETE FROM categories WHERE id_role = ?");
                $stmt->execute([$id_role]);
                DataBase::disconnect();
            } catch (Exception $e) {
                DataBase::disconnect();
                throw $e;
            }
        }

        public function getAllRoles() {
        try {
            $pdo = DataBase::connect();
            $sth = $pdo->prepare("SELECT * FROM roles");
            $sth->execute();
            $result = $sth->fetchAll();
            DataBase::disconnect();
        } catch (PDOException  $e) {
            echo "Error: " . $e;
        }
        return $result;
    }
    }
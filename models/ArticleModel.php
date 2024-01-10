<?php
require_once 'Database.php';
    class ArticleModel
    {
        public function getAllArticles()
        {
            try {
                $pdo = DataBase::connect();
                $sql = $pdo->prepare("SELECT * FROM articles a GROUP BY a.id ORDER BY $order LIMIT $start_from, $paginate");
                $sql->execute();
                $result = $sql->fetchAll();
                DataBase::disconnect();
            } catch (PDOException  $e ){
                echo "Error: ".$e;
            }

            return $result;

        }

        public function addArticle($id_user, $titre, $desc, $img, $categ)
        {
            try {
            $pdo = DataBase::connect();
            $stmt = $pdo->prepare("INSERT INTO articles (id_user, titre, description, img_link, id_categ) VALUES (?,?,?,?,?)");
			$stmt->execute([$id_user,$titre,$description,$img,$categ]);
            $id_fiche = $pdo->lastInsertId();
            // Exécution de la requête pour chaque valeur de l'array
            foreach ($id_categ as $param) {
                $sql = $pdo->prepare("INSERT INTO categ_liaison (id_fiche, id_categ) VALUES (:id_fiche, :id_categ)");
                $sql->bindValue(':id_fiche', $id_fiche);
                $sql->bindValue(':id_categ', $param);
                $sql->execute();
            }
            DataBase::disconnect();;
            } catch (Exception $e) {
            DataBase::disconnect();
            throw $e;
        }
        }

        public function getArticleById()
        {

        }

        public function updateArticle($id)
        {

        }

        public function deleteFiche( $id) {
            try {
                $pdo = DataBase::connect();
                $stmt = $pdo->prepare(
                    "DELETE FROM articles WHERE id_article = $id");
                    $sql = $pdo->prepare(
                    "DELETE FROM categ_liaison WHERE id_article = $id");
                $stmt->execute();
                $sql->execute();
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
                $sth = $pdo->prepare("SELECT COUNT(id) FROM articles");
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
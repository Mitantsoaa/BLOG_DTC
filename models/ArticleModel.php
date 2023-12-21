<?php
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

        public function getArticleById()
        {

        }

        public function updateArticle($id)
        {

        }

        public function deleteArticle($id)
        {
            
        }
    }
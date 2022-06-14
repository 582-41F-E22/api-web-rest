<?php
class AccesBd 
{
    private $pdo = null;    // Objet de Connexion (PDO)
    private $requetePdo = null; // Objet de requête paramétrée PDO (PDOStatement)

    function __construct()
    {
        if(!$this->pdo) {
            $options = [PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ];
            $this->pdo = new PDO("mysql:host=localhost; dbname=leila; charset=utf8"
                , 'root', '1234', $options);
        }
    }
    
    /**
     * Soumet une requête paramétrée PDO
     *
     * @param  string $sql Chaîne contenant une requête SQL paramétrée
     * @param  array $params Tableau associatif des paramètres de la requête
     * @return void
     */
    private function soumettre($sql, $params) {
        $this->requetePdo = $this->pdo->prepare($sql);
        $this->requetePdo->execute($params);
    }

        
    /**
     * Obtient un jeu d'enregistrement groupé (par première colonne sélectionnée)
     *
     * @param  string $sql Chaîne contenant une requête SQL paramétrée
     * @param  array $params Tableau associatif des paramètres de la requête
     * @return array Tableau associatif (colonne de groupage) contenant des tableaux
     *                  des données groupées
     */
    protected function lire($sql, $params=[]) {
        $this->soumettre($sql, $params);
        return $this->requete->fetchAll(PDO::FETCH_GROUP);
    }

    /**
     * Insère un enregistrement
     *
     * @param  string $sql Chaîne contenant une requête SQL paramétrée
     * @param  array $params Tableau associatif des paramètres de la requête
     * @return int Identifiant (auto increment) du dernier enregistrement inséré
     */
    protected function creer($sql, $params=[]) {
        $this->soumettre($sql, $params);
        return $this->pdo->lastInsertId();
    }

    /**
     * Modifie un enregistrement
     *
     * @param  string $sql Chaîne contenant une requête SQL paramétrée
     * @param  array $params Tableau associatif des paramètres de la requête
     * @return int Nombre d'enregistrements affectés
     */
    protected function modifier($sql, $params=[]) {
        $this->soumettre($sql, $params);
        return $this->requetePdo->rowCount();
    }

    /**
     * Modifie un enregistrement
     *
     * @param  string $sql Chaîne contenant une requête SQL paramétrée
     * @param  array $params Tableau associatif des paramètres de la requête
     * @return int Nombre d'enregistrements affectés
     */
    protected function supprimer($sql, $params=[]) {
        return $this->modifier($sql, $params=[]);
    }
}
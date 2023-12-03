<?php

namespace App\Models;

use App\Core\Db;

class Model extends Db
{
    protected $table;
    protected $id;
    private $db;
    //--------------------------------------READ-----------------------------------------------------------------------
    public function findAll()
    {
        $query = $this->requete('SELECT * FROM ' . $this->table);
        return $query->fetchAll();
    }

    public function findBy(array $criteres)
    {
        $champs = [];
        $valeur = [];

        foreach ($criteres as $champ => $valeur) {
            //SELECT * FROM annonces WHERE actif = ?

            $champs[] = "$champ = ?";
            $valeurs[] = $valeur;
        }
        //tableau champs en chaine de caracteres
        $liste_champs = implode('AND', $champs);

        return $this->requete('SELECT * FROM ' . $this->table . 'WHERE ' . $liste_champs, $valeurs)->fetchAll();
    }

    public function find(int $id)
    {
        return $this->requete("SELECT * FROM {$this->table} WHERE id = $id")->fetch();
    }
    //------------------------------------CREATE-------------------------------------------------------------------------
    public function create()
    {
        $champs = [];
        $inter = [];
        $valeur = [];

        foreach ($this as $champ => $valeur) {
            //INSERT INTO annonces (titre, description, actif) VALUES(?,?,?)
            if ($valeur !== null && $champ != 'db' && $champ != 'table') {
                $champs[] = $champ;
                $inter[] = "?";
                $valeurs[] = $valeur;
            }
        }
        //tableau champs en chaine de caracteres
        $liste_champs = implode(', ', $champs);
        $liste_inter = implode(', ', $inter);

        return $this->requete('INSERT INTO ' . $this->table . '( ' . $liste_champs . ') VALUES (' . $liste_inter . ')', $valeurs);
    }
    //----------------------------------UPDATE---------------------------------------------------------------------------

    public function update()
    {
        $champs = [];
        $valeur = [];

        foreach ($this as $champ => $valeur) {
            //UPDATE annonces SET titre = ?, description = ?, actif = ? WHERE id = ?
            if ($valeur !== null && $champ != 'db' && $champ != 'table') {
                $champs[] = "$champ = ?";
                $valeurs[] = $valeur;
            }
        }
        $valeurs[] = $this->id;

        //tableau champs en chaine de caracteres
        $liste_champs = implode(', ', $champs);


        return $this->requete('UPDATE ' . $this->table . 'SET ' . $liste_champs . ' WHERE id = ?', $valeurs);
    }
    //----------------------------------DELETE---------------------------------------------------------------------------

    public function delete(int $id)
    {
        return $this->requete("DELETE FROM {$this->table} WHERE id = ?", [$id]);
    }
    //-------------------------------------------------------------------------------------------------------------------

    public function requete(string $sql, array $attributs = null)
    {
        $this->db = Db::getInstance();

        if ($attributs !== null) {

            $query = $this->db->prepare($sql);
            $query->execute($attributs);
            return $query;
        } else {

            return $this->db->query($sql);
        }
    }

    public function hydrate($donnees)
    {
        foreach ($donnees as $key => $value) {
            $setter = 'set' . ucfirst($key);

            if (method_exists($this, $setter)) {
                $this->$setter($value);
            }
        }
        return $this;
    }
}

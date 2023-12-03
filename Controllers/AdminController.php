<?php

namespace App\Controllers;

use App\Models\AnnoncesModel;

class AdminControllers extends Controller{

    public function index()
    {
        if($this->isAdmin()){
            $this->render('admin/index');
        }
    }

    public function annonces(){
        if($this->isAdmin()){
            $annoncesModel = new AnnoncesModel;

            $annonces = $annoncesModel->findAll();

            $this->render('admin/annonces', ['annonces' => $annonces]);
        }
    }

    /**
     * Suppression d'un article
     */

    public function deleteAnnonce($id)
    {
        if($this->isAdmin()){
            $annonce = new AnnoncesModel;

            $annonce->delete($id);

            header('Location: admin/annonces');
        }
    }

    /**
     * Active ou desactive un annonce
     */

    public function activeAnnonce(int $id)
    {
        if($this->isAdmin()){
            $annoncesModel = new AnnoncesModel;

            $annoncesArray = $annoncesModel->find($id);

            if($annoncesArray){
                $annonce = $annoncesModel->hydrate($annoncesArray);

                $annonce->setActif($annonce->getActif() ? 0 : 1);

                $annonce->update();
                
            }
        }
    }

    /**
     * Verifie si on est Admin
     */

    private function isAdmin()
    {
        if(isset($_SESSION['user']) && in_array('ROLE_ADMIN', $_SESSION['user']['roles'])){

            return true;

        }else{
            $_SESSION['error'] = 'Vous n\'avez pas accés a cette zone';
            header('Location: /');
        }
    }
}
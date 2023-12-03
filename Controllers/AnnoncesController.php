<?php

namespace App\Controllers;

use App\Core\Form;
use App\Models\AnnoncesModel;

class AnnoncesController extends Controller
{

    /**
     * affiche toute les annonces
     *
     * @return void
     */
    public function index()
    {
        $annoncesModel = new AnnoncesModel;

        $annonces = $annoncesModel->findBy(['actif' => 1]);

        $this->render('annonces/index', ['annonces' => $annonces]);
    }

    /**
     * affiche 1 annonce
     *
     * @param integer $id id de l'annone
     * @return void
     */
    public function lire(int $id)
    {
        $annoncesModel = new AnnoncesModel;

        $annonce = $annoncesModel->find($id);

        $this->render('annonces/lire', compact('annonce'));
    }

    /**
     * Ajouter une annonce
     */

    public function ajouter()
    {

        $titre = '';
        $description = '';

        if (isset($_SESSION['user']) && !empty($_SESSION['user']['id'])) {

            if (Form::validate($_POST, ['titre', 'description'])) {

                $titre = strip_tags($_POST['titre']);
                $description = strip_tags($_POST['description']);

                $annonce = new AnnoncesModel;

                $annonce->setTitre($titre)
                    ->setDescription($description)
                    ->setUser_id($_SESSION['user']['id']);

                $annonce->create();

                $_SESSION['sucess'] = "Votre annonce a été enregistrée avec succès";
                header('Location: /');
                exit;
            } else {

                $titre = isset($_POST['titre']) ? strip_tags($_POST['titre']) : '';
                $description = isset($_POST['description']) ? strip_tags($_POST['description']) : '';

                $_SESSION['error'] = "Votre annonce n'a été pas enregistrée, un probléme est survenue";
                header('Location: /annonces/ajouter');
                exit;
            }

            $form = new Form;

            $form->startForm('post', '#', ['enctype' => 'multipart/formdata'])
                ->addlabelFor('titre', 'Titre de l\'annonce : ')
                ->addInput('text', 'titre', ['value' => $titre])
                ->addlabelFor('description', 'Texte de l\'annonce')
                ->addTextarea('description', $description)
                ->addInput('file', 'image[]', ['multilpe'])
                ->addButton('Modifier')
                ->endForm();

            $this->render('annonces/ajouter', ['form' => $form->create()]);
        } else {
            $_SESSION['error'] = "Vous devez être connecter pour accéder a cette page";
            header('Location: /users/login');
            exit;
        }
    }

    /**
     * Modifier une annonce
     */

    public function modifier(int $id)
    {

        if (isset($_SESSION['user']) && !empty($_SESSION['user']['id'])) {

            $annoncesModel = new AnnoncesModel;

            $annonce = $annoncesModel->find($id);

            if (!$annonce) {
                $_SESSION['error'] = "L'annonce recherchée n'existe pas";
                header('Location: /annonces');
                exit;
            }

            if ($annonce->user_id !== $_SESSION['user']['id']) {
                if (!in_array('ROLE_ADMIN', $_SESSION['user']['role'])) {
                    $_SESSION['error'] = "Vous n'avez pas accés a cette page";
                    header('Location: /annonces');
                    exit;
                }
            }

            if (Form::validate($_POST, ['titre', 'description'])) {

                $titre = strip_tags($_POST['titre']);
                $description = strip_tags($_POST['description']);

                $annonceUpdate = new AnnoncesModel;

                $annonceUpdate->setId($annonce->id)
                    ->setTitre($titre)
                    ->setDescription($description);

                $annonceUpdate->update();
            }

            $form = new Form;

            $form->startForm()
                ->addlabelFor('titre', 'Titre de l\'annonce : ')
                ->addInput('text', 'titre', ['value' => $annonce->titre])
                ->addlabelFor('description', 'Texte de l\'annonce')
                ->addTextarea('description', $annonce->description)
                ->addButton('Modifier')
                ->endForm();

            $this->render('annonces/modifier', ['form' => $form->create()]);
        } else {
            $_SESSION['error'] = "Vous devez être connecter pour accéder a cette page";
            header('Location: /users/login');
            exit;
        }
    }
}

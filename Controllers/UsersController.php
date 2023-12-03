<?php

namespace App\Controllers;

use App\Core\Form;
use App\Models\UsersModel;

class UsersController extends Controller
{
    /**
     * Connexion
     */

    public function login(){

        if(Form::validate($_POST, ['email', 'password'])){

            $usersModel = new UsersModel;

            $userArray = $usersModel->findOneByEmail(strip_tags($_POST['email']));

            if(!$userArray){
                $_SESSION['error'] = 'L\'adresse E-mail et/ou le mot de passe est incorrect';
                header('location; users/login');
                exit;
            }
            $user = $usersModel->hydrate($userArray);

            if(password_verify($_POST['password'], $user->getPassword())){
                $user->setSession();
                header('Location: /');
                exit;
            }else{                
                $_SESSION['error'] = 'L\'adresse E-mail et/ou le mot de passe est incorrect';
                header('location; users/login');
                exit;

            }

        }    
        $form = new Form;

        $form->startForm()
            ->addlabelFor('email', 'E-mail')
            ->addInput('email', 'email')
            ->addlabelFor('password', 'Mot de passe')
            ->addInput('password', 'password')
            ->addButton('Me Connecter')
            ->endForm();

            $this->render('users/login', ['loginForm' => $form->create()]);
    }

    /**
     * Inscription des utilisateurs
     */

    public function register()
    {
        if(Form::validate($_POST, ['email', 'password'])){

            $email = strip_tags($_POST['email']);
            $pass =password_hash($_POST['password'], PASSWORD_ARGON2ID);

            $user = new UsersModel;

            $user->setEmail($email)
                ->setPassword($pass);

            $user->create();
        }

        $form = new Form;

        $form->startForm()
            ->addlabelFor('email', 'E-mail')
            ->addInput('email', 'email')
            ->addlabelFor('password', 'Mot de passe')
            ->addInput('password', 'password')
            ->addButton('M\'inscrire')
            ->endForm();

            $this->render('users/register', ['registerForm' =>$form->create()]);
    }

    /**
     * Deconnexion
     */

    public function logout(){
        unset($_SESSION['user']);
        header('location: /');
        exit;
    }

}
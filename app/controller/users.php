<?php

namespace TicketSystem;

class UsersController extends Controller {

    protected function redirectToLoginIfNotLoggedIn() {
        # no redirect = no check for logged in user for this controller
    }

    public function login() {
        if($this->isUserLoggedIn()) {
            $this->redirectTo('?');
        }

        $this->renderTemplate('users/login.php');
    }

    
    public function doLogin() {
        if($this->isUserLoggedIn()) {
            $this->redirectTo('?');
        }

        # check for existence & format of input params
        $this->accessDeniedUnless(isset($this->post['name']) && is_string($this->post['name']));
        $this->accessDeniedUnless(isset($this->post['password']) && is_string($this->post['password']));

        $user = null;
        $errorMessage = '';
        
        $user =  $this->getModel('User')->checkLogin($this->post['name'], $this->post['password']);



        if($user) {
            $_SESSION['user_id'] = $user->id;
            session_regenerate_id(true);

            # generate a new random key (session secret) that is used to hide IDs from the user
            $_SESSION['k'] = $this->getModel('User')->getRandomStr();

            $this->setFlash('success', 'Successfully logged in.');
            $this->redirectTo('?');
        }
        else {
            $this->renderTemplate('users/login.php', ['error' => $errorMessage]);
        }
    }

    public function logout() {
        # only for logged in users
        parent::redirectToLoginIfNotLoggedIn();

        $this->clearSession();

        $this->redirectTo('?');
    }

    public function register() {
        if($this->isUserLoggedIn()) {
            $this->redirectTo('?');
        }

        $this->renderTemplate('users/register.php');
    }

    public function doRegister() {
        if($this->isUserLoggedIn()) {
            $this->redirectTo('?');
        }

        # check for existence & format of input params
        $this->accessDeniedUnless(isset($this->post['name']) && is_string($this->post['name']) && mb_strlen($this->post['name']) >= 3);
        $this->accessDeniedUnless(isset($this->post['password']) && is_string($this->post['password']) && mb_strlen($this->post['password']) >= 8);
        $this->accessDeniedUnless(isset($this->post['password_confirmation']) && is_string($this->post['password_confirmation']));

        $success = false;
        $errorMessage = '';

        $user = $this->getModel('User');

        # check captcha

            # check that name is not emtpy or taken...
            if($user->isNameFree($this->post['name'])) {
                # ... that password match
                if($this->post['password'] === $this->post['password_confirmation']) {
                    # ... profile pins match
                 
                        if ($user->register($this->post['name'], $this->post['password'])) {
                            $success = true;
                        } else {
                            $errorMessage = 'Could not register due to unknown error.';
                        }
                    
                }
                else {
                    $errorMessage = 'Password did not match.';
                }
            }
            else {
                $errorMessage = 'Name already taken.';
            }


        if($success) {
            session_regenerate_id(true);
            $this->setFlash('success', 'Successfully registered.');
            $this->redirectTo('?c=users&a=login');
        }
        
    }
}

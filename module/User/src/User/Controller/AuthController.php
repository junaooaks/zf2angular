<?php

namespace User\Controller;

use Zend\Mvc\Controller\AbstractActionController,
    Zend\View\Model\ViewModel;
use Zend\Authentication\AuthenticationService,
    Zend\Authentication\Storage\Session as SessionStorage;
use User\Form\Login as LoginForm;

class AuthController extends AbstractActionController {

    public function indexAction() {

        $form = new LoginForm;
        $error = false;

        $request = $this->getRequest();

        if ($request->isPost()) {
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $data = $request->getPost()->toArray();

                $auth = new AuthenticationService;

                //criar storage para gravar sessao da authenticação
                $sessionStorage = new SessionStorage('User');

                $auth = new AuthenticationService;

                $auth->setStorage($sessionStorage); //definir o sessionstorage para a auth

                $authAdapter = $this->getServiceLocator()->get('User\Auth\Adapter');

                $authAdapter->setUsername($data['email']);
                $authAdapter->setPassword($data['password']);

                $result = $auth->authenticate($authAdapter);

                if ($result->isValid()) {

                    $user = $auth->getIdentity();
                    $user = $user['user'];
                    $sessionStorage->write($user, null);

                    return $this->redirect()->toRoute('user-admin/default', array('controller' => 'users'));
                } else {
                    $error = true;
                }
            }
        }
        return new ViewModel(array('form'=>$form, 'error'=>$error));
    }
    
    public function logoutAction() {
        
        $auth = new AuthenticationService;
        
        $auth->setStorage(new SessionStorage('User'));
        $auth->clearIdentity();
        
        return $this->redirect()->toRoute('user-auth');
        
    }

}

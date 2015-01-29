<?php

namespace User\Controller;

use Zend\Mvc\Controller\AbstractActionController,
    Zend\View\Model\ViewModel;

use User\Form\User as FormUser;

class IndexController extends AbstractActionController {
    
    public function registerAction(){
        
        $form = new FormUser;
        $request = $this->getRequest();
        
        if($request->isPost()){
            $form->setData($request->getPost());
            
            if($form->isValid()){
                $service = $this->getServiceLocator()->get('User\Service\User');
                
                if($service->insert($request->getPost()->toArray())){
                    
                    $fm = $this->flashMessenger()
                               ->setNamespace('User')
                               ->addMessage("Usuario Cadastrado com sucesso");
                }
                
                return $this->redirect()->toRoute('user-register');
            }
        }
        
        $messages = $this->flashMessenger()
                         ->setNamespace('User')
                         ->getMessages();
        
        return new ViewModel(array('form'=>$form,'messages'=>$messages));
    }
    
    public function activateAction() {
        
        $activationkey = $this->params()->fromRoute('key');
        
        $userService = $this->getServiceLocator()->get('User\Service\User');
        
        $result = $userService->activate($activationkey);
        
        if($result)
            return new ViewModel(array('user'=>$result));
        else
            return new ViewModel();
        
    }
}

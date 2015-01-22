<?php

namespace User\Controller;

use Zend\Mvc\Controller\AbstractActionController,
    Zend\View\Model\ViewModel;

/**
 * Description of IndexController
 *
 * @author brsite
 */
class IndexController extends AbstractActionController {
    
    public function registerAction(){
        return new ViewModel();
    }
}

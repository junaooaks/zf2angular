<?php

namespace User\Auth;

use Zend\Authentication\Adapter\AdapterInterface,
    Zend\Authentication\Result;

use Doctrine\ORM\EntityManager;

class Adapter implements AdapterInterface{
    
    protected $em;
    protected $username;
    protected $password;
    
    public function __construct(EntityManager $em) {
        $this->em = $em;
    }
            
    function getUsername() {
        return $this->username;
    }

    function getPassword() {
        return $this->password;
    }

    function setUsername($username) {
        $this->username = $username;
    }

    function setPassword($password) {
        $this->password = $password;
    }

    public function authenticate() {
        
        $repository = $this->em->getRepository('User\Entity\Users');
        $user = $repository->findByEmailAndPassword($this->getUsername(), $this->getPassword());
        
        if($user)
            return new Result(Result::SUCCESS, array('user'=>$user), array('OK'));
        else
            return new Result(Result::FAILURE_CREDENTIAL_INVALID, null, array());
                    
    }

}

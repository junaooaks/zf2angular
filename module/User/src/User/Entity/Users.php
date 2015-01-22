<?php

namespace User\Entity;


use Doctrine\ORM\Mapping as ORM;
use Zend\Math\Rand,
    Zend\Crypt\Key\Derivation\Pbkdf2;
use Zend\Stdlib\Hydrator;

/**
 * Users
 *
 * @ORM\Table(name="users", uniqueConstraints={@ORM\UniqueConstraint(name="email", columns={"email"})})
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class Users
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nome", type="string", length=255, nullable=false)
     */
    private $nome;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=false)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255, nullable=false)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="salt", type="string", length=255, nullable=false)
     */
    private $salt;

    /**
     * @var boolean
     *
     * @ORM\Column(name="active", type="boolean", nullable=true)
     */
    private $active;

    /**
     * @var string
     *
     * @ORM\Column(name="activation_key", type="string", length=255, nullable=false)
     */
    private $activationKey;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=false)
     */
    private $updatedAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    private $createdAt;
    
    function __construct(array $options = array()) {
        
        //fazer automatico o set
        /*
        $hydrator =new Hydrator\ClassMethods;
        $hydrator->hydrate($options, $this);
        */
        //fazer automatizar o set
        (new Hydrator\ClassMethods)->hydrate($options, $this);
        
        
        $this->createdAt = new \DateTime("now");
        $this->updatedAt = new \DateTime("now");
        
        //gerar o salt aleatorio
        $this->salt = base64_encode(Rand::getBytes(8, true));
        
        //pegar o email de confirmação
        $this->activationKey = md5($this->email.$this->salt);
    }
    
    function encryptPassword($password){
        //encrytar a senha
        return base64_encode(Pbkdf2::calc('sha256', $password, $this->salt, 10000, strlen($password*2)));        
    }
            
    function getId() {
        return $this->id;
    }

    function getNome() {
        return $this->nome;
    }

    function getEmail() {
        return $this->email;
    }

    function getPassword() {
        return $this->password;
    }

    function getSalt() {
        return $this->salt;
    }

    function getActive() {
        return $this->active;
    }

    function getActivationKey() {
        return $this->activationKey;
    }

    function getUpdatedAt() {
        return $this->updatedAt;
    }

    function getCreatedAt() {
        return $this->createdAt;
    }

    function setId($id) {
        $this->id = $id;
        return $this;
    }

    function setNome($nome) {
        $this->nome = $nome;
        return $this;
    }

    function setEmail($email) {
        $this->email = $email;
        return $this;
    }

    function setPassword($password) {
        $this->password = $this->encryptPassword($password);
        return $this;
    }

    function setSalt($salt) {
        $this->salt = $salt;
        return $this;
    }

    function setActive($active) {
        $this->active = $active;
        return $this;
    }

    function setActivationKey($activationKey) {
        $this->activationKey = $activationKey;
        return $this;
    }

    /**
     * @ORM\PrePersist
     */
    function setUpdatedAt() {
        $this->updatedAt = new \DateTime("now");
        
    }

    function setCreatedAt() {
        $this->createdAt = new \DateTime("now");
        
    }




}

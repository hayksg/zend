<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation;

/**
 * User
 *
 * @ORM\Table(name="user", uniqueConstraints={@ORM\UniqueConstraint(name="user_name_u_k", columns={"name"})})
 * @ORM\Entity(repositoryClass="Application\Entity\Repository\UserRepository")
 *
 * @Annotation\Name("user")
 */
class User
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", precision=0, scale=0, nullable=false, unique=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @Annotation\Type("Zend\Form\Element\Csrf")
     * @Annotation\Name("csrf")
     * @Annotation\Options({"csrf_options":{"timeout":"600"}})
     */
    private $csrf;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=100, precision=0, scale=0, nullable=false, unique=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=100, precision=0, scale=0, nullable=false, unique=false)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=100, precision=0, scale=0, nullable=false, unique=false)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="role", type="string", length=10, precision=0, scale=0, nullable=false, unique=false)
     *
     * @Annotation\Type("Zend\Form\Element\Radio")
     * @Annotation\Attributes({"class":"form-check-input"})
     * @Annotation\Required({"required":"true"})
     * @Annotation\Filter({"name":"stripTags"})
     * @Annotation\Options({
     *     "label":"Choose role:",
     *     "label_attributes":{"class":"form-check-label"},
     *     "value_options":{"user":"User", "admin":"Admin"},
     * })
     * @Annotation\Validator({
     *     "name":"inArray",
     *     "options":{
     *         "haystack":{"user", "admin"},
     *         "messages":{"notInArray":"Not valid value"},
     *     },
     * })
     */
    private $role = 'user';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="registration_date", type="datetime", precision=0, scale=0, nullable=true, unique=false)
     */
    private $registrationDate;

    public function __construct()
    {
        $this->registrationDate = new \DateTime();
    }

    /**
     * @Annotation\Name("Zend\Form\Element\Submit")
     * @Annotation\Attributes({"class":"btn btn-default", "name":"submit", "value":"Submit"})
     * @Annotation\AllowEmpty({"allowEmpty":"true"})
     */
    private $submit;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return User
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set role
     *
     * @param string $role
     *
     * @return User
     */
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get role
     *
     * @return string
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Set registrationDate
     *
     * @param \DateTime $registrationDate
     *
     * @return User
     */
    public function setRegistrationDate($registrationDate)
    {
        $this->registrationDate = $registrationDate;

        return $this;
    }

    /**
     * Get registrationDate
     *
     * @return \DateTime
     */
    public function getRegistrationDate()
    {
        return $this->registrationDate;
    }
}


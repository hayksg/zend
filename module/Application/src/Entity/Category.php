<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation;

/**
 * Category
 *
 * @ORM\Table(name="category", uniqueConstraints={@ORM\UniqueConstraint(name="name_u_k", columns={"name"})}, indexes={@ORM\Index(name="parent_id_key", columns={"parent_id"})})
 * @ORM\Entity
 *
 * @Annotation\Name("category")
 * @Annotation\Attributes({"class":"form-horizontal"})
 */
class Category
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", precision=0, scale=0, nullable=false, unique=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     *
     * @Annotation\Exclude()
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
     * @ORM\Column(name="name", type="string", length=255, precision=0, scale=0, nullable=false, unique=false)
     *
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Attributes({"class":"form-control", "id":"name", "required":"required"})
     * @Annotation\Required({"required":"true"})
     * @Annotation\Options({
     *     "label":"Name:",
     *     "label_attributes":{"class":"control-label asterisk"},
     *     "min":"2",
     *     "max":"255"
     * })
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Filter({"name":"StringTrim"})
     * @Annotation\Validator({
     *     "name":"StringLength",
     *     "options":{
     *         "encoding":"utf-8",
     *         "min":"2",
     *         "max":"255",
     *     },
     * })
     */
    private $name;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_public", type="boolean", precision=0, scale=0, nullable=true, unique=false)
     *
     * @Annotation\Type("Zend\Form\Element\Checkbox")
     * @Annotation\Attributes({"id":"isPublic"})
     * @Annotation\Options({
     *     "label":"Is public:",
     *     "set_hidden_element":"true",
     *     "checked_value":1,
     *     "unchecked_value":0,
     * })
     * @Annotation\Filter({"name":"Boolean"})
     * @Annotation\Validator({
     *     "name":"InArray",
     *     "options":{
     *         "haystack":{0, 1}
     *     },
     * })
     * @Annotation\AllowEmpty({"allowEmpty":"false"})
     */
    private $isPublic = 0;

    /**
     * @var integer
     *
     * @ORM\Column(name="parent_id", type="integer", precision=0, scale=0, nullable=true, unique=false)
     *
     * @Annotation\Type("DoctrineModule\Form\Element\ObjectSelect")
     * @Annotation\Attributes({"class":"form-control", "id":"parent"})
     * @Annotation\Options({
     *     "label":"Parent:",
     *     "label_attributes":{"class":"control-label"},
     *     "id":"parent",
     *     "empty_option":"Without parent category",
     *     "target_class":"Application\Entity\Category",
     *     "property":"name",
     * })
     * @Annotation\Filter({"name":"digits"})
     * @Annotation\Filter({"name":"stringTrim"})
     * @Annotation\Validator({"name":"digits"})
     */
    private $parent;

    /**
     * @Annotation\Type("Zend\Form\Element\Submit")
     * @Annotation\Attributes({"class":"btn btn-default", "value":"submit"})
     * @Annotation\AllowEmpty({"allowEmpty":true})
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
     * @return Category
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
     * Set isPublic
     *
     * @param boolean $isPublic
     *
     * @return Category
     */
    public function setIsPublic($isPublic)
    {
        $this->isPublic = $isPublic;

        return $this;
    }

    /**
     * Get isPublic
     *
     * @return boolean
     */
    public function getIsPublic()
    {
        return $this->isPublic;
    }

    /**
     * Set parent
     *
     * @param \Application\Entity\Category $parent
     *
     * @return Category
     */
    public function setParent($parent)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \Application\Entity\Category
     */
    public function getParent()
    {
        return $this->parent;
    }
}


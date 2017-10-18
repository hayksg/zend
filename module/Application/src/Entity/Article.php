<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation;

/**
 * Article
 *
 * @ORM\Table(name="article", indexes={@ORM\Index(name="category_id_index", columns={"category_id"})})
 * @ORM\Entity(repositoryClass="Application\Entity\Repository\ArticleRepository")
 *
 * @Annotation\Name("article")
 * @Annotation\Attributes({"class":"form-horizontal"})
 */
class Article
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
     * @ORM\Column(name="title", type="string", length=255, precision=0, scale=0, nullable=false, unique=false)
     *
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Attributes({"class":"form-control", "id":"title", "required":"required"})
     * @Annotation\Required({"required":"true"})
     * @Annotation\Options({
     *     "label":"Title",
     *     "label_attributes":{"class":"control-label col-sm-3 asterisk"},
     *     "min":2,
     *     "max":255,
     * })
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Filter({"name":"StringTrim"})
     * @Annotation\Validator({
     *     "name":"StringLength",
     *     "options":{
     *         "encoding":"utf-8",
     *         "min":2,
     *         "max":255,
     *     },
     * })
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="short_content", type="text", length=65535, precision=0, scale=0, nullable=true, unique=false)
     *
     * @Annotation\Type("Zend\Form\Element\Textarea")
     * @Annotation\Attributes({"class":"form-control", "id":"shortContent"})
     * @Annotation\Options({
     *     "label":"Short content",
     *     "label_attributes":{"class":"control-label col-sm-3"},
     * })
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Filter({"name":"StringTrim"})
     * @Annotation\Validator({
     *     "name":"StringLength",
     *     "options":{
     *         "encoding":"utf-8",
     *     },
     * })
     */
    private $shortContent;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text", length=65535, precision=0, scale=0, nullable=false, unique=false)
     *
     * @Annotation\Type("Zend\Form\Element\Textarea")
     * @Annotation\Attributes({"class":"form-control", "id":"content", "required":"required"})
     * @Annotation\Required({"required":true})
     * @Annotation\Options({
     *     "label":"Content",
     *     "label_attributes":{"class":"control-label col-sm-3 asterisk"},
     * })
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Filter({"name":"StringTrim"})
     * @Annotation\Filter({"name":"HtmlEntities"})
     * @Annotation\Validator({
     *     "name":"StringLength",
     *     "options":{"encoding":"utf-8"},
     * })
     */
    private $content;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255, precision=0, scale=0, nullable=true, unique=false)
     *
     * @Annotation\Name("file")
     * @Annotation\Type("Zend\Form\Element\File")
     * @Annotation\Attributes({"id":"file"})
     * @Annotation\Options({
     *     "label":"Upload image",
     *     "label_attributes":{"class":"control-label col-sm-3"},
     * })
     * @Annotation\Validator({
     *     "name":"Zend\Validator\File\Extension",
     *     "options":{"extension":{"png", "jpg", "jpeg", "gif"}},
     * })
     * @Annotation\Validator({"name":"Zend\Validator\File\IsImage"})
     * @Annotation\Validator({
     *     "name":"Zend\Validator\File\Size",
     *     "options":{"max":"20"},
     * })
     * @Annotation\Input("Zend\InputFilter\FileInput")
     * @Annotation\AllowEmpty({"allowEmpty":"true"})
     */
    private $image;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_public", type="boolean", precision=0, scale=0, nullable=false, unique=false)
     *
     * @Annotation\Type("Zend\Form\Element\Checkbox")
     * @Annotation\Attributes({"class":"form-control", "id":"isPublic"})
     * @Annotation\Options({
     *     "label":"Is Public",
     *     "label_attributes":{"class":"control-label col-sm-3"},
     *     "set_hidden_element":true,
     *     "checked_value":1,
     *     "unchecked_value":0,
     * })
     * @Annotation\Filter({"name":"Boolean"})
     * @Annotation\AllowEmpty({"allowEmpty":false})
     */
    private $isPublic;

    /**
     * @var \Application\Entity\Category
     *
     * @ORM\ManyToOne(targetEntity="Application\Entity\Category")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="category_id", referencedColumnName="id", nullable=true)
     * })
     *
     * @Annotation\Type("DoctrineModule\Form\Element\ObjectSelect")
     * @Annotation\Attributes({"class":"form-control", "id":"category", "required":"required"})
     * @Annotation\Required({"required":true})
     * @Annotation\Options({
     *     "label":"Category",
     *     "label_attributes":{"class":"control-label col-sm-3 asterisk"},
     *     "empty_option":"Without parent category",
     *     "target_class":"Application\Entity\Category",
     *     "property":"name",
     * })
     * @Annotation\Validator({"name":"Digits"})
     * @Annotation\Filter({"name":"Digits"})
     */
    private $category;

    /**
     * @Annotation\Type("Zend\Form\Element\Submit")
     * @Annotation\Attributes({"class":"btn btn-default", "value":"submit"})
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
     * Set title
     *
     * @param string $title
     *
     * @return Article
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set shortContent
     *
     * @param string $shortContent
     *
     * @return Article
     */
    public function setShortContent($shortContent)
    {
        $this->shortContent = $shortContent;

        return $this;
    }

    /**
     * Get shortContent
     *
     * @return string
     */
    public function getShortContent()
    {
        return $this->shortContent;
    }

    /**
     * Set content
     *
     * @param string $content
     *
     * @return Article
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set image
     *
     * @param string $image
     *
     * @return Article
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set isPublic
     *
     * @param boolean $isPublic
     *
     * @return Article
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
     * Set category
     *
     * @param \Application\Entity\Category $category
     *
     * @return Article
     */
    public function setCategory(\Application\Entity\Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \Application\Entity\Category
     */
    public function getCategory()
    {
        return $this->category;
    }
}


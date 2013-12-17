<?php

namespace Bangpound\Bundle\DocumentCloudBundle\Model;

/**
 * Class Document
 * @package Bangpound\Bundle\DocumentCloudBundle\Model
 */
class Document implements \JsonSerializable
{
    /**
     * @var
     */
    private $title;

    /**
     * @var
     */
    private $description;

    /**
     * @var
     */
    private $id;

    /**
     * @var
     */
    private $pages;

    /**
     * @var array
     */
    private $annotations = array();

    /**
     * @var array
     */
    private $sections = array();

    /**
     * @var array
     */
    private $resources = array();

    /**
     * (PHP 5 &gt;= 5.4.0)<br/>
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     *               which is a value of any type other than a resource.
     */
    public function jsonSerialize()
    {
        return array(
            'title' => $this->getTitle(),
            'description' => $this->getDescription(),
            'id' => $this->getId(),
            'pages' => $this->getPages(),
            'annotations' => $this->getAnnotations(),
            'sections' => $this->getSections(),
            'resources' => $this->getResources(),
        );
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getPages()
    {
        return $this->pages;
    }

    /**
     * @param mixed $pages
     */
    public function setPages($pages)
    {
        $this->pages = $pages;
    }

    /**
     * @return mixed
     */
    public function getAnnotations()
    {
        return $this->annotations;
    }

    /**
     * @param mixed $annotations
     */
    public function setAnnotations(array $annotations)
    {
        $this->annotations = $annotations;
    }

    /**
     * @param Annotation $annotation
     */
    public function addAnnotation(Annotation $annotation)
    {
        $this->annotations[] = $annotation;
    }

    /**
     * @return mixed
     */
    public function getSections()
    {
        return $this->sections;
    }

    /**
     * @param array $sections
     */
    public function setSections(array $sections)
    {
        $this->sections = $sections;
    }

    /**
     * @param Section $section
     */
    public function addSection(Section $section)
    {
        $this->sections[] = $section;
    }

    /**
     * @return mixed
     */
    public function getResources()
    {
        return $this->resources;
    }

    /**
     * @param mixed $resources
     */
    public function setResources(array $resources)
    {
        $this->resources = $resources;
    }

    /**
     * @param $key
     * @param $value
     */
    public function setResource($key, $value)
    {
        $this->resources[$key] = $value;
    }
}

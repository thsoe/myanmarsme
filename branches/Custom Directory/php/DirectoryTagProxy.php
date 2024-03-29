<?php

namespace MyProject\Proxies;

/**
 * THIS CLASS WAS GENERATED BY THE DOCTRINE ORM. DO NOT EDIT THIS FILE.
 */
class DirectoryTagProxy extends \DirectoryTag implements \Doctrine\ORM\Proxy\Proxy
{
    private $_entityPersister;
    private $_identifier;
    public $__isInitialized__ = false;
    public function __construct($entityPersister, $identifier)
    {
        $this->_entityPersister = $entityPersister;
        $this->_identifier = $identifier;
    }
    /** @private */
    public function __load()
    {
        if (!$this->__isInitialized__ && $this->_entityPersister) {
            $this->__isInitialized__ = true;

            if (method_exists($this, "__wakeup")) {
                // call this after __isInitialized__to avoid infinite recursion
                // but before loading to emulate what ClassMetadata::newInstance()
                // provides.
                $this->__wakeup();
            }

            if ($this->_entityPersister->load($this->_identifier, $this) === null) {
                throw new \Doctrine\ORM\EntityNotFoundException();
            }
            unset($this->_entityPersister, $this->_identifier);
        }
    }

    
    public function getdirectorytagid()
    {
        if ($this->__isInitialized__ === false) {
            return $this->_identifier["directorytagid"];
        }
        $this->__load();
        return parent::getdirectorytagid();
    }

    public function setdirectorytagid($directorytagid)
    {
        $this->__load();
        return parent::setdirectorytagid($directorytagid);
    }

    public function getdirectoryid()
    {
        $this->__load();
        return parent::getdirectoryid();
    }

    public function setdirectoryid($directoryid)
    {
        $this->__load();
        return parent::setdirectoryid($directoryid);
    }

    public function gettagid()
    {
        $this->__load();
        return parent::gettagid();
    }

    public function settagid($tagid)
    {
        $this->__load();
        return parent::settagid($tagid);
    }

    public function getTagname()
    {
        $this->__load();
        return parent::getTagname();
    }

    public function setTagname($tagname)
    {
        $this->__load();
        return parent::setTagname($tagname);
    }

    public function getTTagid()
    {
        $this->__load();
        return parent::getTTagid();
    }

    public function setTTagid($tagid)
    {
        $this->__load();
        return parent::setTTagid($tagid);
    }

    public function toJSON()
    {
        $this->__load();
        return parent::toJSON();
    }


    public function __sleep()
    {
        return array('__isInitialized__', 'directorytagid', 'directoryid', 'tagid', 'tags');
    }

    public function __clone()
    {
        if (!$this->__isInitialized__ && $this->_entityPersister) {
            $this->__isInitialized__ = true;
            $class = $this->_entityPersister->getClassMetadata();
            $original = $this->_entityPersister->load($this->_identifier);
            if ($original === null) {
                throw new \Doctrine\ORM\EntityNotFoundException();
            }
            foreach ($class->reflFields AS $field => $reflProperty) {
                $reflProperty->setValue($this, $reflProperty->getValue($original));
            }
            unset($this->_entityPersister, $this->_identifier);
        }
        
    }
}
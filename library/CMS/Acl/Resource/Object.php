<?php
/*
 * Copyright (c) 2011 Matthew Doll <mdoll at homenet.me>.
 *
 * This file is part of HomeNet.
 *
 * HomeNet is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * HomeNet is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with HomeNet.  If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * @category   Zend
 * @package CMS
 * @subpackage Acl
 * @copyright Copyright (c) 2011 Matthew Doll <mdoll at homenet.me>.
 * @license http://www.gnu.org/licenses/gpl-3.0.html GNU/GPLv3
 */
class CMS_Acl_Resource_Object implements Zend_Acl_Resource_Interface, CMS_Acl_Parent_Interface
{
    /**
     * Unique id of Resource
     *
     * @var string
     */
    protected $_resourceId;
    protected  $_parent;

    /**
     * Sets the Resource identifier
     *
     * @param  string $controller
     * @param  string $object
     * @return void
     */
    public function __construct($controller, $object)
    {
         
        $this->_parent = new CMS_Acl_Resource_Controller($controller);
        $this->_resourceId =  $this->_parent->getResourceId().'o'.strtolower((string) $object);
    }

    /**
     * Defined by Zend_Acl_Resource_Interface; returns the Resource identifier
     *
     * @return string
     */
    public function getResourceId()
    {
        return $this->_resourceId;
    }
    
     /**
     * Defined by Zend_Acl_Parent_Interface; returns the Resource identifier
     *
     * @return string
     */
    public function getParent()
    {
        return $this->_parent;
    }

    /**
     * Defined by Zend_Acl_Resource_Interface; returns the Resource identifier
     * Proxies to getResourceId()
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getResourceId();
    }
}

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
 * @package Content
 * @subpackage Template
 * @copyright Copyright (c) 2011 Matthew Doll <mdoll at homenet.me>.
 * @license http://www.gnu.org/licenses/gpl-3.0.html GNU/GPLv3
 */
interface Content_Model_Template_MapperInterface {
    /**
     * @return Content_Model_Content_Interface
     */
    public function fetchObjectByIdRevision($id,$revision);
    /**
     * @return Content_Model_Content_Interface
     */
    public function fetchObjectsBySection($section);
    /**
     * @return Content_Model_Content_Interface
     */
    public function fetchObjectBySectionUrl($section, $url);

//    public function fetchObjectsByIdHouse($id,$house);

    public function save(Content_Model_Template_Interface $object);

    public function delete(Content_Model_Template_Interface $object);

    
    public function deleteBySection($section);
    
    public function deleteAll();
    
}
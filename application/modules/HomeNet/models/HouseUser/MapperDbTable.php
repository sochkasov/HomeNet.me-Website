<?php

/*
 * HouseUserMapperDbTable.php
 *
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
 * along with HomeNet.  If not, see <http ://www.gnu.org/licenses/>.
 */

/**
 * @package HomeNet
 * @subpackage HouseUser
 * @copyright Copyright (c) 2011 Matthew Doll <mdoll at homenet.me>.
 * @license http://www.gnu.org/licenses/gpl-3.0.html GNU/GPLv3
 */
class HomeNet_Model_HouseUser_MapperDbTable implements HomeNet_Model_HouseUser_MapperInterface {

    protected $_table = null;

     /**
     * @return Zend_Db_Table;
     */
    public function getTable() {
        if ($this->_table === null) {
            $this->_table = new Zend_Db_Table('homenet_house_users');
            $this->_table->setRowClass('HomeNet_Model_HouseUser_DbTableRow');
        }
        return $this->_table;
    }

    public function setTable($table) {
        $this->_table = $table;
    }

    public function fetchObjectsByUser($user) {
        $select = $this->getTable()->select()->where('user = ?', $user);
        return $this->getTable()->fetchAll($select);
    }

     public function fetchObjectById($id) {
        return $this->getTable()->find($id)->current();
    }

    public function save(HomeNet_Model_HouseUser_Interface $object) {

        if (($object instanceof HomeNet_Model_HouseUser_DbTableRow) && ($object->isConnected())) {
            return $object->save();
        } elseif ($object->id !== null) {
            $row = $this->fetchObjectById($object->id);
        } else {
            $row = $this->getTable()->createRow();
        }

        $row->fromArray($object->toArray());

       return $row->save();
    }

    public function delete(HomeNet_Model_HouseUser_Interface $object) {

        if (($object instanceof HomeNet_Model_HouseUser_DbTableRow) && ($object->isConnected())) {
            return $object->delete();
        } elseif ($object->id !== null) {
            $where = $this->getTable()->getAdapter()->quoteInto('id = ?', $object->id);
            return $this->getTable()->delete($where);
        }

        throw new InvalidArgumentException('Invalid HouseUser');
    }
    
    public function deleteAll(){
        if(APPLICATION_ENV != 'production'){
            $this->getTable()->getAdapter()->query('TRUNCATE TABLE `'. $this->getTable()->info('name').'`');
        }
    }

}
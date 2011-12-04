<?php

/*
 * RoomMapperDbTable.php
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
 * @subpackage Node
 * @copyright Copyright (c) 2011 Matthew Doll <mdoll at homenet.me>.
 * @license http://www.gnu.org/licenses/gpl-3.0.html GNU/GPLv3
 */
class HomeNet_Model_Node_MapperDbTable implements HomeNet_Model_Node_MapperInterface {

    protected $_table = null;

     /**
     * @return Zend_Db_Table;
     */
    public function getTable() {
        if ($this->_table === null) {
            $this->_table = new Zend_Db_Table('homenet_nodes');
            $this->_table->setRowClass('HomeNet_Model_Node_DbTableRow');
        }
        return $this->_table;
    }
    
    public function setTable($table) {
        $this->_table = $table;
    }

//    public function fetchObjectById($id) {
//        return $this->getTable()->find($id)->current();
//    }
    
    public function fetchObjectById($id) {

        //= array('name','driver', 'max_devices')

        $select = $this->getTable()->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select->setIntegrityCheck(false)
               ->where('homenet_nodes.id = ?', $id)
               ->join('homenet_node_models', 'homenet_node_models.id = homenet_nodes.model', array('plugin', 'name AS modelName', 'type', 'settings AS modelSettings'))
                ->limit(1);

        return $this->getTable()->fetchRow($select);
    }
    


//    public function fetchNodesByHouse($house){
//
//        $select = $this->getTable()->select()->where('house = ?', $house);
//        return $this->getTable()->fetchAll($select);
//    }
//
//    public function fetchNodesByRoom($room){
//
//        $select = $this->getTable()->select()->where('room = ?', $room);
//        return $this->getTable()->fetchAll($select);
//    }

    public function fetchObjectsByHouse($house){

        $select = $this->getTable()->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select->setIntegrityCheck(false)
               ->where('house = ?', $house)
               ->join('homenet_node_models', 'homenet_node_models.id = homenet_nodes.model', array('plugin', 'name AS modelName', 'type', 'settings AS modelSettings'));

        return $this->getTable()->fetchAll($select);
    }
    
        public function fetchObjectsByRoom($room){

        $select = $this->getTable()->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select->setIntegrityCheck(false)
               ->where('room = ?', $room)
               ->join('homenet_node_models', 'homenet_node_models.id = homenet_nodes.model', array('plugin', 'name AS modelName', 'type', 'settings AS modelSettings'));

        return $this->getTable()->fetchAll($select);
    }

    public function fetchObjectByHouseAddress($house,$address){

//        $select = $this->getTable()->select()->where('house = ?', $house)
//                                 ->where('node = ?', $node)
//                                 ->order('node DESC')
//                                 ->limit(1);

        $select = $this->getTable()->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select->setIntegrityCheck(false)
               ->where('house = ?', $house)
               ->where('address = ?', $address)
               ->join('homenet_node_models', 'homenet_node_models.id = homenet_nodes.model', array('plugin', 'name AS modelName', 'type', 'settings AS modelSettings'))
                ->limit(1);

        return $this->getTable()->fetchRow($select);
    }

    public function fetchNextAddressByHouse($house){

        $select = $this->getTable()->select()->where('house = ?', $house)
                                  ->where('address NOT IN(?)', array(255,4095))
                                  ->order('address DESC')
                                  ->limit(1);
       $row = $this->getTable()->fetchRow($select);
        $next = $row['address'] + 1;
        return $next;
    }

    public function fetchIdsByHouseType($house, $type){

        $select = $this->getTable()->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
         $select->setIntegrityCheck(false)
               ->where('house = ?', $house)
               ->join('homenet_node_models', 'homenet_node_models.id = homenet_nodes.model', array('plugin', 'name AS modelName', 'type', 'settings AS modelSettings'))
               ->where('homenet_node_models.type = ?', $type);

        $results = $this->getTable()->fetchAll($select);
        $array = array();
        
        foreach($results as $value){
            $array[] = $value->id;
        }
        
        return $array;
    }

    public function save(HomeNet_Model_Node_Interface $object) {


        if (($object instanceof HomeNet_Model_Node_DbTableRow) && ($object->isConnected())) {
            return $object->save();
        } elseif ($object->id !== null) {
            $row = $this->getTable()->find($object->id)->current();
        } else {
            $row = $this->getTable()->createRow();
        }

        $row->fromArray($object->toArray());
        
        return $row->save();
    }

    public function delete(HomeNet_Model_Node_Interface $object) {

        if (($object instanceof HomeNet_Model_Node_DbTableRow) && ($object->isConnected())) {
            return $object->delete();
        } elseif ($object->id !== null) {
           return $this->getTable()->find($object->id)->current()->delete();
        }

        throw new HomeNet_Model_Exception('Invalid Room');
    }
    
    public function deleteAll(){
        if(APPLICATION_ENV != 'production'){
            $this->getTable()->getAdapter()->query('TRUNCATE TABLE `'. $this->getTable()->info('name').'`');
        }
    }
}
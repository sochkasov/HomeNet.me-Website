<?php

/*
 * DeviceMapperDbTable.php
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
 * @subpackage Device
 * @copyright Copyright (c) 2011 Matthew Doll <mdoll at homenet.me>.
 * @license http://www.gnu.org/licenses/gpl-3.0.html GNU/GPLv3
 */
class HomeNet_Model_Device_MapperDbTable implements HomeNet_Model_Device_MapperInterface {

    protected $_table = null;

     /**
     * @var int House ID 
     */
    protected $_houseId;
 
    public function __construct($house = null) {
        $this->setHouseId($house);
    }
    
    public function setHouseId($house){
        if($house !== null){
            if (empty($house) || !is_numeric($house)) {
                throw new InvalidArgumentException('Invalid House ID');
            }
            $this->_houseId = $house;
        }
    }
    
    public function getHouseId(){
        if($this->_houseId === null){
            throw new InvalidArgumentException('Invalid House ID');
        }
        
        return $this->_houseId;
    }    
    
     /**
     * @return Zend_Db_Table;
     */
    public function getTable() {
        if ($this->_table === null) {
            $this->_table = new Zend_Db_Table('homenet_devices');
            $this->_table->setRowClass('HomeNet_Model_Device_DbTableRow');
        }
        return $this->_table;
    }

    public function setTable($table) {
        $this->_table = $table;
    }

     public function fetchObjectById($id) {
        $select = $this->getTable()->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select->setIntegrityCheck(false)
                ->where('house = ?', $this->getHouseId())
                ->where('homenet_devices.id = ?', $id)
                ->join('homenet_device_models', 'homenet_device_models.id = homenet_devices.model', array('plugin', 'name AS model_name'))
                ->limit(1);

        return $this->getTable()->fetchRow($select);

    }

    public function fetchObjectByNodePosition($node, $position) {
        $select = $this->getTable()->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select->setIntegrityCheck(false)
                ->where('house = ?', $this->getHouseId())
                ->where('node = ?', $node)
                ->where('position = ?', $position)
                ->join('homenet_device_models', 'homenet_device_models.id = homenet_devices.model', array('plugin', 'name AS model_name'))
                ->limit(1);

        return $this->getTable()->fetchRow($select);

    }

    public function fetchObjectsByNode($node, $status = HomeNet_Model_Component::STATUS_LIVE) {
        $select = $this->getTable()->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select->setIntegrityCheck(false)
                ->where('node = ?', $node)
                ->where('house = ?', $this->getHouseId())
                ->where('homenet_devices.status = ?', $status)
                ->join('homenet_device_models', 'homenet_device_models.id = homenet_devices.model', array('plugin', 'name AS model_name'))
                ->order('position ASC');

        return $this->getTable()->fetchAll($select);

    }

    public function fetchObjectByNodeaddressPosition($nodeAddress, $position) {
        $select = $this->getTable()->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select->setIntegrityCheck(false)
                ->where('homenet_devices.house = ?', $this->getHouseId())
                ->where('homenet_devices.position = ?', $position)
                ->join('homenet_nodes', 'homenet_nodes.id = homenet_devices.node', array('house'))
                ->where('homenet_nodes.address = ?', $nodeAddress)
                
                ->join('homenet_device_models', 'homenet_device_models.id = homenet_devices.model', array('plugin', 'name AS model_name'))
                ->limit(1);


        return $this->getTable()->fetchRow($select);

    }

    public function fetchObjectByIdWithNode($id) {
        $select = $this->getTable()->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select->setIntegrityCheck(false)
                ->from(null, array('homenet_devices.position AS device'))
                ->where('homenet_devices.id = ?', $id)
                ->where('homenet_devices.house = ?', $this->getHouseId())
                ->join('homenet_nodes', 'homenet_nodes.id = homenet_devices.node', array('id AS node_id', 'address', 'uplink'))
                ->limit(1);

        return $this->getTable()->fetchRow($select);
    }

    public function save(HomeNet_Model_Device_Interface $object) {

        if (($object instanceof HomeNet_Model_Device_DbTableRow) && ($object->isConnected())) {
            return $object->save();
        } elseif ($object->id !== null) {
            $row = $this->getTable()->find($object->id)->current();
        } else {
            $row = $this->getTable()->createRow();
        }

        $row->fromArray($object->toArray());

        return $row->save();
    }

    public function delete(HomeNet_Model_Device_Interface $object) {

        if (($object instanceof HomeNet_Model_Device_DbTableRow) && $object->isConnected() && !$object->isReadOnly()) {
            return $object->delete();
        } elseif ($object->id !== null) {
            return $this->getTable()->find($object->id)->current()->delete();
        }

        throw new InvalidArgumentException('Invalid Device');
    }
    public function deleteAll(){
        if(APPLICATION_ENV != 'production'){
            $this->getTable()->getAdapter()->query('TRUNCATE TABLE `'. $this->getTable()->info('name').'`');
        }
    }

}
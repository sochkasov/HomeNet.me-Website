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
 * @package Core
 * @subpackage User
 * @copyright Copyright (c) 2011 Matthew Doll <mdoll at homenet.me>.
 * @license http://www.gnu.org/licenses/gpl-3.0.html GNU/GPLv3
 */
class Core_Model_User {
    
    /*
     * id 	int(10) 		UNSIGNED 	No 		auto_increment 	Browse distinct values 	Change 	Drop 	Primary 	Unique 	Index 	Fulltext
	status 	tinyint(4) 			No 	-1 		Browse distinct values 	Change 	Drop 	Primary 	Unique 	Index 	Fulltext
	group 	int(10) 		UNSIGNED 	No 	2 		Browse distinct values 	Change 	Drop 	Primary 	Unique 	Index 	Fulltext
	username 	varchar(32) 	utf8_general_ci 		No 			Browse distinct values 	Change 	Drop 	Primary 	Unique 	Index 	Fulltext
	name 	varchar(56) 	utf8_general_ci 		No 			Browse distinct values 	Change 	Drop 	Primary 	Unique 	Index 	Fulltext
	location 	varchar(128) 	utf8_general_ci 		No 			Browse distinct values 	Change 	Drop 	Primary 	Unique 	Index 	Fulltext
	email 	varchar(128) 	utf8_general_ci 		No 			Browse distinct values 	Change 	Drop 	Primary 	Unique 	Index 	Fulltext
	created 	timestamp 			No 	CURRENT_TIMESTAMP 		Browse distinct values 	Change 	Drop 	Primary 	Unique 	Index 	Fulltext
	permissions 	text 	utf8_bin 		No 			Browse distinct values 	Change 	Drop 	Primary 	Unique 	Index 	Fulltext
	settings
     */

    /**
     * @var int
     */
    public $id;
    /**
     * @var int
     */
    public $status;
    /**
     * @var int
     */
    public $group = null;
    /**
     * @var string
     */
    public $username;
    /**
     * @var string
     */
    public $name;
    /**
     * @var string
     */
    public $location;
    /**
     * @var string
     */
    public $email;
    /**
     * @var Zend_Date
     */
    public $created;
    /**
     * @var CMS_ACL
     */
    public $permission;
    /**
     * @var array
     */
    public $settings;


    public function __construct(array $config = array()) {
        if (isset($config['data'])) {
            $this->fromArray($config['data']);
        }
    }

    public function fromArray(array $array) {

        $vars = get_object_vars($this);

        // die(debugArray($vars));

        foreach ($array as $key => $value) {
            if (array_key_exists($key, $vars)) {
                $this->$key = $value;
            }
        }
    }

    /**
     * @return array
     */
    public function toArray() {

        return get_object_vars($this);
    }

}
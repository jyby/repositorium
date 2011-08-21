<?php
/* User Fixture generated on: 2011-08-06 19:15:12 : 1312672512 */
class UserFixture extends CakeTestFixture {
	var $name = 'User';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 255, 'key' => 'primary'),
		'email' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 128, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'first_name' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 32, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'last_name' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 32, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'password' => array('type' => 'string', 'null' => false, 'default' => NULL, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'salt' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 128, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'is_administrator' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'active' => array('type' => 'boolean', 'null' => false, 'default' => true),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

	var $records = array(
		array(
			'id' => 1,
			'email' => 'test2@example.com',
			'first_name' => 'Foo',
			'last_name' => 'Bar',
			'password' => '0420244221694ed6acf002c13d55f70cbe217092',
			'salt' => '123456789',
			'is_administrator' => 1,
			'created' => '2011-07-27 19:17:32',
			'modified' => '2011-07-27 19:17:32'
		),
		array(
			'id' => 2,
			'email' => 'Lorem ipsum dolor sit amet',
			'first_name' => 'Lorem ipsum dolor sit amet',
			'last_name' => 'Lorem ipsum dolor sit amet',
			'password' => 'Lorem ipsum dolor sit amet',
			'salt' => 'Lorem ipsum dolor sit amet',
			'is_administrator' => 1,
			'created' => '2011-07-27 19:17:32',
			'modified' => '2011-07-27 19:17:32'
		),
	);
}
?>
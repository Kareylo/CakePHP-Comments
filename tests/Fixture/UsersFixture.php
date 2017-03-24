<?php
namespace Kareylo\Comments\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

class UsersFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array $fields
     * @access public
     */
    public $fields = [
        'id' => ['type' => 'string', 'null' => false, 'length' => 11],
        'username' => ['type' => 'string', 'null' => false],
        'passwd' => ['type' => 'string', 'null' => true, 'default' => null, 'length' => 128],
        'created' => ['type' => 'datetime', 'null' => true, 'default' => null],
        'modified' => ['type' => 'datetime', 'null' => true, 'default' => null],
        '_constraints' => ['primary' => ['type' => 'primary', 'columns' => ['id']]]
    ];
    /**
     * Records
     *
     * @var array $records
     * @access public
     */
    public $records = [
        [
            'id' => '1',
            'username' => 'kareylo',
            'created' => '2008-03-25 02:45:46',
            'modified' => '2008-03-25 02:45:46'
        ],
        [
            'id' => '2',
            'username' => 'kayzame',
            'created' => '2008-03-25 02:45:46',
            'modified' => '2008-03-25 02:45:46'
        ],
        [
            'id' => '3',
            'username' => 'kylua',
            'created' => '2008-03-25 02:45:46',
            'modified' => '2008-03-25 02:45:46'
        ],
        [
            'id' => '4',
            'username' => 'bidest',
            'created' => '2008-03-25 02:45:46',
            'modified' => '2008-03-25 02:45:46'
        ]
    ];
}

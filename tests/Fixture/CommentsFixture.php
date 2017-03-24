<?php
namespace Kareylo\Comments\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

class CommentsFixture extends TestFixture
{
    /**
     * fields property
     *
     * @var array
     * @access public
     */
    public $fields = [
        'id' => ['type' => 'integer'],
        'content' => ['type' => 'text', 'null' => false],
        'ref' => ['type' => 'text', 'null' => false, 'length' => 255],
        'ref_id' => ['type' => 'integer', 'null' => false, 'length' => 11],
        'ip' => ['type' => 'string', 'null' => false, 'length' => 255],
        'parent_id' => ['type' => 'integer', 'null' => true, 'length' => 11],
        'user_id' => ['type' => 'integer', 'null' => false, 'length' => 11],
        'created' => ['type' => 'datetime', 'null' => true, 'default' => null],
        'modified' => ['type' => 'datetime', 'null' => true, 'default' => null],
        '_constraints' => ['primary' => ['type' => 'primary', 'columns' => ['id']]]
    ];

    /**
     * records property
     *
     * @var array
     * @access public
     */
    public $records = [
        [
            'id' => 1,
            'content' => 'Lorem Ipsum',
            'ref' => 'Posts',
            'ref_id' => 2,
            'ip' => '::1',
            'parent_id' => null,
            'user_id' => 1,
            'created' => '2017-03-22 12:00:00',
            'modified' => '2017-03-22 12:00:00',
        ],
        [
            'id' => 2,
            'content' => 'Lorem Ipsum',
            'ref' => 'Posts',
            'ref_id' => 2,
            'ip' => '::1',
            'parent_id' => 1,
            'user_id' => 2,
            'created' => '2017-03-22 12:05:00',
            'modified' => '2017-03-22 12:05:00',
        ],
        [
            'id' => 3,
            'content' => 'Lorem Ipsum',
            'ref' => 'Posts',
            'ref_id' => 2,
            'ip' => '::1',
            'parent_id' => 1,
            'user_id' => 3,
            'created' => '2017-03-22 12:07:00',
            'modified' => '2017-03-22 12:07:00',
        ],
        [
            'id' => 4,
            'content' => 'Lorem Ipsum',
            'ref' => 'Posts',
            'ref_id' => 2,
            'ip' => '::1',
            'parent_id' => 3,
            'user_id' => 4,
            'created' => '2017-03-22 12:07:00',
            'modified' => '2017-03-22 12:07:00',
        ],
        [
            'id' => 5,
            'content' => 'Lorem Ipsum',
            'ref' => 'Posts',
            'ref_id' => 2,
            'ip' => '::1',
            'parent_id' => 2,
            'user_id' => 3,
            'created' => '2017-03-22 17:07:00',
            'modified' => '2017-03-22 17:07:00',
        ]
    ];

}

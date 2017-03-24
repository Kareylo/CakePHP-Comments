<?php
namespace Kareylo\Comments\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

class PostsFixture extends TestFixture
{
    /**
     * fields property
     *
     * @var array
     * @access public
     */
    public $fields = [
        'id' => ['type' => 'integer'],
        'title' => ['type' => 'string', 'null' => false],
        'content' => ['type' => 'text', 'null' => false],
        'comments_count' => ['type' => 'integer', 'null' => false, 'default' => 0, 'length' => 10],
        'user_id' => ['type' => 'integer', 'null' => false, 'length' => 11],
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
            'title' => 'First Article',
            'content' => 'Lorem ipsum dolor sit amet',
            'comments_count' => 0,
            'user_id' => 1
        ],
        [
            'id' => 2,
            'title' => 'Second Article',
            'content' => 'Ipsum lorem dolor sit amet',
            'comments_count' => 5,
            'user_id' => 1
        ]
    ];
}

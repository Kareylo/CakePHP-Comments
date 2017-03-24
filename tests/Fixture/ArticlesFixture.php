<?php
namespace Kareylo\Comments\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

class ArticlesFixture extends TestFixture
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
            'user_id' => 1
        ],
        [
            'id' => 2,
            'title' => 'Second Article',
            'content' => 'Ipsum lorem dolor sit amet',
            'user_id' => 1
        ]
    ];

}

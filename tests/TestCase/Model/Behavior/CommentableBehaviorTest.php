<?php
namespace Kareylo\Comments\Test\TestCase\Model\Behavior;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

class CommentableBehaviorTest extends TestCase
{
    /**
     * The instance of the model
     *
     * @var null
     */
    public $Posts = null;
    public $Users = null;

    public $fixtures = [
        'plugin.kareylo/comments.comments',
        'plugin.kareylo/comments.users',
        'plugin.kareylo/comments.posts',
    ];

    public function setUp()
    {
        parent::setUp();
        $this->Posts = TableRegistry::get('Posts');
        $this->Users = TableRegistry::get('Users');
    }

    public function tearDown()
    {
        parent::tearDown();
        unset($this->Posts);
        unset($this->Users);
        TableRegistry::clear();
    }

    /**
     *
     */
    public function testFindCommentsWithoutComments()
    {
        $this->Posts->addBehavior('Kareylo/Comments.Commentable', []);
        $result = $this->Posts->find()->where('Posts.id = 1')->find('comments')->first();
        $expected = $this->Posts->find('all', ['Posts.id' => 1])->contain('Comments')->first();
        $this->assertEquals($expected, $result);
    }

    public function testFindCommentsWithEmptyModelData()
    {
        $this->Posts->addBehavior('Kareylo/Comments.Commentable', []);
        $result = $this->Posts->find()->where('Posts.id = 999')->find('comments')->first();
        $this->assertEquals(null, $result);

    }

    public function testFindCommentsWithModelData()
    {
        $this->Posts->addBehavior('Kareylo/Comments.Commentable', []);
        $result = $result = $this->Posts->find()->where('Posts.id = 2')->find('comments')->first();
        $expected = $result = $this->Posts->find()->where('Posts.id = 2')->contain(['Comments' => function ($q) {
            return $q->find('threaded')->contain('Users');
        }])->first();
        $this->assertEquals($expected, $result);
    }
}

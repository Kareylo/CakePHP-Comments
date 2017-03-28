<?php
namespace Kareylo\Comments\Test\TestCase\Model\Behavior;

use App\Model\Table\PostsTable;
use App\Model\Table\UsersTable;
use Cake\ORM\Query;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

class CommentableBehaviorTest extends TestCase
{
    /**
     * @var PostsTable|null
     */
    public $Posts = null;

    public $fixtures = [
        'plugin.kareylo/comments.comments',
        'plugin.kareylo/comments.users',
        'plugin.kareylo/comments.posts',
    ];

    public function setUp()
    {
        parent::setUp();
        $this->Posts = TableRegistry::get('Posts');
    }

    public function tearDown()
    {
        parent::tearDown();
        unset($this->Posts);
        TableRegistry::clear();
    }

    /**
     *
     */
    public function testFindCommentsWithoutComments()
    {
        $this->Posts->addBehavior('Kareylo/Comments.Commentable', []);
        $result = $this->Posts->find()->where(['id' => 1])->find('comments')->first();
        $expected = $this->Posts->find()->where(['id' => 1])->contain('Comments')->first();
        $this->assertEquals($expected, $result);
    }

    public function testFindCommentsWithEmptyModelData()
    {
        $this->Posts->addBehavior('Kareylo/Comments.Commentable', []);
        $result = $this->Posts->find()->where(['id' => 999])->find('comments')->first();
        $this->assertEquals(null, $result);
    }

    public function testFindCommentsWithModelData()
    {
        $this->Posts->addBehavior('Kareylo/Comments.Commentable', []);
        $result = $result = $this->Posts->find()->where(['id' => 2])->find('comments')->first();
        $expected = $this->Posts->find()->where(['id' => 2])->contain(['Comments' => function (Query $q) {
            return $q->find('threaded')->contain('Users');
        }])->first();
        $this->assertEquals($expected, $result);
    }
}

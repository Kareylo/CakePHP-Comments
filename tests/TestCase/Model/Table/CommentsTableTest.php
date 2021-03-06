<?php
namespace Kareylo\Comments\Test\TestCase\Model\Table;

use Cake\Core\Configure;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use Kareylo\Comments\Model\Table\CommentsTable;

/**
 * CakePHP Ratings Plugin
 *
 * Rating model tests
 *
 * @package     ratings
 * @subpackage  ratings.tests.cases.models
 */
class CommentsTableTest extends TestCase
{
    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.kareylo/comments.users',
        'plugin.kareylo/comments.comments',
        'plugin.kareylo/comments.posts'
    ];

    /**
     * @var CommentsTable
     */
    private $Comments;

    /**
     * Start Test callback
     *
     * @return void
     */
    public function setUp()
    {
        Configure::delete('Comments');
        parent::setUp();
        $this->Comments = TableRegistry::get('Kareylo/Comments.Comments');
    }
    /**
     * testCommentInstance
     *
     * @return void
     */
    public function testCommentsInstance()
    {
        $this->assertInstanceOf('Kareylo\Comments\Model\Table\CommentsTable', $this->Comments);
    }
}

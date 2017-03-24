<?php
namespace Kareylo\Comments\Test\TestCase\Controller;

use Cake\Network\Exception\MethodNotAllowedException;
use Cake\Network\Request;
use Cake\Network\Session;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use Kareylo\Comments\Model\Table\CommentsTable;


class CommentsControllerTest extends TestCase
{

    /**
     * @var CommentsTable $Controller
     */
    public $Controller;

    /**
     * @var Session $session
     */
    public $session;

    public $fixtures = [
        'plugin.kareylo/comments.comments',
        'plugin.kareylo/comments.posts',
        'plugin.kareylo/comments.users',
    ];

    public function setup()
    {
        parent::setUp();

        $this->session = new Session();

        $this->Controller = TableRegistry::get('Comments');
        $this->Controller->request = new Request();
    }

    public function tearDown()
    {
        parent::tearDown();
        $this->session->destroy();
        unset($this->Controller);
        TableRegistry::clear();
    }

    private function _init($method = 'POST')
    {
        $_SERVER['REQUEST_METHOD'] = $method;
        $this->session->write('Auth.User.id', 1);
    }

    private function _setData($options = [])
    {
        $this->Controller->request->data = array_merge([
            'content' => 'Lorem Ipsum',
            'ref' => 'Posts',
            'ref_id' => '2',
            'parent_id' => ''
        ], $options);
    }

    public function testAddCommentWithBadMethod()
    {
        $this->_init('GET');
        $this->_setData();
        $this->expectException(MethodNotAllowedException::class);
        $this->expectExceptionMessage('Only Post');
        $this->_add();
    }

    /**
     * Correct comment add (correct ref and ref_id)
     */
    public function testAddCommentWithCorrectRefIdAndWithoutParentId()
    {
        $this->_init();
        $this->_setData();
        $this->assertTrue($this->_add());
    }

    public function testAddCommentWithIncorrectRefIdAndWithoutParentId()
    {
        $this->_init();
        $this->_setData(['ref_id' => 19]);
        $this->expectException(\OutOfBoundsException::class);
        $this->expectExceptionMessage('This Model is not Commentable');
        $this->_add();
    }

    public function testAddCommentWithCorrectParentId()
    {
        $this->_init();
        $this->_setData(['parent_id' => '1']);
        $this->assertTrue($this->_add());
    }

    public function testAddCommentWithIncorrectParentId()
    {
        $this->_init();
        $this->_setData(['parent_id' => '999999']);
        $this->expectException(\OutOfBoundsException::class);
        $this->expectExceptionMessage("You can't comment this record");
        $this->_add();
    }

    public function testAddCommentWithoutBehavior()
    {
        $this->_init();
        $this->_setData();
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Behavior is not loaded');
        $this->_add(true);
    }

    public function testAddCommentWithModelRefIdNotExists()
    {
        $this->_init();
        $this->_setData(['ref_id' => '999999']);
        $this->expectException(\OutOfBoundsException::class);
        $this->_add();
    }

    public function testAddCommentWithModelNotExists()
    {
        $this->_init();
        $this->_setData(['ref' => 'Articles']);
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Behavior is not loaded');
        $this->_add();
    }

    protected function _add($disableBehavior = false)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = array_merge($this->Controller->request->getData(), ['ip' => $this->Controller->request->clientIp(), 'user_id' => $this->session->read('Auth.User.id')]);
            $model = TableRegistry::get($data['ref']);

            // Force unload to test
            if ($disableBehavior) {
                $model->behaviors()->unload('Commentable');
            }

            if (!$model->hasBehavior('Commentable')) {
                throw new \Exception('Behavior is not loaded');
            }

            // check if we can comment this content
            if ($model->hasBehavior('Commentable') && !$model->exists(['id' => $data['ref_id']])) {
                throw new \OutOfBoundsException('This Model is not Commentable');
            }

            // Check if parent exists with the correct model
            if ($data['parent_id'] && !$this->Controller->exists(['id' => $data['parent_id'], 'ref' => $data['ref']])) {
                throw new \OutOfBoundsException("You can't comment this record");
            }

            $comment = $model->Comments->newEntity();
            $comment = $model->Comments->patchEntity($comment, $data);
            if ($model->Comments->save($comment)) {
                return true;
            } else {
                return false;
            }
        } else {
            throw new MethodNotAllowedException('Only Post');
        }
    }

}

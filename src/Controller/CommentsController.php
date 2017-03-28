<?php
namespace Kareylo\Comments\Controller;

use Cake\Http\Response;
use Cake\ORM\TableRegistry;
use Kareylo\Comments\Model\Table\CommentsTable;

/**
 * Class CommentsController
 * @package Comments\Controller
 * @property CommentsTable Comments
 */
class CommentsController extends AppController
{

    private $file;

    /**
     * Setup
     * @return void
     */
    public function initialize()
    {
        parent::initialize();
        $this->file = file_exists(APP . 'Template' . DS . 'Element' . DS . 'Flash' . DS . 'Comments' . DS . 'comment.ctp') ? 'Comments/comment' : 'Kareylo/Comments.comment';
        $this->Flash->set(__("You can't comment this"), ['class' => 'error', 'element' => $this->file]);
    }

    /**
     * Add a comment to specific model
     * @return Response
     */
    public function add()
    {
        $referer = $this->request->referer() . "#commentForm";
        if ($this->request->is(['post'])) {
            $data = array_merge($this->request->getData(), ['ip' => $this->request->clientIp(), 'user_id' => $this->Auth->user('id')]);
            $model = TableRegistry::get($data['ref']);

            // check if we can comment this content
            if (!$model->hasBehavior('Commentable') || $model->hasBehavior('Commentable') && !$model->exists(['id' => $data['ref_id']])) {
                $this->Flash->set(__("You can't comment this"), ['class' => 'error', 'element' => 'Kareylo/Comments.comment']);

                return $this->redirect($referer);
            }

            // Check if parent exists with the correct model
            if ($data['parent_id'] && !$this->Comments->exists(['id' => $data['parent_id'], 'ref' => $data['ref']])) {
                $this->Flash->set(__("You can't answer to this comment !"), ['class' => 'error', 'element' => 'Kareylo/Comments.comment']);

                return $this->redirect($referer);
            }

            $comment = $model->Comments->newEntity();
            $comment = $model->Comments->patchEntity($comment, $data);
            if ($model->Comments->save($comment)) {
                $this->Flash->set(__('Your comment has been correctly added !'), ['class' => 'success', 'element' => 'Kareylo/Comments.comment']);
            } else {
                $this->Flash->set(__('An error occured while saving your comment ! '), ['class' => 'error', 'element' => 'Kareylo/Comments.comment']);
            }
        }

        return $this->redirect($referer);
    }
}

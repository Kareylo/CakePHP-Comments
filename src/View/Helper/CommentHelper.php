<?php

namespace Kareylo\Comments\View\Helper;

use Cake\Datasource\EntityInterface;
use Cake\ORM\TableRegistry;
use Cake\View\Helper;
use Cake\View\Helper\FormHelper;

/**
 * @property FormHelper Form
 */
class CommentHelper extends Helper
{
    public $helpers = ['Html', 'Form'];
    public $_defaultConfig = [
        'type' => 'ul',
        'typeClass' => null,
        'subType' => null,
        'subTypeClass' => null,
        'loadJS' => false,
    ];
    private $_allowedTypes = ['ul', 'ol', 'div'];
    private $_html;
    private $_files;

    /**
     * Used to check if user is connected.
     * If user isn't connected, he can't reply and post a comment
     * @var bool
     */
    private $_connected = false;

    /**
     * Setup the helper.
     * @param array $config default config
     * @return void
     */
    public function initialize(array $config)
    {
        // Check which template to use : The one in the APP or in the PLUGIN
        $this->_files['form'] = file_exists(APP . 'Template' . DS . 'Element' . DS . 'Comments' . DS . 'form.ctp') ? 'Comments/form' : 'Kareylo/Comments.form';
        $this->_files['content'] = file_exists(APP . 'Template' . DS . 'Element' . DS . 'Comments' . DS . 'comment.ctp') ? 'Comments/comment' : 'Kareylo/Comments.comment';
        $this->_connected = $this->request->session()->read('Auth.User.id') !== null;
        if (!in_array($this->getConfig('type'), $this->_allowedTypes) && $this->getConfig('type') !== null) {
            throw new \OutOfBoundsException(__("You can't use {$this->getConfig('type')} ! Please use one of the following : " . implode(', ', $this->_allowedTypes)));
        }
        if ($this->getConfig('type' !== null)) {
            $this->setConfig('subType', $this->getConfig('type') === 'div' ? 'div' : 'li');
        }
    }

    /**
     * Display all comments of the given entity
     * @param EntityInterface|array $entity Contain all comments
     * @return string
     */
    public function display($entity = [])
    {
        $comments = [];
        if ($entity instanceof EntityInterface && $entity->has('comments')) {
            $comments = $entity->comments;
        } elseif (is_array($entity)) {
            $comments = $entity;
        }
        if ($comments) {
            if ($this->getConfig('typeClass')) {
                $this->_html .= "<{$this->getConfig('type')} class=\"{$this->getConfig('typeClass')}\">";
            } else {
                $this->_html .= "<{$this->getConfig('type')}>";
            }
            foreach ($comments as $comment) {
                $this->_html .= $this->comment($comment, false);
            }
            $this->_html .= "</{$this->getConfig('type')}>";
        }

        // Check if user is connected and add JS if needed
        if ($entity instanceof EntityInterface) {
            $this->_html .= $this->form($entity);
            $this->script();
        }

        return $this->_html;
    }

    /**
     * Add the current comment
     * @param EntityInterface $comment Current Comment and his children
     * @param bool $childless Must we check children ?
     * @return string
     */
    public function comment($comment, $childless = true)
    {
        $html = '';

        if ($childless) {
            return $this->_childless($comment);
        }

        if ($this->getConfig('subTypeClass')) {
            $html .= "<{$this->getConfig('subType')} class=\"{$this->getConfig('subTypeClass')}\">";
        } else {
            $html .= "<{$this->getConfig('subType')}>";
        }
        $html .= $this->_View->element($this->_files['content'], ['comment' => $comment, 'connected' => $this->_connected]);
        if ($comment->has('children')) {
            if ($this->getConfig('typeClass')) {
                $html .= "<{$this->getConfig('type')} class=\"{$this->getConfig('typeClass')}\">";
            } else {
                $html .= "<{$this->getConfig('type')}>";
            }
            foreach ($comment->children as $child) {
                $html .= $this->comment($child, false);
            }
            $html .= "</{$this->getConfig('type')}>";
        }
        $html .= "</{$this->getConfig('subType')}>";

        return $html;
    }

    /**
     * load JS and return CommentForm
     * @param EntityInterface $entity the model entity
     * @return string
     */
    public function loadFormAndJS(EntityInterface $entity)
    {
        $this->script();

        return $this->form($entity);
    }

    /**
     * return the Comment Form
     * @param EntityInterface $entity ModelEntity
     * @return string
     */
    public function form(EntityInterface $entity)
    {
        if ($this->_connected) {
            return "<div class='row {$this->getConfig('class')}'>{$this->_View->element($this->_files['form'], ['comment' => TableRegistry::get('Comments')->newEntity(['ref' => $entity->getSource(), 'ref_id' => $entity->get('id')])])}</div>";
        }

        return '';
    }

    /**
     * Load JS is required
     * @return void
     */
    public function script()
    {
        if ($this->_connected && $this->getConfig('loadJS')) {
            $this->_View->Html->script('Kareylo/Comments.comments.min.js', ['block' => true]);
        }
    }

    /**
     * return current comment HTML
     * @param EntityInterface $comment Current Comment
     * @return string
     */
    private function _childless(EntityInterface $comment)
    {
        $html = '';
        if ($this->getConfig('subType') !== null) {
            if ($this->getConfig('subTypeClass')) {
                $html .= "<{$this->getConfig('subType')} class=\"{$this->getConfig('subTypeClass')}\">{$this->_View->element($this->_files['content'], ['comment' => $comment, 'connected' => $this->_connected])}";
            } else {
                $html .= "<{$this->getConfig('subType')}>{$this->_View->element($this->_files['content'], ['comment' => $comment, 'connected' => $this->_connected])}";
            }
            $html .= "</{$this->getConfig('subType')}>";
        } else {
            $html .= $this->_View->element($this->_files['content'], ['comment' => $comment, 'connected' => $this->_connected]);
        }

        return $html;
    }
}

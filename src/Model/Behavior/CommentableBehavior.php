<?php
namespace Kareylo\Comments\Model\Behavior;

use Cake\ORM\Behavior;
use Cake\ORM\Query;

class CommentableBehavior extends Behavior
{

    /**
     * Default settings
     *
     * @var array
     */
    protected $_defaultConfig = [
        'modelClass' => null,
        'commentClass' => 'Kareylo/Comments.Comments',
        'foreignKey' => 'ref_id',
        'countComments' => false,
        'fieldCounter' => 'comments_count'
    ];

    /**
     * Setup
     *
     * @param array $config default config
     * @return void
     */
    public function initialize(array $config)
    {
        if (empty($this->getConfig('modelClass'))) {
            $this->setConfig('modelClass', $this->_table->getAlias());
        }

        $this->_table->hasMany('Comments', [
            'className' => $this->getConfig('commentClass'),
            'foreignKey' => $this->getConfig('foreignKey'),
            'order' => 'Comments.created ASC',
            'conditions' => ['Comments.ref' => "{$this->_table->getAlias()}"],
            'dependent' => true
        ]);

        if ($this->getConfig('countComments')) {
            $this->_table->Comments->addBehavior('CounterCache', [
                $this->_table->getAlias() => [$this->getConfig('fieldCounter')]
            ]);
        }

        $this->_table->Comments->belongsTo($this->getConfig('modelClass'), [
            'className' => $this->getConfig('modelClass'),
            'foreignKey' => 'ref_id'
        ]);
    }

    /**
     * Create the finder comments
     * @param Query $query the current Query
     * @param array $options Options
     * @return Query
     */
    public function findComments(Query $query, $options = [])
    {
        return $query->contain(['Comments' => function (Query $q) use ($options) {
                return $q->find('threaded')->contain('Users');
        }]);
    }
}

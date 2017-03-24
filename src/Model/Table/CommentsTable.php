<?php
namespace Kareylo\Comments\Model\Table;

use Cake\Core\Configure;
use Cake\ORM\Association\BelongsTo;
use Cake\ORM\Association\HasMany;
use Cake\ORM\Behavior\TimestampBehavior;
use Cake\ORM\Behavior\TreeBehavior;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Comments Model
 *
 * @property BelongsTo $ParentComments
 * @property BelongsTo $Users
 * @property HasMany $ChildComments
 *
 * @mixin TimestampBehavior
 * @mixin TreeBehavior
 */
class CommentsTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->setDisplayField('content');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('ParentComments', [
            'className' => 'Comments.Comments',
            'foreignKey' => 'parent_id'
        ]);

        $this->hasMany('ChildComments', [
            'className' => 'Comments.Comments',
            'foreignKey' => 'parent_id'
        ]);
        $this->belongsTo('Users');
    }

    /**
     * Validations rules
     * @param Validator $validator validator
     * @return Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator->notEmpty('content', __('Vous devez renseigner un contenu'));
        $validator->requirePresence('content');
        $validator->notEmpty('ref', __('Vous ne pouvez pas commenter ce contenu'));
        $validator->requirePresence('ref');
        $validator->notEmpty('ref_id', __('Vous ne pouvez pas commenter ce contenu'));
        $validator->requirePresence('ref_id');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['parent_id'], 'ParentComments'));
        $rules->add($rules->existsIn(['user_id'], 'Users'));

        return $rules;
    }
}

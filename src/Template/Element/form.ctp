<?= $this->Form->create($comment, ['id' => 'commentForm', 'url' => ['controller' => 'Comments', 'action' => 'add', 'plugin' => 'Kareylo/Comments']]); ?>
    <?= $this->Flash->render('comment'); ?>
    <?= $this->Form->control('content', ['label' => __('Commentaire'), 'type' => 'textarea']); ?>
    <?= $this->Form->hidden('ref'); ?>
    <?= $this->Form->hidden('ref_id'); ?>
    <?= $this->Form->unlockField('parent_id'); ?>
    <?= $this->Form->hidden('parent_id', ['default' => null]); ?>
    <?= $this->Form->button(__('Commenter')) ?>
<?= $this->Form->end() ?>

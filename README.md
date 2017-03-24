# Fully customizable Comments Plugin for CakePHP 3
[![Build Status](https://travis-ci.org/Kareylo/CakePHP-Comments.svg?branch=master)](https://travis-ci.org/Kareylo/CakePHP-Comments)
[![Latest Stable Version](https://poser.pugx.org/kareylo/cakephp-comments/v/stable)](https://packagist.org/packages/kareylo/cakephp-comments)
[![Total Downloads](https://poser.pugx.org/kareylo/cakephp-comments/downloads)](https://packagist.org/packages/kareylo/cakephp-comments)
[![Latest Unstable Version](https://poser.pugx.org/kareylo/cakephp-comments/v/unstable)](https://packagist.org/packages/kareylo/cakephp-comments)
[![License](https://poser.pugx.org/kareylo/cakephp-comments/license)](https://packagist.org/packages/kareylo/cakephp-comments)

The **Comments** plugin will allow you comment every model with the possibility to change the template in your APP.

This plugin works with a behavior and a helper you need to load to fully works.

## Requirements

* CakePHP 3.3.2+
* PHP 5.4+
* AuthComponent

## Installation

```
composer require Kareylo/CakePHP-Comments
```

load the plugin in your `config/bootstrap.php` :
```php
Plugin::load('Kareylo/Comments', [
    'routes' => true
]);
```

Add in the ModelTable you wanna be commentable the following behavior :
```php
$this->addBehavior('Kareylo/Comments.Commentable');
```
The behavior can take these options :
* **modelClass** : Class name of the ModelTable.
    * **Default** : `null`
* **commentClass** : Name of your CommentsTable if you have one. 
    * **Default** : `Kareylo/Comments.Comments`
* **foreignKey** : Name of your custom foreignKey. 
    * **Default** : `ref_id`
* **countComments** : Put true if you wanna your model count its Comments
    * **Default** : `false`
* **fieldCounter** : Name of your counter field
    * **Default** : `comments_count`

Add the following helper in your `src/View/AppView.php`
```php
public function initialize()
{
    $this->loadHelper('Kareylo/Comments.Comment');
}
```
The helper can take these options :
* **type** The HTML tag that will surround your comments
    * **Default** `ul`
    * **Accept** `ul`, `ol`, `div`
* **typeClass** the CSS class your type need to have
    * **Default** `null`
* **subTypeClass** The CSS class your subType need to have
    * **Default** `null`
* **loadJS** Put true if you wanna default JS to be loaded
    * **Default** `false`

## Usage

Get all your comments with the comments finder
```php
$data = $this->Model->find()->where(['Model.id' => $id])->find('comments')->first();
$this->set(compact('data'));
```

To display your comments
```php
$this->Comment->display($data);
```

You can also chose to not use `display($data)` and use a loop to have the full control of your template 
```php
// in your view
    <div class="row">
        <h4>Commentaires</h4>
        <ul class="comment-list">
            <?php foreach ($model->comments as $comment):
                echo $this->Comment->comment($comment);
            endforeach; ?>
        </ul>
        <!-- loadJS and display the comment Form if user is connected -->
        <?= $this->Comment->loadFormAndJS($model); ?>
    </div>
```

### Templates

To create templates for the comment block (1 comment) and the form block, create the views you want if `src/Template/Element/Comments`.
Example :
```php
/** src/Template/Element/Comments/comment.ctp
* $connected is used to check is user is connected
*/
<div class="comment-avatar">
    <i class="fa fa-user"></i>
</div>
<div class="comment-container">
    <div class="comment-author">
        <?= $comment->user->username; ?>
        <span class="comment-date">on <span
                class="underline"><?= $comment->created->format("l, d M y"); ?></span> at <span
                class="underline"><?= $comment->created->format("H:i:s"); ?></span></span>
    </div>
    <div class="comment-content">
        <?= h($comment->id); ?>
    </div>
    <?php if ($connected): ?>
        <div class="comment-btn pull-left">
            <a href="#" class="reply" data-id="<?= $comment->id ?>"><i class="fa fa-reply"></i> Reply</a>
        </div>
    <?php endif; ?>
    <?php if ($comment->children): ?>
        <ul class="comment-list">
            <?php foreach ($comment->children as $child) {
                echo $this->Comment->comment($child);
            } ?>
        </ul >
    <?php endif; ?>
</div>

// src/Template/Element/Comments/form.ctp
<?= $this->Form->create($comment, ['id' => 'commentForm', 'url' => ['controller' => 'Comments', 'action' => 'add', 'plugin' => 'Comments']]); ?>
    <?= $this->Flash->render('comment'); ?>
    <?= $this->Form->control('content', ['label' => __('Commentaire'), 'type' => 'textarea']); ?>
    <?= $this->Form->hidden('ref'); ?>
    <?= $this->Form->hidden('ref_id'); ?>
    <?= $this->Form->unlockField('parent_id'); ?>
    <?= $this->Form->hidden('parent_id', ['default' => null]); ?>
    <?= $this->Form->button(__('Commenter')) ?>
<?= $this->Form->end() ?>
```

## Support

For bugs and feature requests, please use the [issues](https://github.com/kareylo/cakephp-comments/issues) section of this repository.


## Contribute
[Follow this guide to contribute](https://github.com/Kareylo/CakePHP-Comments/blob/master/CONTRIBUTING.md)

## License

Licensed under the [MIT](http://www.opensource.org/licenses/mit-license.php) License. Redistributions of the source code included in this repository must retain the copyright notice found in each file.

## TODO
- [X] Test cases
    - [ ] Improved Test Cases (like test Helper)
- [ ] More features
- [ ] Translation

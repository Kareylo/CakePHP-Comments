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
        <?= h($comment->content); ?>
    </div>
    <?php if ($connected): ?>
        <div class="comment-btn pull-left">
            <a href="#" class="reply" data-id="<?= $comment->id ?>"><i class="fa fa-reply"></i> Reply</a>
        </div>
    <?php endif; ?>
</div>

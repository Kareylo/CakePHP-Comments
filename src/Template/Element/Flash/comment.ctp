<?php
if (!isset($params['escape']) || $params['escape'] !== false) {
    $message = h($message);
}
?>
<div class="message <?= $params['class'] ?? 'success' ?>" onclick="this.classList.add('hidden');"><?= $message ?></div>

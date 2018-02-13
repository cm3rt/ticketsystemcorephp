<?php $title = 'Edit ticket | '.$_SERVER['HTTP_HOST'] ?>

<div class="large-12 columns">
    <h3 class="subheader">Edit ticket</h3>

    <?php if($this->fl('success')): ?>
        <div data-alert class="alert-box success">
            <?= $this->fl('success') ?>
        </div>
    <?php endif ?>

    <?php require '../app/views/tickets/_form.php'; ?>
</div>

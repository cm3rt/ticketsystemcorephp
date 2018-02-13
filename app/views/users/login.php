<?php $title = 'Login | '.$_SERVER['HTTP_HOST'] ?>

<div class="large-8 large-offset-2 columns">
    <?php if(isset($error)): ?>
        <div data-alert class="alert-box alert">
            <?= $this->e($error) ?>
        </div>
    <?php endif ?>
    <?php if($this->fl('success')): ?>
        <div data-alert class="alert-box success">
            <?= $this->fl('success') ?>
        </div>
    <?php endif ?>

    <div id="login-logo-wrapper">
        <i class="fi-shield login"></i>
    </div>

    <form action="?c=users&a=doLogin" method="post">
        <div class="row collapse">
            <div class="large-3 large-offset-2 columns">
                <span class="prefix">Username</span>
            </div>
            <div class="large-5 columns end">
                <input type="text" name="name" placeholder="Choose a unique username" required="true" autocomplete="off">
            </div>
        </div>
        <div class="row collapse">
            <div class="large-3 large-offset-2 columns">
                <span class="prefix">Password</span>
            </div>
            <div class="large-5 columns end">
                <input type="password" name="password" placeholder="Choose a secure password" required="true" autocomplete="off">
            </div>
        </div>

        <div class="row collapse">
            <div class="large-8 large-offset-2 columns">
                <input type="submit" value="Login" class="button expand success" />
            </div>
        </div>
        <div class="row collapse">
            <div class="large-8 large-offset-2 columns text-center">
                <a href="?c=users&a=register">Register</a>
            </div>
        </div>
</div>
<div class="large-2 columns"></div>

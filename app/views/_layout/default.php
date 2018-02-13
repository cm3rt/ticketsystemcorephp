<!DOCTYPE html>
<!--[if IE 9]><html class="lt-ie10" lang="en" > <![endif]-->
<html lang="en" >

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        <?php if (isset($title)): ?>
            <?= $title ?>
        <?php else: ?>
           <?php  echo $_SERVER['HTTP_HOST']; ?>
        <?php endif ?>
    </title>

    <link rel="stylesheet" href="font/foundation-icons/foundation-icons.css" />
    <link rel="stylesheet" href="font/font-awesome/font-awesome.min.css">

    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/foundation.css">

    <link rel="stylesheet" href="css/app.css">
</head>
<body>
<div class="row">
<div class="large-12 columns">
<div class="row">
    <div class="large-12 columns">
        <nav class="top-bar" data-topbar>
            <ul class="title-area">
                <li class="name">
                    <h1><a href="?">
                            <i class="fi-ticketsys"></i>
                                <span class="title">
                                    <span class="first">T</span>icket
                                    <span class="first">S</span>ondor
                                    <span class="first">Y</span>itcoin
                                    <span class="first">S</span>arket
                                </span>
                        </a></h1>
                </li>
            </ul>
            <?php if($this->isUserLoggedIn()): ?>
                <section class="top-bar-section">
                    <ul class="right">
                        <li><span class="label secondary round account-label">
                                <?php if($this->user->is_admin): ?>
                                    <i class="fi-pricetag-multiple" title="This account is an admin account"></i>
                                <?php endif ?>
                                <i class="fi-torso" title="Logged in as <?= $this->e($this->user->name) ?>"></i>
                                <?= $this->e($this->user->name) ?>
                            </span>
                        </li>
                        <li class="divider"></li>
                        <li<?= $this->controller == 'listings' ? ' class="active"' : ''?>>
                            <a href="?c=listings">Listings</a>
                        </li>
                        <li class="divider"></li>
                        <li class="has-dropdown not-click">
                            <a>Profile</a>
                            <ul class="dropdown">
                                <li><label>General</label></li>
                                <li class="divider"></li>
                                <li><label>admin profile</label></li>
                                <?php if($this->user->is_admin): ?>
                                <li>
                                    <a href="?c=listings&a=admin&u=<?= $this->h($this->user->name, false) ?>">admin page</a>
                                </li>
                                <li class="has-dropdown not-click">
                                    <a>Listings</a>
                                    <ul class="dropdown">
                                        <li<?= $this->controller == 'tickets' ? ' class="active"' : ''?>>
                                            <a href="?c=tickets">Tickets</a>
                                        </li>
                                        <li<?= $this->controller == 'shippingOptions' ? ' class="active"' : ''?>>
                                            <a href="?c=shippingOptions">Shipping options</a>
                                        </li>
                                    </ul>
                                </li>
                                <?php else: ?>
                                    <li<?= $this->controller == 'profile' && $this->action == 'becomeadmin' ? ' class="active"' : ''?>>
                                        <a href="?c=profile&a=becomeadmin">Become admin</a>
                                    </li>
                                <?php endif ?>
                            </ul>
                        </li>
                        <li class="divider"></li>
                        <li class="has-form">
                            <a href="?c=users&a=logout" class="button alert logout">
                                Logout
                                <i class="fa fa-sign-out"></i>
                            </a>
                        </li>
                    </ul>
                </section>
            <?php endif ?>
        </nav>
    </div>
</div>
<div class="row body">
    <?= $content ?>
</div>
<footer class="row">
    <div class="large-12 columns">
        <hr>
        <div class="row">
            <div class="large-6 columns">
                <p>© Joseph Alai.</p>
            </div>
        </div>
    </div>
</footer>
</div>
</div>
</body>
</html>

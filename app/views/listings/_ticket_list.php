<?php foreach(array_chunk($tickets, $ticketsPerRow) as $row): ?>
    <ul class="small-block-grid-<?= $ticketsPerRow ?>">
        <?php foreach($row as $ticket): if ($ticket->assigned_to == $_SESSION['user_id']) {?>
            <li>
                <div class="thumbnail">
                    <?php $url ="?c=listings&a=ticket&code=" . $ticket->code ?>
                    
                    <div class="panel">
                        <a href="<?= $url ?>">
                            <h5><?= $this->e($ticket->name) ?></h5>
                        </a>
                        
                        <?php if($withadmin): ?>
                            <a href="?c=listings&a=admin&u=<?= $this->h($ticket->user, false) ?>">
                                <span class="label dark round"><i class="fi-torso"></i> <?= $this->e($ticket->user) ?></span>
                            </a>
                        <?php endif ?>
                    </div>
                </div>
            </li>
        <?php } endforeach ?>
    </ul>
<?php endforeach ?>

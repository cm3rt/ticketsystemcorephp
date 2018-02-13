<?php $title = "Ticket '" . $this->e($ticket->name) ."' | ".$_SERVER['HTTP_HOST'] ?>
<?php
//    print_r($assigned_to);    
    if ($ticket->assigned_to == $_SESSION['user_id']){
    $yours = true;
}
else
    $yours = false;

    ?>
<div class="large-12 columns">
    <?php if(isset($error)): ?>
        <div data-alert class="alert-box alert">
            <?= $this->e($error) ?>
        </div>
    <?php endif ?>
    <h2 class="subheader"><?= $this->e($ticket->name) ?></h2>
    <?php
        if ($ticket->assigned_to == 0){ 
        ?>
        <h3 style="color:red;">Unassigned</h3>
    <?php
    }
        ?>
    <a href="?c=listings&a=admin&u=<?= $this->h($ticket->user, false) ?>">
        <span class="label dark round"><i class="fi-torso"></i> <?= $this->e($ticket->user) ?>:
        </span>
    </a>

    <div class="row">
        <div class="small-4 columns">
            
        </div>
        <div class="small-8 columns ticket-description">
            <h5>Ticket Description</h5>
            <?= nl2br($this->e($ticket->description)) ?>
        </div>
    </div>
    <hr/>
    <div class="row">
        <div class="small-4 columns">
            
        </div>
        <div class="small-8 columns ticket-description">
            
            <h5>Comments</h5>
            
            <?php
        foreach ($comments as $comment){?>
        
            <?= $comment->name  ?>: <?= $comment->comment  ?><br />
    <?php }
        ?>
        </div>
    </div>
    <hr/>
    
    <form action="?c=orders&a=create" method="post" class="row">
        <input type="hidden" name="ticket_code" value="<?= $ticket->code ?>"/>

        
        <?php 
            if ($yours == true) {
            ?>
        <div class="small-2 columns">
            <input type="submit" class="button success small" value="Complete"/>
        </div>
        <?php } ?>
    </form>

    <a href="?">Back to listings</a>
</div>

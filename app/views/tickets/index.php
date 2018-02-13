<?php $title = 'Tickets | '.$_SERVER['HTTP_HOST'] ?>

<div class="large-12 columns">
    <h3 class="subheader">Tickets</h3>

    <?php if($this->fl('success')): ?>
        <div data-alert class="alert-box success">
            <?= $this->fl('success') ?>
        </div>
    <?php endif ?>

    <?php if($this->fl('error')): ?>
        <div data-alert class="alert-box alert">
            <?= $this->fl('error') ?>
        </div>
    <?php endif ?>

    <?php if(empty($tickets)): ?>
        <div data-alert class="alert-box secondary">
            No tickets found.
        </div>
    <?php else: ?>
    <table class="full-width">
        <thead>
        <tr>
            <th></th>
            <th>Name</th>
            <th>Action</th>
            <th width="80">Delete</th>
            <th width="80"></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($tickets as $ticket): ?>
        <tr>

            <td><?= $this->e($ticket->name) ?></td>
            <td><a href="?c=listings&a=ticket&code=<?= $ticket->code ?>">Ticket page</a></td>
            <td>
                
                
                <?php
    
                if ($ticket->assigned_to == $_SESSION['user_id']){
                 ?>
                <a href="?c=tickets&a=edit&code=<?= $ticket->code ?>" class="button tiny">Edit</a>
            
                <?php
                }
                else{
                    ?>
                <form action="?c=tickets&a=assign" method="post">
                    <strong>Assign To</strong><br />
                <select name="assign_to" style="width:100px;">
                <?php
                    
                    foreach($users as $user){
                        ?>
                    
                    <option value="<?=$_SESSION['user_id']?>"><?=$user->name?></option>
                <?php
                        
                    }
                    ?>
                </select>
                    <br />
                    <input type="hidden" name="code" value="<?= $ticket->code ?>"/>
                    <input type="submit" value="Assign" class="button tiny"/>
                </form>
            </td>
            <td>
    
                <form action="?c=tickets&a=destroy" method="post">
                    <input type="hidden" name="code" value="<?= $ticket->code ?>"/>
                    <input type="submit" value="Delete" class="button tiny alert"/>
                </form>
                <?php
                }
                

    ?>
                
            </td>
        </tr>
        <?php endforeach ?>
        </tbody>
    </table>
<?php endif ?>


        <a href="?c=tickets&a=build" class="button small success">New ticket</a>


    
</div>

<?php if(isset($error)): ?>
    <div data-alert class="alert-box alert">
        <?= $this->e($error) ?>
    </div>
<?php endif ?>

<?php $formAction = isset($ticket->id) ? '?c=tickets&a=update' : "?c=tickets&a=create" ?>
<form action="<?= $formAction ?>" method="post" enctype="multipart/form-data">
    <?php if(isset($ticket->id)): ?>
        <input type="hidden" name="code" value="<?= $ticket->code ?>"/>
    <?php endif ?>
    <input type="hidden" name="MAX_FILE_SIZE" value="5242880" />
    <div class="row">
        <div class="large-8 columns">
            <div class="row">
                <div class="large-3 columns">
                    <label for="name" class="right inline">Name</label>
                </div>
                <div class="large-9 columns">
                    <input type="text"
                           name="name"
                           value="<?= $this->e($ticket->name) ?>"
                           placeholder="Enter a name"
                           required="true"
                           pattern=".{3,}"
                           title="3 characters minimum">
                </div>
            </div>
            <div class="row">
                <div class="large-3 columns">
                    <label for="description" class="right inline">Description</label>
                </div>
                <div class="large-9 columns">
                    <textarea name="description"
                              rows="6"
                              placeholder="Please put detailled ticket description here."
                              required="true"
                              title="Will be shown on ticket page"><?= $this->e($ticket->description) ?></textarea>
                </div>
            </div>
            
            <div class="row">
                <div class="large-3 columns">
                    <label for="description" class="right inline">Assign To</label>
                </div>
                <div class="large-9 columns">
                    <select name="assign_to" style="width:100px;">
                <?php
                    
                    foreach($users as $user){
                        ?>
                    
                    <option value="<?=$_SESSION['user_id']?>"><?=$user->name?></option>
                <?php
                        
                    }
                    ?>
                </select>
                </div>
            </div>
            

            <hr/>
            <div class="row">
                <div class="large-9 large-offset-3 columns">
                    <input type="submit" value="Save" class="button small success" />
                </div>
            </div>
        </div>
    </div>
</form>

<a href="?c=tickets">Back</a>
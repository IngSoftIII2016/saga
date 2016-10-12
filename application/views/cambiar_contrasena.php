<?php
/**
 * Created by PhpStorm.
 * User: elias
 */
?>

    <div class="container">

        <h3><?php echo lang('change_password_heading');?></h3>

        <div id="infoMessage"><?php echo $message;?></div>

        <?php echo form_open("usuario/cambiar_contrasena");?>
        <div class="form-group">
                <?php echo lang('change_password_old_password_label', 'old_password');?> <br />

                <?php echo form_input($old_password,"","class=form-control");?>
        </div>
        <div class="form-group">
        <label for="new_password"><?php echo sprintf(lang('change_password_new_password_label'), $min_password_length);?></label> <br />
                <?php echo form_input($new_password,"","class=form-control");?>
        </div>
        <div class="form-group">
        <?php echo lang('change_password_new_password_confirm_label', 'new_password_confirm');?> <br />
                <?php echo form_input($new_password_confirm,"","class=form-control");?>
        </div>

        <?php echo form_input($user_id);?>
            <p><?php echo form_submit('submit', lang('change_password_submit_btn'),"class=btn btn-default");?></p>
        </div>
        <?php echo form_close();?>
    </div>

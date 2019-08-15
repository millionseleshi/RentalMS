<div class="mail-header" style="padding-bottom: 27px ;">
    <!-- title -->
    <h3 class="mail-title">
        <?php echo get_phrase('write_new_message'); ?>
    </h3>
</div>

<!--TODO Add Phrases TENANT|MAINTENANCE|CASHIER|ADMIN -->

<div class="mail-compose">

    <?php echo form_open(base_url() . 'index.php?manager/message/send_new/', array('class' => 'form', 'enctype' => 'multipart/form-data')); ?>


    <div class="form-group">
        <label for="subject"><?php echo get_phrase('recipient'); ?>:</label>
        <br><br>
        <select class="form-control select2" name="reciever" required>

            <<option value=""><?php echo get_phrase('select_a_user'); ?></option>
            <optgroup label="<?php echo get_phrase('Maintenance'); ?>">
                <?php
                $tenant = $this->db->get('maintenance')->result_array();
                foreach ($tenant as $row):
                    ?>

                    <option value="maintenance-<?php echo $row['id']; ?>">
                        - <?php echo $row['firstname'].' '.$row['lastname']; ?></option>

                <?php endforeach; ?>
            </optgroup>

            <optgroup label="<?php echo get_phrase('Cashier'); ?>">
                <?php
                $maintenance= $this->db->get('cashier')->result_array();
                foreach ($maintenance as $row):
                    ?>

                    <option value="cashier-<?php echo $row['id']; ?>">
                        - <?php echo $row['firstname'].' '.$row['lastname']; ?></option>

                <?php endforeach; ?>
            </optgroup>
            <optgroup label="<?php echo get_phrase('Tenant'); ?>">
                <?php
                $manager = $this->db->get('tenant')->result_array();
                foreach ($manager as $row):
                    ?>

                    <option value="tenant-<?php echo $row['id']; ?>">
                        - <?php echo $row['firstname'].' '.$row['middlename'].' '.$row['lastname']; ?></option>

                <?php endforeach; ?>
            </optgroup>

            <optgroup label="<?php echo get_phrase('Admin'); ?>">
                <?php
                $admin = $this->db->get('admin')->result_array();
                foreach ($admin as $row):
                    ?>

                    <option value="admin-<?php echo $row['id']; ?>">
                        - <?php echo $row['firstname'].' '.$row['lastname']; ?></option>

                <?php endforeach; ?>
            </optgroup>
        </select>
    </div>


    <div class="compose-message-editor">
        <textarea row="2" class="form-control wysihtml5" data-stylesheet-url="assets/css/wysihtml5-color.css" 
            name="message" placeholder="<?php echo get_phrase('write_your_message'); ?>" 
            id="sample_wysiwyg"></textarea>
    </div>

    <hr>

    <button type="submit" class="btn btn-success btn-icon pull-right">
        <?php echo get_phrase('send'); ?>
        <i class="entypo-mail"></i>

    </button>
</form>

</div>
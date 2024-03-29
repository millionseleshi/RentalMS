<div class="row">
    <div class="col-md-12">

        <!------CONTROL TABS START------>
        <ul class="nav nav-tabs bordered">

            <li class="active">
                <a href="#list" data-toggle="tab"><i class="entypo-user"></i>
                    <?php echo get_phrase('manage_profile'); ?>
                </a></li>
        </ul>
        <!------CONTROL TABS END------>


        <div class="tab-content">
            <!----EDITING FORM STARTS---->
            <div class="tab-pane box active" id="list" style="padding: 5px">
                <div class="box-content">

                    <?php
                    foreach ($edit_data as $row):
                        ?>
                        <?php echo form_open(base_url() . 'index.php?cashier/manage_profile/update_profile_info',
                        array('class' => 'form-horizontal form-groups-bordered validate', 'target' => '_top', 'enctype' => 'multipart/form-data')); ?>

                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?php echo get_phrase('First Name'); ?></label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="fname"
                                       value="<?php echo $row['firstname']; ?>"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?php echo get_phrase('Last Name'); ?></label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="lname"
                                       value="<?php echo $row['lastname']; ?>"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?php echo get_phrase('Phone Number'); ?></label>
                            <div class="col-sm-5">
                                <input type="number" min="0" class="form-control" name="p_number" required="required"
                                       value="<?php echo $row['phone_number']; ?>"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?php echo get_phrase('Alternate Phone Number'); ?></label>
                            <div class="col-sm-5">
                                <input type="number" min="0" class="form-control" name="o_number"
                                       value="<?php echo $row['other_number']; ?>"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?php echo get_phrase('email'); ?></label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="email"
                                       value="<?php echo $row['email']; ?>"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="field-1"
                                   class="col-sm-3 control-label"><?php echo get_phrase('photo'); ?></label>

                            <div class="col-sm-5">
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-new thumbnail"
                                         data-trigger="fileinput">
                                            <img src="<?php echo base_url().'uploads/CashierImage/'.$row['profile_image'];?>" class="img-rounded"
                                                 height="200px" width="200px"
                                                 alt="...">
                                    </div>
                                    <div class="fileinput-preview fileinput-exists thumbnail"
                                         style="max-width: 200px; max-height: 150px"></div>
                                    <div>
                                            <span class="btn btn-white btn-file">
                                                <span class="fileinput-new">Select image</span>
                                                <span class="fileinput-exists">Change</span>
                                                <input type="file" name="userfile" accept="image/*"">
                                            </span>
                                        <a href="#" class="btn btn-orange fileinput-exists" data-dismiss="fileinput">Remove</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-5">
                                <button type="submit"
                                        class="btn btn-info"><?php echo get_phrase('update_profile'); ?></button>
                            </div>
                        </div>

                        </form>
                    <?php
                    endforeach;
                    ?>
                </div>
            </div>
            <!----EDITING FORM ENDS-->

        </div>
    </div>
</div>


<!--password-->
<div class="row">
    <div class="col-md-12">

        <!------CONTROL TABS START------->
        <ul class="nav nav-tabs bordered">

            <li class="active">
                <a href="#list" data-toggle="tab"><i class="entypo-lock"></i>
                    <?php echo get_phrase('change_password'); ?>
                </a></li>
        </ul>
        <!------CONTROL TABS END------->


        <div class="tab-content">
            <!----EDITING FORM STARTS---->
            <div class="tab-pane box active" id="list" style="padding: 5px">
                <div class="box-content padded">
                    <?php
                    foreach ($edit_data as $row):
                        ?>
                        <?php echo form_open(base_url() . 'index.php?cashier/manage_profile/change_password',
                        array('class' => 'form-horizontal form-groups-bordered validate', 'target' => '_top')); ?>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?php echo get_phrase('current_password'); ?></label>
                            <div class="col-sm-5">
                                <input type="password" class="form-control" name="password" value=""/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?php echo get_phrase('new_password'); ?></label>
                            <div class="col-sm-5">
                                <input type="password" class="form-control" name="new_password" value=""/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?php echo get_phrase('confirm_new_password'); ?></label>
                            <div class="col-sm-5">
                                <input type="password" class="form-control" name="confirm_new_password" value=""/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-5">
                                <button type="submit"
                                        class="btn btn-info"><?php echo get_phrase('update_profile'); ?></button>
                            </div>
                        </div>
                        </form>
                    <?php
                    endforeach;
                    ?>
                </div>
            </div>
            <!----EDITING FORM ENDS--->

        </div>
    </div>
</div>
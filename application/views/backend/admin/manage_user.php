<?php
/**
 * Created by PhpStorm.
 * User: Million
 * Date: 10/7/2018
 * Time: 10:08 PM
 */
?>


<div class="row">
    <div class="col-md-12">

        <!------CONTROL TABS START------>
        <ul class="nav nav-tabs bordered">

            <li class="active">
                <a href="#add_users" data-toggle="tab"><i class="entypo-user-add"></i>
                    <?php echo get_phrase('Add Users');?>
                </a>
            </li>

            <li>
                <a href="#edit_user" data-toggle="tab"><i class="entypo-list"></i>
                    <?php echo get_phrase('User list');?>
                </a>
            </li>

            <li>
                <a href="#edit_room" data-toggle="tab"><i class="entypo-popup"></i>
                    <?php echo get_phrase('Create Room');?>
                </a>
            </li>

            <li>
                <a href="#edit_floor" data-toggle="tab"><i class="entypo-box"></i>
                    <?php echo get_phrase('Other');?>
                </a>
            </li>


        </ul>
        <!------CONTROL TABS END------>
        <div class="tab-content">


            <!--Add User Start-->
            <div class="tab-pane box active" id="add_users">
                <div class="boxed-layout">

                    <?php echo form_open(base_url().'index.php?admin/manage_user/add',
                        array('class' => 'form-horizontal form-groups-bordered validate', 'target' => '_top', 'enctype' => 'multipart/form-data'));?>

                    <div class="form-group">
                        <label class="col-sm-3 control-label"><?php echo get_phrase('Account Type')?></label>
                        <div class="col-sm-5">
                            <?php
                            $option=array(
                                ''=>'Select Account Type',
                                'manager'=>'Manager',
                                'maintenance'=>'Maintenance Officer',
                                'cashier'=>'Cashier'
                            );
                            echo form_dropdown('account_type',$option,'',array('class'=>'select2','id'=>'account_type','required'=>'required'));?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label"><?php echo get_phrase('First Name'); ?></label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" name="fname" required="required"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label"><?php echo get_phrase('Last Name'); ?></label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" name="lname" required="required"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label"><?php echo get_phrase('Phone Number'); ?></label>
                        <div class="col-sm-5">
                            <input type="number" min="0" class="form-control" name="p_number" required="required"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label"><?php echo get_phrase('Alternate Phone Number'); ?></label>
                        <div class="col-sm-5">
                            <input type="number" min="0" class="form-control" name="o_number"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label"><?php echo get_phrase('email'); ?></label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" name="email" required="required"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label"><?php echo get_phrase('National Id'); ?></label>
                        <div class="col-sm-5">
                            <input type="file" accept="image/*"  class="form-control" name="national_id" required="required"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-6 col-sm-5">
                            <button type="submit"
                                    class="btn btn-info"><?php echo get_phrase('Create Account'); ?></button>
                        </div>
                    </div>


                    <?php echo form_close()?>

                </div>
            </div>
            <!--Add User End-->

            <!--Edit User Start-->
            <div class="tab-pane box" id="edit_user">

                <div class="boxed-layout">

                    <?php echo form_open(base_url().'index.php?admin/manage_user/edit',
                        array('class' => 'form-horizontal form-groups-bordered validate', 'target' => '_top', 'enctype' => 'multipart/form-data'));?>


                    <div class="col-md-6">
                        <h5 class="uk-text-justify" style="font-size: larger"><span class="entypo-archive"></span>Manger List</h5>
                    </div>

                    <table cellpadding="3" cellspacing="0" border="1" class="table table-bordered table-responsive datatable" id="ManagerTable" >

                        <th><?php echo 'ID'?></th>
                        <th><?php echo 'First Name'?></th>
                        <th><?php echo 'Last Name'?></th>
                        <th><?php echo 'Phone Number'?></th>
                        <th><?php echo 'Other Number'?></th>
                        <th><?php echo 'email'?></th>
                        <th><?php echo 'Profile Image'?></th>
                        <th><?php echo 'National Id'?></th>
                        <th></th>

                        <?php foreach ($manager as $m_account):?>
                        <tr>
                            <td><?php echo $m_account['id'];?></td>
                            <td><?php echo $m_account['firstname'];?></td>
                            <td><?php echo $m_account['lastname'];?></td>
                            <td><?php echo $m_account['phone_number'];?></td>
                            <td><?php echo $m_account['other_number'];?></td>
                            <td><?php echo $m_account['email'];?></td>
                            <td><?php echo $m_account['profile_image'];?></td>
                            <td><?php echo $m_account['national_id'];?></td>
                            <td><a class="btn btn-danger"  href="#"
                                   onclick="confirm_modal('<?php echo base_url();?>index.php?admin/manage_user/delete_manager/<?php echo $m_account['id']?>');">
                                    <?php echo 'Delete' //TODO Add Phrase;?>
                                </a></td>
                            <?php endforeach;?>
                        </tr>
                    </table>

                    <div>
                        <button type="button"
                                class="btn btn-default btn-info"  id="print_manger"><?php echo 'Print'; //TODO Add Phrase ?></button>
                    </div>

                    <div class="col-md-6">
                        <h5 class="uk-text-justify" style="font-size: larger"><span class="entypo-archive"></span>Maintenace Officer List</h5>
                    </div>

                    <table cellpadding="3" cellspacing="0" border="1" class="table table-bordered table-responsive datatable" id="MaintenanceTable" >

                        <th><?php echo 'ID'?></th>
                        <th><?php echo 'First Name'?></th>
                        <th><?php echo 'Last Name'?></th>
                        <th><?php echo 'Phone Number'?></th>
                        <th><?php echo 'Other Number'?></th>
                        <th><?php echo 'email'?></th>
                        <th><?php echo 'Profile Image'?></th>
                        <th><?php echo 'National Id'?></th>
                        <th></th>

                        <?php foreach ($maintenance as $m_account):?>
                        <tr>
                            <td><?php echo $m_account['id'];?></td>
                            <td><?php echo $m_account['firstname'];?></td>
                            <td><?php echo $m_account['lastname'];?></td>
                            <td><?php echo $m_account['phone_number'];?></td>
                            <td><?php echo $m_account['other_number'];?></td>
                            <td><?php echo $m_account['email'];?></td>
                            <td><?php echo $m_account['profile_image'];?></td>
                            <td><?php echo $m_account['national_id'];?></td>
                            <td><a class="btn btn-danger"  href="#"
                                   onclick="confirm_modal('<?php echo base_url();?>index.php?admin/manage_user/delete_mainten/<?php echo $m_account['id']?>');">
                                    <?php echo 'Delete' //TODO Add Phrase;?>
                                </a></td>

                            <?php endforeach;?>
                        </tr>
                    </table>

                    <div>
                        <button type="button"
                                class="btn btn-default btn-info"  id="print_maintenance"><?php echo 'Print'; //TODO Add Phrase ?></button>
                    </div>

                    <div class="col-md-6">
                        <h5 class="uk-text-justify" style="font-size: larger"><span class="entypo-archive">
                            </span>Cashier List</h5>
                    </div>

                    <table cellpadding="3" cellspacing="0" border="1" class="table table-bordered table-responsive datatable" id="CashierTable" >

                        <th><?php echo 'ID'?></th>
                        <th><?php echo 'First Name'?></th>
                        <th><?php echo 'Last Name'?></th>
                        <th><?php echo 'Phone Number'?></th>
                        <th><?php echo 'Other Number'?></th>
                        <th><?php echo 'email'?></th>
                        <th><?php echo 'Profile Image'?></th>
                        <th><?php echo 'National Id'?></th>
                        <th></th>

                        <?php foreach ($cashier as $c_account):?>
                        <tr>
                            <td><?php echo $c_account['id'];?></td>
                            <td><?php echo $c_account['firstname'];?></td>
                            <td><?php echo $c_account['lastname'];?></td>
                            <td><?php echo $c_account['phone_number'];?></td>
                            <td><?php echo $c_account['other_number'];?></td>
                            <td><?php echo $c_account['email'];?></td>
                            <td><?php echo $c_account['profile_image'];?></td>
                            <td><?php echo $c_account['national_id'];?></td>
                            <td><a class="btn btn-danger"  href="#"
                                   onclick="confirm_modal('<?php echo base_url();?>index.php?admin/manage_user/delete_cashier/<?php echo $c_account['id']?>');">
                                    <?php echo 'Delete' //TODO Add Phrase;?>
                                </a></td>
                            <?php endforeach;?>
                        </tr>
                    </table>
                    <div>
                        <button type="button"
                                class="btn btn-default btn-info"  id="print_cashier"><?php echo 'Print'; //TODO Add Phrase ?></button>
                    </div>

                    <div class="col-md-6">
                        <h5 class="uk-text-justify" style="font-size: larger"><span class="entypo-archive"></span>Tenant List</h5>
                    </div>

                    <table cellpadding="3" cellspacing="0" border="1" class="table table-bordered table-responsive datatable" id="TenantTable" >

                        <th><?php echo 'ID'?></th>
                        <th><?php echo 'First Name'?></th>
                        <th><?php echo 'Middle Name'?></th>
                        <th><?php echo 'Last Name'?></th>
                        <th><?php echo 'National Id'?></th>
                        <th><?php echo 'Phone Number'?></th>
                        <th><?php echo 'Other Number'?></th>
                        <th><?php echo 'email'?></th>
                        <th><?php echo 'Room'?></th>
                        <th><?php echo 'Floor'?></th>
                        <th><?php echo 'Company Name'?></th>
                        <th><?php echo 'Company Description'?></th>
                        <th><?php echo 'Status'?></th>

                        <?php foreach ($tenant as $t_account):?>
                        <tr>
                            <td><?php echo $t_account['id'];?></td>
                            <td><?php echo $t_account['firstname'];?></td>
                            <td><?php echo $t_account['middlename'];?></td>
                            <td><?php echo $t_account['lastname'];?></td>
                            <td><?php echo $t_account['national_id'];?></td>
                            <td><?php echo $t_account['phone_number'];?></td>
                            <td><?php echo $t_account['alternatePhoneNumber'];?></td>
                            <td><?php echo $t_account['email'];?></td>

                            <?php $room=$this->db->get_where('room',array('id'=>$t_account['room_number']))->result_array();
                            foreach ($room as $r):?>
                                <td><?php echo $r['room_number'];?></td>
                            <?php endforeach;?>

                            <td><?php $num= $t_account['floor_number']-1;
                                echo $num;?></td>
                            <td><?php echo $t_account['company_name'];?></td>
                            <td><?php echo $t_account['company_description'];?></td>
                            <td><?php echo $t_account['status'];?></td>

                            <?php endforeach;?>
                        </tr>
                    </table>

                    <?php echo form_close();?>
                </div>

            </div>
            <!--Edit User End-->

            <!--Room start-->
            <div class="tab-pane box" id="edit_room">

                <div class="boxed-layout">
                    <?php echo form_open(base_url().'index.php?admin/manage_user/room',
                        array('class' => 'form-horizontal form-groups-bordered validate', 'target' => '_top', 'enctype' => 'multipart/form-data'));?>


                    <div class="form-group">
                        <label class="col-sm-3 control-label"><?php echo get_phrase('Floor'); ?></label>
                        <div class="col-sm-5" onchange="">
                            <?php $option=array(''=>"Select Floor",'1'=>"GROUND");
                            foreach ($floor as $item):?>
                            <?php if($item['floor_number']!="GROUND"):
                                    $num=$item['id']-1;
                                     $floor_coll=array($item['id']=>"FLOOR-".$num);
                                    array_push($option,$floor_coll);
                                    ?>
                            <?php endif;?>
                            <?php endforeach;?>
                            <?php echo form_dropdown('floor_list',$option,'',array('class'=>'select2','id'=>'floor_num','required'=>'required'));?>
                        </div>
                    </div>

                    <?php if($this->session->flashdata('room_error')):?>
                        <div class="alert alert-danger">
                            <span class="detail"><?php echo $this->session->flashdata('room_error');?></span>
                        </div>
                    <?php endif;?>
                    <div class="form-group">
                        <label class="col-sm-3 control-label"><?php echo get_phrase('Room Number')?></label>
                        <div class="col-sm-5">
                            <input class="form-control" required name="room_number">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label"><?php echo get_phrase('Room size')?></label>
                        <div class="col-sm-5">
                            <input class="form-control" required name="room_size" placeholder="In meterSq....">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-6 col-sm-5">
                            <button type="submit"
                                    class="btn btn-info"><?php echo get_phrase('Add Room'); ?></button>
                        </div>
                    </div>



                    <?php echo form_close();?>
                </div>
            </div>
            <!--Room end-->

            <!--Floor start-->
            <div class="tab-pane box" id="edit_floor">
                <div class="boxed-layout">

                    <?php echo form_open(base_url().'index.php?admin/manage_user/floor',
                        array('class' => 'form-horizontal form-groups-bordered validate', 'target' => '_top', 'enctype' => 'multipart/form-data'));?>


                    <div class="form-group">
                        <span></span>
                        <label class="col-sm-3 control-label"><?php echo get_phrase('Floor')?></label>
                        <div class="col-sm-5">
                            <input class="form-control" name="floor" type="number" min="0">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label"><?php echo get_phrase('Room Cost')?></label>
                        <div class="col-sm-5">
                            <input class="form-control"  name="room_per_m" placeholder="For 1.0 meterSq" type="number" min="0" value="<?php echo $price?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-6 col-sm-5">
                            <button type="submit"
                                    class="btn btn-gold"><?php echo get_phrase('Add Information'); ?></button>
                        </div>
                    </div>
                    <br>
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-6">
                        <div class="tile-stats tile-white-aqua">
                            <div class="icon"><i class="fa fa-building-o"></i></div>
                            <div class="num" data-start="0" data-end="<?php echo $this->db->count_all('floor');?>"
                                 data-postfix="" data-duration="1500" data-delay="0">0</div>

                            <h3 class="h3"><?php echo get_phrase('Floor'); ?></h3>
                            <h4 class="h4" style="color: grey"><?php echo get_phrase('*Including Ground'); ?></h4>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="tile-stats tile-white-gray">
                            <div class="icon"><i class="fa fa-building-o"></i></div>
                            <div class="num" data-start="0" data-end="<?php echo $this->db->count_all('room');?>"
                                 data-postfix="" data-duration="1500" data-delay="0">0</div>

                            <h3 class="h3"><?php echo get_phrase('Room'); ?></h3>
                            <h4 class="h4"><?php echo get_phrase('Total Room For Rent'); ?></h4>
                        </div>
                    </div>
                </div>
            </div>
                    <?php echo form_close();?>
                </div>
            </div>
            <!--Floor end-->
        </div>

    </div>
</div>


<script type="application/javascript">
    $(document).ready(function ()
    {
        $.fn.tableExport.bootstrap = ["btn", "btn-default", "btn-toolbar"];
        $.fn.tableExport.charset = "charset=utf-8";
        $.fn.tableExport.defaultButton = "button-info";
        $.fn.tableExport.rowDel = "\r\n";
        $.fn.tableExport.entityMap = {"&": "&#38;", "<": "&#60;", ">": "&#62;", "'": '&#39;', "/": '&#47;'};

        $('#print_manger').click(function () {
            $('#Managertable').tableExport({
                headers: true,
                footers:true,
                formats: ["xls", "csv", "txt"],
                bootstrap: true,
                exportButtons: true,
                position: "top",
            });
        });

        $('#print_maintenance').click(function () {
            $('#Maintenancetable').tableExport({
                headers: true,
                footers:true,
                formats: ["xls", "csv", "txt"],
                bootstrap: true,
                exportButtons: true,
                position: "top",
            });
        });

        $('#print_cashier').click(function () {
            $('#Cashiertable').tableExport({
                headers: true,
                footers:true,
                formats: ["xls", "csv", "txt"],
                bootstrap: true,
                exportButtons: true,
                position: "top",
            });
        });

    })
</script>
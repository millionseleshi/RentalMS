<?php
/**
 * Created by PhpStorm.
 * User: Million
 * Date: 9/4/2018
 * Time: 11:02 PM
 */

?>

<div class="row">
    <div class="col-md-12">

        <!------CONTROL TABS START------>
        <ul class="nav nav-tabs bordered">
            <li class="active">
                <a href="#request" data-toggle="tab"><i class="entypo-menu"></i>
                    <?php echo 'Request';//TODO Add Phrase?>
                </a></li>
            <li>
                <a href="#add" data-toggle="tab"><i class="entypo-list-add"></i>
                    <?php echo 'Spare Part';//TODO?>
                </a></li>


        </ul>
        <!------CONTROL TABS END------>


        <div class="tab-content">
            <!----Maintenance LISTING STARTS-->
            <div class="tab-pane box active" id="request">
                <table cellpadding="0" cellspacing="0" border="0" class="table table-bordered datatable" id="table_request">
                    <?php echo form_open(base_url().'index.php?maintenance/maintenance_request',
                        array('class' => 'form-horizontal form-groups-bordered validate', 'target' => '_top', 'enctype' => 'multipart/form-data'));?>
                    <?php if (sizeof($request)>0):?>
                        <?php foreach ($request as $item):?>
                            <div class="col-md-4">
                                   <div class="tile-stats tile-white-red">
                                   <div class="icon"><i class="fa fa-chain-broken"></i></div>
                                    <h3 class="h3"><?php echo 'Tenant Name: '.$item['tenant_name'];?></h3>
                                    <h4 class="h4"><?php $num=$item['floor_number']-1;echo 'Floor Number: '.$num;?></h4>
                                    <h4 class="h4"><?php $room_num=$this->db->get_where('room',array('id'=>$item['room_number']))->row()->room_number;
                                        echo 'Room Number: '.$room_num ;?></h4>
                                    <h4 class="h4"><?php echo'Maintenance Type: '.  $item['maintenance_type'];?></h4>
                                    <h4 class="h4" hidden><?php echo'Maintenance ID: '.  $item['id'];?></h4>

                                       <div>
                                           <a href="#" onclick="confirm_modal('<?php echo base_url();?>index.php?maintenance/maintenance_request/fixed/<?php echo $item['id']?>');">
                                               <i class="entypo-tools"></i>
                                               <?php echo 'Fixed' //TODO Add Phrase;?>
                                           </a>
                                       </div>

                                </div>
                          </div>
                        <?php endforeach;?>

                         <?php else: ?>
                             <span class="text-center center-block" style="margin-top: 40px">
                    <img src="<?php echo base_url(); ?>assets/images/loader-1.gif" width="70" alt="NO Maintenance Request">
                    </span>
                       <?php endif;?>

                    <?php echo form_close();?>
                </table>
            </div>

            <!----Maintenance LISTING ENDS--->


            <!----Spare FORM STARTS---->
            <div class="tab-pane box" id="add" style="padding: 5px">
                <div class="box-content">
            <?php echo form_open(base_url().'index.php?maintenance/maintenance_request/spare_part',
                array('class' => 'form-horizontal form-groups-bordered validate', 'target' => '_top', 'enctype' => 'multipart/form-data'));?>

                    <div class="form-group">
                        <label class="col-sm-3 control-label"><?php echo 'Spare name'; //TODO ADD Phrase?></label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" name="spare_name" required="required"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label"><?php echo 'Spare amount'; //TODO ADD Phrase?></label>
                        <div class="col-sm-5">
                            <?php if($this->session->flashdata('spare_error')):
                                echo $this->session->flashdata('spare_error');
                            endif;?>
                            <input type="number" class="form-control" name="spare_amount" min="1" required="required"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label"><?php echo 'Floor'; //TODO ADD Phrase?></label>
                        <div class="col-sm-5">
                            <input type="number" class="form-control" name="floor_number" min="1" required="required"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label"><?php echo 'Room'; //TODO ADD Phrase?></label>
                        <div class="col-sm-5">
                            <input type="number" class="form-control" name="room_number"  min="1" required="required"/>
                        </div>
                    </div>


                    <div class="form-group">
                        <div class="col-sm-offset-6 col-sm-5">
                            <button type="submit"
                                    class="btn btn-info"><?php echo 'send request'; //TODO Add Phrase ?></button>
                        </div>
                    </div>

            <?php echo form_close();?>
                </div>
            </div>
            <!----Spare FORM ENDS-->
        </div>
    </div>
</div>




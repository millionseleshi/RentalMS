<?php

?>
<div class="row">
	<div class="col-md-12">
    
    	<!------CONTROL TABS START------>
		<ul class="nav nav-tabs bordered">
			<li class="active">
            	<a href="#request" data-toggle="tab"><i class="entypo-folder"></i>
					<?php echo 'Request Form'//TODO Add Phrase;?>
                    	</a>
            </li>

			<li>
            	<a href="#sent" data-toggle="tab"><i class="entypo-rocket"></i>
					<?php echo 'Sent Request' //TODO Add Phrase;?>
                    	</a>
            </li>

		</ul>
    	<!------CONTROL TABS END------>

        <div class="tab-content">
            <!----Request Form---->
            <div class="tab-pane box active" id="request" style="padding: 5px">
                <div class="box-content">
                    <?php echo form_open(base_url().'index.php?tenant/maintenance/request/',
                        array('class' => 'form-horizontal form-groups-bordered validate', 'target' => '_top', 'enctype' => 'multipart/form-data'));?>

                    <div class="form-group">
                        <label class="col-sm-3 control-label"><?php echo 'Maintenace Type'; //TODO ADD Phrase?></label>
                        <div class="col-sm-5 se">
                        <?php $option=array(
                                'Light_And_Electrical'=>'Light And Electrical',
                                'Water_and_Pipe'=>'Water and Pipe',
                                'Restroom_and_Shower'=>'Restroom and Shower',
                                'Door_and_Window'=>'Door and Window',
                                'Roof_and_Wall'=>'Roof and Wall',
                                'Telephone_and_network'=>'Telephone and network',
                                'Other'=>'Other',
                        );
                        echo form_dropdown('maintenance_type',$option,'',array('class'=>'select2' ,'required'=>'required'));?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label"><?php echo 'Name'; //TODO ADD Phrase?></label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" name="name" value="<?php echo $name;?> " disabled="disabled"/>

                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label"><?php echo 'Floor'; //TODO ADD Phrase?></label>
                        <div class="col-sm-5">

                            <input type="text" class="form-control" name="floor" value="<?php $num=$floor-1; echo $num ;?>" disabled="disabled"/>

                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label"><?php echo 'Room'; //TODO ADD Phrase?></label>
                        <div class="col-sm-5">

                            <input type="text" class="form-control" name="room" value="<?php echo $room; ?>" disabled="disabled"/>
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
            <!----Request FORM ENDS-->

            <!----Pending Request Form-->
            <div class="tab-pane box" id="sent">
                <div class="boxed-layout">
                    <table cellpadding="0" cellspacing="0" border="0" class="table table-bordered datatable" id="table_request">
                        <?php echo form_open(base_url().'index.php?tenant/maintenance/pending',
                            array('class' => 'form-horizontal form-groups-bordered validate', 'target' => '_top', 'enctype' => 'multipart/form-data'));?>

                      <?php if(sizeof($sent_by_me)>0):?>

                          <?php foreach ($sent_by_me as $item):?>

                        <div class="col-md-4">

                            <?php if($item['status']=="not_fixed"):?>
                            <div class="tile-stats <?php echo 'tile-red';?>">
                                <?php endif;?>

                                <?php if($item['status']=="fixed"):?>
                            <div class="tile-stats <?php echo 'tile-green';?>">
                                <?php endif;?>

                                <div class="icon"><i class="fa fa-share"></i></div>
                                <h3 class="h3"><?php echo 'Sender Name: '.$item['tenant_name'];?></h3>
                                <h4 class="h4"><?php echo 'Floor Number: '. $num;?></h4>
                                <h4 class="h4"><?php echo 'Room Number: '. $room;?></h4>
                                <h4 class="h4"><?php echo'Maintenance Type: '.  $item['maintenance_type'];?></h4>

                                <?php if($item['status']=='not_fixed'):?>
                                <h4 class="h4"><?php echo'Status: '. 'Pending Request';?></h4>
                                    <div>
                                        <a href="#" onclick="confirm_modal('<?php echo base_url();?>index.php?tenant/maintenance/pending/cancel/<?php echo $item['id']; ?>')">
                                            <i class="entypo-trash"></i>
                                            <?php echo 'Cancel' //TODO Add Phrase;?>
                                        </a>
                                    </div>

                                <?php endif;?>
                            </div>
                        </div>
                          <?php endforeach;?>
                      <?php else: ?>
                          <span class="text-center center-block" style="margin-top: 40px">
                            <p class="text-info">No Request Sent</p>
                         </span>

                        <?php endif;?>
                        <?php echo form_close();?>

                    </table>
                </div>


            </div>
            <!----Pending Request Form--->

    </div>
</div>
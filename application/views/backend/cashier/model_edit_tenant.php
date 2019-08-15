<?php
/**
 * Created by PhpStorm.
 * User: Million
 * Date: 10/16/2018
 * Time: 1:19 PM
 */
?>
<div class="row">
    <div class="col-md-12">
        <ul class="nav nav-tabs bordered">

            <li class="active">
                <a href="#list" data-toggle="tab"><i class="entypo-user"></i>
                    <?php echo get_phrase('manage_profile'); ?>
                </a></li>
        </ul>

        <div class="tab-content">
            <!----EDITING FORM STARTS---->
            <div class="tab-pane box active" id="list" style="padding: 5px">
                <div class="box-content">

                    <?php foreach ($tenant_info as $item):?>

                        <?php echo form_open(base_url().'index.php?cashier/updated/',
                            array('class' => 'form-horizontal form-groups-bordered validate', 'target' => '_top', 'enctype' => 'multipart/form-data'));?>

                    <input hidden name="id" value="<?php echo $item['id'];?>">

                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?php echo get_phrase('First name');?></label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="f_name" value="<?php echo $item['firstname'];?>"
                                       required="required" minlength="3" placeholder="Name..."/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?php echo get_phrase('Middle name');?></label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="m_name" value="<?php echo $item['middlename'];?>"
                                       required="required" minlength="3" placeholder="Father name..."/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?php echo get_phrase('Last name');?></label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="l_name" value="<?php echo $item['lastname'];?>"
                                       required="required" minlength="3" placeholder="Grandfather name..."/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?php echo get_phrase('Gender');?></label>
                            <div class="col-sm-5">
                                <label class="col-sm-3 control-label"><?php echo get_phrase('Male');?>
                                    <?php echo form_radio('gender','M','true',array('class'=>'radio-replace'))?>
                                </label>
                                <label class="col-sm-3 control-label"><?php echo get_phrase( 'Female'); ?>
                                    <?php echo form_radio('gender','F','',array('class'=>'radio-replace'))?>
                                </label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?php echo get_phrase('Phone Number'); ?></label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="phone_number" value="<?php echo $item['phone_number'];?>" required="required"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?php echo get_phrase('Alternate Phone Number');?></label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="other_number" value="<?php echo $item['alternatePhoneNumber'];?>" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?php echo get_phrase('Email');?></label>
                            <div class="col-sm-5">
                                <input type="email" class="form-control" name="email" required="required" value="<?php echo $item['email'];?>"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <?php if($this->session->flashdata('national_id_error')):?>
                                <div class="alert alert-danger">
                                    <?php  echo "<span>".$this->session->flashdata('national_id_error')."</span>";?>
                                </div>
                            <?php endif;?>
                            <label class="col-sm-3 control-label"><?php echo get_phrase('National Id');?></label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="national_id" id="n_id" value="<?php echo $item['national_id'];?>" required="required"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="field-1"
                                   class="col-sm-3 control-label"><?php echo get_phrase('NationalIdCard'); ?></label>

                            <div class="col-sm-5">
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-new thumbnail"
                                         data-trigger="fileinput">
                                        <img src="<?php echo base_url().'uploads/NationalIdImages/'.$item['nationalID_card'];?>" class="img-rounded"
                                             height="200px" width="200px"
                                             alt="...">
                                    </div>
                                    <div class="fileinput-preview fileinput-exists thumbnail"
                                         style="max-width: 200px; max-height: 150px"></div>
                                    <div>
                                            <span class="btn btn-white btn-file">
                                                <span class="fileinput-new">Select image</span>
                                                <span class="fileinput-exists">Change</span>
                                                <input type="file" name="nationalId_photo" accept="image/*" >
                                            </span>
                                        <a href="#" class="btn btn-orange fileinput-exists" data-dismiss="fileinput">Remove</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?php echo get_phrase('Floor'); ?></label>
                            <div class="col-sm-5" onchange="">
                                <?php $option=array(''=>"Select Floor",'1'=>"GROUND");
                                foreach ($floor as $f):?>
                                    <?php if($f['floor_number']!="GROUND"):
                                        $num=$f['id']-1;
                                        $floor_coll=array($f['id']=>"FLOOR-".$num);
                                        array_push($option,$floor_coll);
                                        ?>
                                    <?php endif;?>
                                <?php endforeach;?>
                                <?php
                                echo form_dropdown('floor',$option,$item['floor_number'],array('class'=>'select2','id'=>'floor_num','required'=>'required'));?>
                            </div>
                        </div>

                        <input hidden name="prevRoom" value="<?php echo $item['room_number']?>">

                        <div class="form-group">
                            <?php if($this->session->flashdata('room_error')):?>
                                <div class='alert alert-danger'>
                                    <?php  echo "<span>".$this->session->flashdata('room_error')."</span>";?>
                                </div>
                            <?php endif;?>
                            <label class="col-sm-3 control-label"><?php echo get_phrase( 'Room');?></label>
                            <div class="col-sm-5">
                                <select class="select2" id="room" name="room" required>
                                    <option value="<?php echo $item['room_number']?>">Select Room</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <?php if($this->session->flashdata('contract_error')):?>
                                <div class='alert alert-danger'>
                                    <?php  echo "<span>".$this->session->flashdata('contract_error')."</span>";?>
                                </div>
                            <?php endif;?>
                            <label class="col-sm-3 control-label"><?php echo get_phrase('Contract End Year');?></label>

                            <div class="col-sm-5 alert alert-warning">
                                <input type="date" class="form-control datepicker-inline" name="contract_end"
                                       value="<?php echo date('Y-m-d',strtotime($item['contract_endDate']));?>" required="required"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?php echo  get_phrase('Tenant Type')?></label>
                            <div class="col-sm-5">
                                <?php
                                $option=array(
                                    ''=>'Select Tenant',
                                    'Private'=>'Private',
                                    'Company'=>'Company',
                                );
                                echo form_dropdown('tenant_type',$option,$item['Tenant_type'],array('class'=>'select2','id'=>'t_type','required'=>'required'));?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?php echo get_phrase('Company Name'); ?></label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="company_name"
                                       value="<?php echo $item['company_name']?>" required/>
                            </div>
                        </div>

                        <div class="form-group" >
                            <label class="col-sm-3 control-label"><?php echo get_phrase('Business Type');?></label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="business_type"
                                       value="<?php echo $item['company_description'];?>"
                                       placeholder="eg.Restaurant..."/>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-6 col-sm-5">
                                <button type="submit"
                                        class="btn btn-info"><?php echo get_phrase('Update'); ?></button>
                            </div>
                        </div>

                        <?php echo form_close();?>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>


<script>

    $(document).ready(function(){

        $('#floor_num').change(function ()
        {
            var floor_choice=$('#floor_num option:selected').val();

            var base_url= "<?php echo base_url().'index.php?cashier/fetch_room';?>";

            if(floor_choice!=null)
            {
                $.ajax({
                    url: base_url,
                    method:"POST",
                    data:{'floor_id':floor_choice},
                    success:function (data) {
                        $('#room').html(data);
                    }
                });
            }
        });

    });

</script>
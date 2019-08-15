<?php
/**
 * Created by PhpStorm.
 * User: Million
 * Date: 9/11/2018
 * Time: 1:27 PM
 */
?>

<div class="row">
    <div class="col-md-12">

        <!------CONTROL TABS START------>
        <ul class="nav nav-tabs bordered">
            <li class="active">
                <a href="#add_tenant" data-toggle="tab"><i class="entypo-user"></i>
                    <?php echo get_phrase('Add Tenant');?>
                </a></li>
            <li>
                <a href="#payment" data-toggle="tab"><i class="entypo-paypal"></i>
                    <?php echo get_phrase('Process Payment');?>
                </a></li>
            <li>
                <a href="#edit_tenant" data-toggle="tab"><i class="entypo-list"></i>
                    <?php echo get_phrase('Edit Tenant');?>
                </a></li>

        </ul>
        <!------CONTROL TABS END------>
        <div class="tab-content">
            <!----Add Tenant Start-->
            <div class="tab-pane box active" id="add_tenant">

                <div class="boxed-layout">
                    <?php echo form_open(base_url().'index.php?cashier/payment/add_tenant',
                        array('class' => 'form-horizontal form-groups-bordered validate', 'target' => '_top', 'enctype' => 'multipart/form-data'));?>

                    <div class="form-group">
                        <label class="col-sm-3 control-label"><?php echo get_phrase('First name');?></label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" name="f_name" required="required" minlength="3" placeholder="Name..."/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label"><?php echo get_phrase('Middle name');?></label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" name="m_name" required="required" minlength="3" placeholder="Father name..."/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label"><?php echo get_phrase('Last name');?></label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" name="l_name" required="required" minlength="3" placeholder="Grandfather name..."/>
                        </div>
                    </div>

                    <div class="form-group">
                        <?php if($this->session->flashdata('tenant_upload_error')):?>
                            <div class="alert alert-danger">
                                <?php  echo "<span>".$this->session->flashdata('tenant_upload_error')."</span>";?>
                            </div>
                        <?php endif;?>
                        <label class="col-sm-3 control-label"><?php echo get_phrase('Tenant Photo');?></label>
                        <div class="col-sm-6">
                            <input type="file" name="tenant_photo" class="fileinput-inline" required accept="image/*">
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
                            <input type="text" class="form-control" name="phone_number" required="required"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label"><?php echo get_phrase('Alternate Phone Number');?></label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" name="other_number" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label"><?php echo get_phrase('Email');?></label>
                        <div class="col-sm-5">
                            <input type="email" class="form-control" name="email" required="required"/>
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
                            <input type="text" class="form-control" name="national_id" id="n_id" required="required"/>
                        </div>

                    </div>

                    <div class="form-group">
                        <?php if($this->session->flashdata('nationalId_image_upload_error')):?>
                            <div class="alert alert-danger">
                                <?php  echo "<span>".$this->session->flashdata('nationalId_image_upload_error')."</span>";?>
                            </div>
                        <?php endif;?>
                        <label class="col-sm-3 control-label"><?php echo get_phrase('Upload National Id Card');?></label>
                        <div class="col-sm-6">
                            <input type="file" name="nationalId_photo" class="fileinput-inline" required accept="image/*">
                        </div>

                    </div>


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
                            <?php echo form_dropdown('floor',$option,'',array('class'=>'select2','id'=>'floor_num','required'=>'required'));?>
                        </div>
                    </div>

                    <div class="form-group">
                        <?php if($this->session->flashdata('room_error')):?>
                            <div class='alert alert-danger'>
                                <?php  echo "<span>".$this->session->flashdata('room_error')."</span>";?>
                            </div>
                        <?php endif;?>
                        <label class="col-sm-3 control-label"><?php echo get_phrase( 'Room');?></label>
                        <div class="col-sm-5">
                            <select class="select2" id="room" name="room" required>
                                <option value="">Select Room</option>
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
                        <div class="col-sm-5">
                            <input type="date" class="form-control datepicker-inline" name="contract_end" required="required"/>
                        </div>

                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label"><?php echo get_phrase('Tenant Type')?></label>
                        <div class="col-sm-5">
                            <?php
                            $option=array(
                                    ''=>'Select Tenant',
                                'Private'=>'Private',
                                'Company'=>'Company',
                                'GOVERMENT'=>'GOVERMENT'
                            );
                            echo form_dropdown('tenant_type',$option,'',array('class'=>'select2','id'=>'t_type','required'=>'required'));?>
                        </div>
                    </div>

                    <div class="form-group">
                            <label class="col-sm-3 control-label"><?php echo get_phrase('Company Name'); ?></label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="company_name" required/>
                            </div>
                        </div>

                    <div class="form-group" >
                            <label class="col-sm-3 control-label"><?php echo get_phrase('Business Type');?></label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="business_type" placeholder="eg.Restaurant..."/>
                            </div>
                        </div>

                    <div class="form-group">
                        <div class="col-sm-offset-6 col-sm-5">
                            <button type="submit"
                                    class="btn btn-info"><?php echo get_phrase('Register'); ?></button>
                        </div>
                    </div>

                    <?php echo form_close();?>
                </div>

            </div>
            <!----Add Tenant End-->

            <!--Process Payment Start--->
            <div class="tab-pane box" id="payment">
                <div class="boxed-layout">
                    <?php echo form_open(base_url().'index.php?cashier/payment/process_payment',
                        array('class' => 'form-horizontal form-groups-bordered validate', 'target' => '_top', 'enctype' => 'multipart/form-data'));?>

                    <div class="form-group">
                        <label class="col-sm-3 control-label"><?php echo get_phrase('Tenant Name');?></label>
                        <div class="col-sm-5" >
                            <?php $option=array(''=>"Select Tenant");
                            foreach ($tenant as $item):?>
                                <?php $tenant_coll=array($item['id']=>$item['firstname'].' '.$item['lastname']);
                                array_push($option,$tenant_coll);
                                ?>
                            <?php endforeach;?>
                            <?php echo form_dropdown('tenant_name',$option,'',array('class'=>'select2','required'=>'required','id'=>'t_id'));?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label"><?php echo get_phrase('Payment Term');?></label>
                        <div class="col-sm-5" >
                            <select class="select2" name="payment_term" id="payment_box" required>
                                <option value="">Select Term</option>
                                <option value="month">Monthly</option>
                                <option value="threeMonth">Three Month</option>
                                <option value="sixMonth">six Month</option>
                                <option value="year">Yearly</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                    </div>


                    <div class="form-group" hidden id="other_payment_box">
                        <label class="col-sm-3 control-label"><?php echo get_phrase('Other Payment Term');?></label>
                        <div class="col-sm-6">
                            <input class="form-control" name="other_term" type="number" id="other_term" min="1" required placeholder="Please! specify IN MONTHS...">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label"><?php echo get_phrase('Amount Expected');?></label>
                        <div class="col-sm-5" >
                                <input class="form-control"  value="" id="expected_amount" disabled="disabled">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label"><?php echo get_phrase('Payment Type'); ?></label>
                        <div class="col-sm-6">
                            <label class="col-sm-3 control-label"><?php echo get_phrase('InCash');?>
                                <?php echo form_radio('payment_type','inCash','true',array('class'=>'radio-replace','id'=>'cash'))?>
                            </label>
                            <label class="col-sm-3 control-label"><?php echo get_phrase('onAccount');?>
                                <?php echo form_radio('payment_type','onAccount','',array('class'=>'radio-replace','id'=>'bank'))?>
                            </label>
                        </div>
                    </div>

                    <!--In cash Payment start-->
                    <div class="form-group" id="cash_box">

                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?php echo get_phrase('Amount Paid'); ?></label>
                            <div class="col-sm-6">
                                <input class="form-control" name="cash_amount" type="number" id="cash_paid" min="1" required placeholder="In Birr..">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?php echo get_phrase('Amount Remain'); ?></label>
                            <div class="col-sm-6">
                                <input class="form-control" name="cash_remain" type="number" id="cash_remain" min="0" placeholder="In Birr..">
                            </div>
                        </div>

                        <div class="form-group" id="return" hidden>
                            <label class="col-sm-3 control-label"><?php echo get_phrase('Amount Returned'); ?></label>
                            <div class="col-sm-6">
                                <input class="form-control"  type="number" id="cash_return" min="0" placeholder="In Birr..">
                            </div>
                        </div>

                    </div>
                    <!--In cash Payment end-->

                    <!--on Account  Payment start-->
                    <div class="form-group" id="account_box" hidden>

                        <br>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?php echo get_phrase('Amount Paid');?></label>
                            <div class="col-sm-6">
                                <input class="form-control" name="deposit_amount" id="account_paid" type="number" min="1" required placeholder="In Birr..">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?php echo get_phrase('Amount Remain'); ?></label>
                            <div class="col-sm-6">
                                <input class="form-control" name="deposit_remain" type="number" id="account_remain" min="0" placeholder="In Birr..">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?php echo get_phrase('Upload Bank Receipt');?></label>
                            <div class="col-sm-6">
                                <input type="file" name="receipt_photo" class="fileinput-inline" required accept="image/*">
                            </div>
                            <?php if($this->session->flashdata('upload_error')):?>
                                <div>
                                    <?php  echo "<br><span class='alert alert-danger'>".$this->session->flashdata('upload_error')."</span><br><br>";?>
                                </div>
                            <?php endif;?>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?php echo get_phrase('Receipt Number');?></label>
                            <div class="col-sm-6">
                                <input type="text" name="receipt_number" class="form-control" required>
                            </div>
                        </div>

                    </div>
                    <!--on AccountPayment End-->

                    <div class="form-group">
                        <div class="col-sm-offset-6 col-sm-5">
                            <button type="submit"
                                    class="btn btn-info"><?php echo get_phrase('Confirm Payment');?></button>
                        </div>
                    </div>

                </div>
            </div>
            <!--Process Payment End--->

            <!---Crud Tenant Start--->
            <div class="tab-pane box" id="edit_tenant">
                <div class="boxed-layout">
                    <div class="col-md-6">
                        <h5 class="uk-text-justify" style="font-size: larger"><span class="entypo-archive"></span>Tenant List</h5>
                    </div>

                    <table cellpadding="2" cellspacing="1" border="1" class="table table-bordered table-responsive datatable" id="TenantTable" >
                        <th class="text-center"><?php echo 'ID'?></th>
                        <th class="text-center"><?php echo 'First Name'?></th>
                        <th class="text-center"><?php echo 'Middle Name'?></th>
                        <th class="text-center"><?php echo 'Last Name'?></th>
                        <th class="text-center"><?php echo 'National Id'?></th>
                        <th class="text-center"><?php echo 'Phone Number'?></th>
                        <th class="text-center"><?php echo 'Other Number'?></th>
                        <th class="text-center"><?php echo 'email'?></th>
                        <th class="text-center"><?php echo 'Room'?></th>
                        <th class="text-center"><?php echo 'Floor'?></th>
                        <th class="text-center"><?php echo 'Company Name'?></th>
                        <th class="text-center"><?php echo 'Company Description'?></th>
                        <th class="text-center"><?php echo 'Contarct End Date'?></th>
                        <th></th>
                        <th></th>

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
                            <td><?php echo $t_account['contract_endDate'];?></td>
                            <td>
                                <a class="btn btn-info"  href="#"
                                   onclick="confirm_edit('<?php echo base_url();?>index.php?cashier/tenantUpdate/<?php echo $t_account['id']?>');">
                                    <?php echo 'Edit' //TODO Add Phrase;?>
                                </a>
                            <td>
                                <a class="btn btn-danger" id="delete_link" href="#"
                                   onclick="confirm_modal('<?php echo base_url();?>index.php?cashier/payment/delete_tenant/<?php echo $t_account['id']?>');">
                                    <?php echo 'Delete' //TODO Add Phrase;?>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach;?>
                    </table>
                </div>
            </div>
            <!---Crud Tenant End--->


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

        $('#cash').change(function () {
            $('#cash_box').show();
            $('#cash').prop("checked",true);
            $('#account_box').hide();
            $('#bank').prop("checked",false);
        });

        $('#bank').change(function () {
            $('#account_box').show();
            $('#bank').prop("checked",true);
            $('#cash_box').hide();
            $('#cash').prop("checked",false);
        });

        $('#payment_box').change(function () {

            var paymentType=$('#payment_box option:selected').val();

            if(paymentType==='other')
            {
                $('#other_payment_box').show();
            }
            else
            {
                $('#other_payment_box').hide();
            }

        })

        $('#t_id').change(function ()
        {
            var tenant_id=$('#t_id option:selected').val();

            var base_url= "<?php echo base_url().'index.php?cashier/fetch_paymentAmount/';?>";

            if(tenant_id!=null)
            {
                $.ajax({
                    url: base_url,
                    method:"POST",
                    data:{'tenant_id':tenant_id},
                    success:function (data) {

       $('#payment_box').change(function () {
           var payament_term=$('#payment_box option:selected').val();

           if(payament_term==="month")
           {
                $('#expected_amount').attr("value",data);
           }
           if(payament_term==="threeMonth")
           {

               $('#expected_amount').attr("value",data*3);
           }

           if(payament_term==="sixMonth")
           {
               $('#expected_amount').attr("value",data*6);
           }

           if(payament_term==="year")
           {
               $('#expected_amount').attr("value",data*12);
           }

           if(payament_term==="other")
           {
               $('#other_term').keyup(function () {
                   var other_term=$('#other_term').val();
                   $('#expected_amount').attr("value",data*other_term);
               })
           }

       })
                    }
                });
            }
        });

        $('#cash_paid').keyup(function () {
            var paid=$('#cash_paid').val();

            var expected=$('#expected_amount').val();

            var remain=expected-paid;

            if(remain>0)
            {
                $('#cash_remain').attr("value",remain);
                $('#return').hide();
            }
            else {
                $('#return').show();
                $('#cash_remain').attr("value",0);
                $('#cash_return').attr("value",remain*-1);
            }

        })

        $('#account_paid').keyup(function () {
            var paid=$('#account_paid').val();

            var expected=$('#expected_amount').val();

            var remain=expected-paid;

            if(remain>0)
            {
                $('#account_remain').attr("value",remain);
            }
            else {
                $('#account_remain').attr("value",0);
            }

        })

    });

</script>
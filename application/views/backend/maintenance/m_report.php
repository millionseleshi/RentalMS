<?php
/**
 * Created by PhpStorm.
 * User: Million
 * Date: 9/9/2018
 * Time: 3:33 PM
 */

?>

<div class="row">
    <div class="col-md-12">

        <div class="col-md-6">
            <h5 class="uk-text-justify" style="font-size: larger"><span class="entypo-archive"></span>Maintenance List</h5>
        </div>

        <table cellpadding="3" cellspacing="0" border="1" class="table table-bordered table-responsive datatable" id="MaintenanceRequest" >
           <!--TODO Add Phrases -->
            <th><?php echo 'ID'?></th>
            <th><?php echo 'Tenant Name'?></th>
            <th><?php echo 'Floor Number'?></th>
            <th><?php echo 'Room Number'?></th>
            <th><?php echo 'Maintenance Type'?></th>
            <th><?php echo 'Requested Date'?></th>
            <th><?php echo 'Fixed Date'?></th>

                <?php foreach ($maintenance_request as $m_request):?>
                <tr>
                    <td><?php echo $m_request['id'];?></td>
                    <td><?php echo $m_request['tenant_name'];?></td>
                    <td><?php $num=$m_request['floor_number']-1; echo $num ;?></td>
                    <td><?php $room_num=$this->db->get_where('room',array('id'=>$m_request['room_number']))->row()->room_number;
                        echo $room_num ;?></td>
                    <td><?php echo $m_request['maintenance_type'];?></td>
                    <td><?php echo $m_request['requested_date'];?></td>

                    <?php if ($m_request['fixed_date']==null):?>

                         <td><?php echo 'Pending...';?></td>

                    <?php else: ?>

                   <td><?php echo $m_request['fixed_date'];?></td>

                    <?php endif;
                    endforeach;?>
                </tr>
        </table>

        <div>
            <button type="button"
                    class="btn btn-default btn-info"  id="print_request"><?php echo 'Print'; //TODO Add Phrase ?></button>
        </div>

        <div class="col-md-6">
            <h5 class="uk-text-justify" style="font-size: larger"><span class="entypo-target"></span>Spare Part</h5>
        </div>
        <!--Spare Part Table-->
        <table cellpadding="0" cellspacing="0" border="0" class="table table-bordered table-responsive datatable" id="SparePart">

           <!--TODO Add Phrases -->
            <th><?php echo 'ID'?></th>
            <th><?php echo 'Spare Part Name'?></th>
            <th><?php echo 'Spare Part Amount'?></th>
            <th><?php echo 'Floor Number'?></th>
            <th><?php echo 'Room Number'?></th>


                <?php foreach ($spare_part as $sp_request):?>
                <tr>
                    <td><?php echo $sp_request['id'];?></td>
                    <td><?php echo $sp_request['part_name'];?></td>
                    <td><?php echo $sp_request['part_amount'];?></td>
                    <td><?php echo $sp_request['floor_number'];?></td>
                    <td><?php echo $sp_request['room_number'];?></td>
            <?php endforeach;?>
                </tr>
        </table>
        <button type="button"
                class="btn btn-default btn-info"  id="print_spare"><?php echo 'Print'; //TODO Add Phrase ?></button>
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

       $('#print_request').click(function () {
           $('#MaintenanceRequest').tableExport({
               headers: true,
               footers:true,
               formats: ["xls", "csv", "txt"],
               bootstrap: true,
               exportButtons: true,
               position: "top",
           });
       });

       $('#print_spare').click(function () {
           $('#SparePart').tableExport({
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
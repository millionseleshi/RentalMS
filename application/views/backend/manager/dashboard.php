<div class="row">
	<div class="col-md-8">
    	<div class="row">
            <!-- CALENDAR-->
            <div class="col-md-12 col-xs-12">    
                <div class="panel panel-primary " data-collapsed="0">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="fa fa-calendar"></i>
                            <?php echo get_phrase('event_schedule');?>
                        </div>
                    </div>
                    <div class="panel-body" style="padding:0px;">
                        <div class="calendar-env">
                            <div class="calendar-body">
                                <div id="notice_calendar"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
<!--	<div class="col-md-4">-->
<!--		<div class="row">-->
<!--            <div class="col-md-12">-->
<!--            -->
<!--                <div class="tile-stats tile-red">-->
<!--                    <div class="icon"><i class="fa fa-group"></i></div>-->
<!--                    <div class="num" data-start="0" data-end="--><?php //echo $this->db->count_all('admin');?><!--" -->
<!--                    		data-postfix="" data-duration="1500" data-delay="0">0</div>-->
<!--                    -->
<!--                    <h3>--><?php //echo get_phrase('student');?><!--</h3>  <!--TODO Add Tenant in Language-->-->
<!--                   <p>Total Tenant</p>-->
<!--                </div>-->
<!--                -->
<!--            </div>-->
<!--    	</div>-->
<!--    </div>-->
</div>


<script>
  $(document).ready(function() {
	  
	  var calendar = $('#notice_calendar');
				
				$('#notice_calendar').fullCalendar({
					header: {
						left: 'title',
						right: 'today prev,next'
					},
					
					//defaultView: 'basicWeek',
					
					editable: false,
					firstDay: 1,
					height: 530,
					droppable: false,
					
					events: [
						<?php 
						$notices	=	$this->db->get('noticeboard')->result_array();
						foreach($notices as $row):
						?>
						{
							title: "<?php echo $row['notice_title'];?>",
							start: new Date(<?php echo date('Y',$row['create_timestamp']);?>, <?php echo date('m',$row['create_timestamp'])-1;?>, <?php echo date('d',$row['create_timestamp']);?>),
							end:	new Date(<?php echo date('Y',$row['create_timestamp']);?>, <?php echo date('m',$row['create_timestamp'])-1;?>, <?php echo date('d',$row['create_timestamp']);?>) 
						},
						<?php 
						endforeach
						?>
						
					]
				});
	});
  </script>

  

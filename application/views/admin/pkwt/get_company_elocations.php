<?php $result = $this->Department_model->ajax_company_location_information($company_id);?>
<div class="form-group">
 
  <select class="form-control" name="location_id" id="aj_location_id" data-plugin="select_hrm" >
    <option value=""></option>
    <?php foreach($result as $location) {?>
    <option value="<?php echo $location->location_id?>"><?php echo $location->location_name?></option>
    <?php } ?>
  </select>
</div>
<?php
//}
?>
<script type="text/javascript">
$(document).ready(function(){
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' });
	// get departments
	jQuery("#aj_location_id").change(function(){
		jQuery.get(base_url+"/get_location_departments/"+jQuery(this).val(), function(data, status){
			jQuery('#department_ajax').html(data);
		});
	});
});
</script>
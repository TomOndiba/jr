<?php
	/**
	* Profile Manager
	* 
	* Overrules group edit form to support options (radio, pulldown, multiselect)
	* 
	* @package profile_manager
	* @author ColdTrick IT Solutions
	* @copyright Coldtrick IT Solutions 2009
	* @link http://www.coldtrick.com/
	*/
	
	$ts = time();
	$token = generate_action_token($ts);

?>
<div class="contentWrapper">
<form action="<?php echo $vars['url']; ?>action/groups/edit" enctype="multipart/form-data" method="post">
	<input type="hidden" name="__elgg_ts" value="<? echo $ts; ?>" />
	<input type="hidden" name="__elgg_token" value="<? echo $token; ?>" />
	<p>
		<label><?php echo elgg_echo("groups:icon"); ?><br />
		<?php

			echo elgg_view("input/file",array('internalname' => 'icon'));
		
		?>
		</label>
	</p>
	<p>
		<label>
			<?php echo elgg_echo("groups:name"); ?><br />
			<?php echo elgg_view("input/text",array(
															'internalname' => "name",
															'value' => $vars['entity']->name
															)); ?>
		</label>
	</p>
<?php

	// retrieve group fields
	$group_fields = profile_manager_get_categorized_group_fields();
	
	if(count($group_fields["fields"]) > 0){
		$group_fields = $group_fields["fields"];
		
		foreach($group_fields as $field) {
			$metadata_name = $field->metadata_name;
			$options = $field->metadata_options;

			// get options
			if(!empty($options)){
				$options = explode(",", $options);
			} else {
				$options = "";
			}
			
			// get type of field
			/*
			if($field->user_editable == "no"){
				$valtype = "non_editable";
			} else {
			*/
				$valtype = $field->metadata_type;
			/*	
			}
			*/
			
			// make title
			if(!empty($field->metadata_label)){
				$title = $field->metadata_label;
			} else {
				$trans_key = "groups:" . $metadata_name;
				if($trans_key != elgg_echo($trans_key)){
					$title = elgg_echo($trans_key);
				} else {
					$title = $metadata_name;
				}
			}
			
			// get value
			$value = '';
			if($metadata = get_metadata_byname($vars['entity']->guid, $metadata_name)) {
				if (is_array($metadata)) {
					foreach($metadata as $md) {
						if (!empty($value)) $value .= ', ';
						$value .= $md->value;
					}
				} else {
					$value = $metadata->value;
				}
			}		
			
	?>
		<p>
			<label>
				<?php echo $title; ?><br />
				<?php echo elgg_view("input/{$valtype}",array(
																'internalname' => $metadata_name,
																'value' => $value,
																'options' => $options
																)); ?>
			</label>
		</p>
	<?php
		}
	}
?>

	<p>
		<label>
			<?php echo elgg_echo('groups:membership'); ?><br />
			<?php echo elgg_view('input/access', array('internalname' => 'membership','value' => $vars['entity']->membership, 'options' => array( ACCESS_PRIVATE => elgg_echo('groups:access:private'), ACCESS_PUBLIC => elgg_echo('groups:access:public')))); ?>
		</label>
	</p>
	
	
    <?php
		if (isset($vars['config']->group_tool_options)) {
			foreach($vars['config']->group_tool_options as $group_option) {
				$group_option_toggle_name = $group_option->name."_enable";
				if ($group_option->default_on) {
					$group_option_default_value = 'yes';
				} else {
					$group_option_default_value = 'no';
				}
?>	
    <p>
			<label>
				<?php echo $group_option->label; ?><br />
				<?php

					echo elgg_view("input/radio",array(
									"internalname" => $group_option_toggle_name,
									"value" => $vars['entity']->$group_option_toggle_name ? $vars['entity']->$group_option_toggle_name : $group_option_default_value,
									'options' => array(
														elgg_echo('groups:yes') => 'yes',
														elgg_echo('groups:no') => 'no',
													   ),
													));
				?>
			</label>
	</p>
	<?php
		}
	}
	?>
	<p>
		<?php
			if ($vars['entity'])
			{ 
			?><input type="hidden" name="group_guid" value="<?php echo $vars['entity']->getGUID(); ?>" /><?php 
			}
		?>
		<input type="hidden" name="user_guid" value="<?php echo page_owner_entity()->guid; ?>" />
		<input type="submit" class="submit_button" value="<?php echo elgg_echo("save"); ?>" />
		
	</p>

</form>
</div>

<div class="contentWrapper">
<div id="delete_group_option">
	<form action="<?php echo $vars['url'] . "action/groups/delete"; ?>">
		<input type="hidden" name="__elgg_ts" value="<? echo $ts; ?>" />
		<input type="hidden" name="__elgg_token" value="<? echo $token; ?>" />
		<?php
			if ($vars['entity'])
			{ 
				$warning = elgg_echo("groups:deletewarning");
			?>
			<input type="hidden" name="group_guid" value="<?php echo $vars['entity']->getGUID(); ?>" />
			<input type="submit" name="delete" value="<?php echo elgg_echo('groups:delete'); ?>" onclick="javascript:return confirm('<?php echo $warning; ?>')"/><?php 
			}
		?>
	</form>
</div><div class="clearfloat"></div>
</div>
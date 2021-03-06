<?php 
	/**
	* Profile Manager
	* 
	* Object view of a custom profile field category
	* 
	* @package profile_manager
	* @author ColdTrick IT Solutions
	* @copyright Coldtrick IT Solutions 2009
	* @link http://www.coldtrick.com/
	*/

	$object = $vars["entity"];

	// label
	if(!empty($object->metadata_label)){
		$title = $object->metadata_label;
	} else {
		$translation_label = "profile:categories:" . $object->metadata_name;
		if($translation_label == elgg_echo($translation_label)){
			$title = $object->metadata_name;
		} else {
			$title = elgg_echo("profile:categories:" . $object->metadata_name);
		}
	}

	$rels = "";
	
	$rel_count = get_entities_from_relationship(CUSTOM_PROFILE_FIELDS_PROFILE_TYPE_CATEGORY_RELATIONSHIP, $object->guid, true, "object", CUSTOM_PROFILE_FIELDS_PROFILE_TYPE_SUBTYPE, null, null, null, null, true);
	
	if($rel_count > 0){
		$cats = get_entities_from_relationship(CUSTOM_PROFILE_FIELDS_PROFILE_TYPE_CATEGORY_RELATIONSHIP, $object->guid, true, "object", CUSTOM_PROFILE_FIELDS_PROFILE_TYPE_SUBTYPE, null, null, $rel_count);
		
		$guids = array();
		foreach($cats as $cat){
			$guids[] = $cat->guid;
		}
		
		$rels = implode(",", $guids);
	}
	
?>
<div class="custom_fields_category" id="custom_profile_field_category_<?php echo $object->guid;?>">
	<div class="custom_fields_category_edit" onclick="editCategory('<?php echo $object->guid;?>','<?php echo $object->metadata_name;?>','<?php echo $object->metadata_label;?>', '<?php echo $rels; ?>');"></div>
	<a href="javascript:void(0);" onclick="filterCustomFields(<?php echo $object->guid; ?>)"><?php echo $title; ?></a>
</div>
<?php

    /**
	 * Battle page
	 * 
	 * @package Battle
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Eric Zanol
	 * @copyright 
	 * @link 
	 */
	 
	 // Load Elgg engine
	require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");
		
	// You need to be logged in!
	gatekeeper();
		
	// Get the logged in user, you can't see other peoples messages so use session id
	$page_owner = $_SESSION['user'];
	//set_page_owner($page_owner->getGUID());
		
    // Get the user's inbox, this will be all messages where the 'toId' field matches their guid 
	//$messages = elgg_get_entities_from_metadata("toId", $page_owner->getGUID(), "object", "messages", $page_owner->guid, $limit + 1, $offset);

	// Set the page title
	//$area2 = elgg_view_title(elgg_echo("battle:lobby"));
	    
	// Display them. The last variable 'page_view' is to allow the view page to know where this data is coming from,
	// in this case it is the inbox, this is necessary to ensure the correct display
	$area2 = elgg_view("battle/view");
	//$area2 .= elgg_view("messages/forms/view",array('entity' => $messages, 'page_view' => "inbox", 'limit' => $limit, 'offset' => $offset));
	
	$area1 = elgg_view("battle/rightcol");
	
	// format
	$body = elgg_view_layout("two_column_right_sidebar", $area1, $area2);

	// Draw page
	page_draw(sprintf(elgg_echo('battle:user'),$page_owner->name),$body);
	 
?>
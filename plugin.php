<?php
/*
Plugin Name: Mass Updater
Plugin URI: https://github.com/Binarypark/yourls-api-mass-update
Description: Mass-update URL host names. You are advised to create an index on the `url` column in the `yourls_url` table.
Version: 0.1
Author: Martin Müller
Author URI: http://binarypark.org
*/

yourls_add_filter( 'api_action_mass-update', 'api_mass_update' );

function api_mass_update() {
	
	if(!isset($_REQUEST['oldhost']) || !isset($_REQUEST['newhost']) ||
			empty($_REQUEST['oldhost']) || empty($_REQUEST['newhost'])) {
		
		return array(
			'statusCode' => 400,
			'status' => 'fail',
			'simple' => 'Need "oldhost" and "newhost" parameters.',
			'message' => 'error: missing param'
		);
	}
	
	global $ydb;
	$query = "UPDATE `".mysql_real_escape_string(YOURLS_DB_TABLE_URL)."` SET `url` = REPLACE(`url`, "
					. "'".mysql_real_escape_string($_REQUEST['oldhost'])."', "
					. "'".mysql_real_escape_string($_REQUEST['newhost'])."') "
					. "WHERE `url` LIKE '".mysql_real_escape_string($_REQUEST['oldhost'])."%'";
	
	$result = $ydb->query($query);
	
	if($ydb->last_error){
		return array(
				'statusCode' => 500,
				'simple' => 'Error: could not mass-update the hosts.',
				'message' => 'error: database error'
				);
	}else{
		return array(
				'statusCode' => 200,
				'simple' => "Success: $result links from ".$_REQUEST['oldhost']." are now mapped to ".$_REQUEST['newhost'].".",
				'message' => "success: updated $result links"
			);
	}
}

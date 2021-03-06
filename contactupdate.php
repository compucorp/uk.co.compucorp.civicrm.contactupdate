<?php

require_once 'contactupdate.civix.php';

/**
 * Implementation of hook_civicrm_config
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_config
 */
function contactupdate_civicrm_config(&$config) {
  _contactupdate_civix_civicrm_config($config);
}

/**
 * Implementation of hook_civicrm_xmlMenu
 *
 * @param $files array(string)
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_xmlMenu
 */
function contactupdate_civicrm_xmlMenu(&$files) {
  _contactupdate_civix_civicrm_xmlMenu($files);
}

/**
 * Implementation of hook_civicrm_install
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_install
 */
function contactupdate_civicrm_install() {
  return _contactupdate_civix_civicrm_install();
}

/**
 * Implementation of hook_civicrm_uninstall
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_uninstall
 */
function contactupdate_civicrm_uninstall() {
  return _contactupdate_civix_civicrm_uninstall();
}

/**
 * Implementation of hook_civicrm_enable
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_enable
 */
function contactupdate_civicrm_enable() {
  return _contactupdate_civix_civicrm_enable();
}

/**
 * Implementation of hook_civicrm_disable
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_disable
 */
function contactupdate_civicrm_disable() {
  return _contactupdate_civix_civicrm_disable();
}

/**
 * Implementation of hook_civicrm_upgrade
 *
 * @param $op string, the type of operation being performed; 'check' or 'enqueue'
 * @param $queue CRM_Queue_Queue, (for 'enqueue') the modifiable list of pending up upgrade tasks
 *
 * @return mixed  based on op. for 'check', returns array(boolean) (TRUE if upgrades are pending)
 *                for 'enqueue', returns void
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_upgrade
 */
function contactupdate_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  return _contactupdate_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implementation of hook_civicrm_managed
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_managed
 */
function contactupdate_civicrm_managed(&$entities) {
  return _contactupdate_civix_civicrm_managed($entities);
}

/**
 * Implementation of hook_civicrm_caseTypes
 *
 * Generate a list of case-types
 *
 * Note: This hook only runs in CiviCRM 4.4+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_caseTypes
 */
function contactupdate_civicrm_caseTypes(&$caseTypes) {
  _contactupdate_civix_civicrm_caseTypes($caseTypes);
}

/**
 * Implementation of hook_civicrm_alterSettingsFolders
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_alterSettingsFolders
 */
function contactupdate_civicrm_alterSettingsFolders(&$metaDataFolders = NULL) {
  _contactupdate_civix_civicrm_alterSettingsFolders($metaDataFolders);
}

/**
 * Implementation of hook_civicrm_summaryActions
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC40/CiviCRM+hook+specification#CiviCRMhookspecification-hook_civicrm_summaryActions(introducedin4.1)
 */
function contactupdate_civicrm_summaryActions( &$actions, $contactID ){
    $results = civicrm_api3('Contact', 'get', array(id => $contactID));
    $contact = array_pop($results['values']);
    $actions['request'] = array(
        'title' => 'Request Info Update',
        'weight' => 99,
        'class' => 'no-popup',
        'ref' => 'request-update',
        'key' => 'request'
    );
    if($contact['contact_type']=='Organization'){
      $actions['request']['href'] = "/workplace/update_workplace_details?cid2=".$contactID;
    }else{
      $workplace_search = civicrm_api3('Relationship', 'get', array('contact_id_a' => $contactID, 'relationship_type_id' => 11));
      if($workplace_search['count']>0){
	$workplace = array_pop($workplace_search['values']);
	$actions['request']['href'] = "/workplace/update_contact_details?cid2=".$contactID."&cid3=".$workplace['contact_id_b'];
      }else{
        $actions['request']['href'] = "/workplace/update_contact_details?cid2=".$contactID;
      }
    }
}

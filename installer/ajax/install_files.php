<?php

include '../lib/InstallerTools.php';
include '../lib/GlobalTools.php';

$installer_tool = new InstallerTools();
$global_tools = new GlobalTools();

$array_parameters = array();
$array_parameters['var_install_path'] = $_POST['path_url'];
$array_parameters['var_install_sys_dir'] = $_POST['path_system'];

$array_parameters['var_database_server'] = $_POST['database_server'];
$array_parameters['var_database_port'] = "3306";
$array_parameters['var_database_user'] = $_POST['database_user'];
$array_parameters['var_database_password'] = $_POST['database_password'];
$array_parameters['var_database_schema'] = $_POST['database_database'];
$array_parameters['var_usr_language'] = $_POST['usr_language'];

$array_parameters['var_admin_user'] = $_POST['admin_user'];
$array_parameters['var_admin_password'] = $_POST['admin_password'];
$array_parameters['var_usr_first_name'] = $_POST['usr_first_name'];
$array_parameters['var_usr_last_name'] = $_POST['usr_last_name'];
$array_parameters['var_usr_email'] = $_POST['usr_email'];


/**
 * Create global configurations
 */
$installer_tool->createParametersFile($array_parameters);

/**
 * Create data directories
 */
$installer_tool->createDirectories($array_parameters);

/**
 * Copy default avatar picture
 */
$installer_tool->copyDefaultAvatar($array_parameters);

echo "ok";
<?php

include '../lib/InstallerTools.php';
$installer_tool = new InstallerTools();

/**
 * Create global configurations
 */
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

$installer_tool->createParametersFile($array_parameters);


include '../lib/DatabaseTools.php';
$database_tool = new DatabaseTools();

/**
 * Create Database
 */
$database_tool->createDatabase($array_parameters, $entityManager);

/**
 * Create admin user
 */

$installer_tool->createAdminUser($array_parameters);

/**
 * Create and register modules
 */
$installer_tool->createAndRegisterModules($entityManager);

/**
 * Create data directories
 */
$installer_tool->createDirectories($array_parameters);

/**
 * Copy default avatar picture
 */
$installer_tool->copyDefaultAvatar($array_parameters);

echo "ok";
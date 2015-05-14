<?php
$output_dir = "../../../tmp/";
include '../../../bootstrapAjax.php';
require '../../../include/entities/Module.php';
require '../../../include/entities/ModuleAction.php';
require '../../../include/entities/Groups.php';

include '../Lib/ModUtils.php';

if (isset($_FILES["myfile"])) {
    $ret = array();

    $error = $_FILES["myfile"]["error"];

    if (!is_array($_FILES["myfile"]["name"])) //single file
    {
        $fileName = $_FILES["myfile"]["name"];
        move_uploaded_file($_FILES["myfile"]["tmp_name"], $output_dir . $fileName);
        $ret[] = $fileName;

        /** Extraction module zip archive */
        $zip = new ZipArchive;
        if ($zip->open("../../../tmp/" . $fileName) === TRUE) {
            $zip->extractTo('../../../modules/');

            /** Get first directory name */
            $info = $zip->statIndex(0);
            $moduleDirectory = str_replace('/', '', $info['name']);

            $zip->close();
        }

        /** Get Module name in ini file */
        $serverRoot = $_SERVER['DOCUMENT_ROOT'] . '/' . install_path;
        $config = parse_ini_file($serverRoot . 'modules/' . $moduleDirectory . '/module.ini');

        /** Delete uploaded file */
        unlink("../../../tmp/" . $fileName);

        /** If module already exist with this name, delete if before re-insert*/
        $moduleRepository = $entityManager->getRepository('Module');
        $module = $moduleRepository->findOneBy(array('mod_name' => $config['module_name']));

        if ($module) {
            $entityManager->remove($module);
            $entityManager->flush();
        }

        $modUtils = new ModUtils($entityManager);

        $mod = new Module();
        $mod->setModName($config['module_name']);
        $mod->setModDirectoryName('modules/' . $moduleDirectory);
        $mod->setModIsInstalled(0);
        $mod->setModAuthor($config['module_author']);
        $mod->setModDescription($config['module_description']);
        $mod->setModDateInstall(new DateTime());
        $mod->setModIfConnexionRequire(false);

        $entityManager->persist($mod);
        $entityManager->flush();

        /** Install entities if needed */
        if(file_exists($serverRoot.'modules/'.$moduleDirectory.'/entities/')){
            $output = shell_exec('cd ../../../modules/' . $moduleDirectory.' && ..\\..\\vendor\\bin\\doctrine orm:schema-tool:update --force');
            echo "<pre>$output</pre>";
        }

    } else  //Multiple files, file[] // Not used for the moment
    {
        $fileCount = count($_FILES["myfile"]["name"]);
        for ($i = 0; $i < $fileCount; $i++) {
            $fileName = $_FILES["myfile"]["name"][$i];
            move_uploaded_file($_FILES["myfile"]["tmp_name"][$i], $output_dir . $fileName);
            $ret[] = $fileName;
        }

    }
    echo json_encode($ret);
}
?>
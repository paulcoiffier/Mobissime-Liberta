<?php
/**
 * Created by PhpStorm.
 * User: Paul
 * Date: 16/02/2015
 * Time: 22:10
 */

namespace MyCrm\Modules\LibertaDatastore\Model;

use App\Lib\ObjectSerializer;
use App\Objects\Entity;

class DataStoreModel
{

    public function getEntitiesList()
    {
        $root = $_SERVER["DOCUMENT_ROOT"] . install_path . '/src/App/Entities';

        $objects = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($root),
            \RecursiveIteratorIterator::SELF_FIRST | \FilesystemIterator::SKIP_DOTS);

        $directories = array();
        $i = 0;

        foreach ($objects as $name => $object) {
            $localPath = str_replace($root, '', $name);
            if ($object->isDir()) {

            } else {
                $localPath = stripslashes($localPath);
		        $localPath = str_replace("/","",$localPath);
                $localPath = str_replace(".php", "", $localPath);
                $directories[$i] = $localPath;

                $o = new ObjectSerializer();
                $e = new Entity();
                $e->setEntityName($localPath);

                /** For each file we test if the xml file exist */
                if (!file_exists($_SERVER["DOCUMENT_ROOT"] . install_path . '/src/App/Data/' . $localPath . ".xml")) {
                    $o->serializeFile($_SERVER["DOCUMENT_ROOT"] . install_path . '/src/App/Data/' . $localPath . ".xml", "xml", $e);
                }

            }
            $i++;
        }

        sort($directories);
        return $directories;
    }

    public function getListOfDoctrineTypes()
    {
        $listOfDoctrineType = array("string", "integer", "smallint", "bigint", "boolean", "decimal", "date", "time", "datetime", "datetimetz", "text", "object", "array", "simple_array", "json_array", "float", "guid", "blob");
        return $listOfDoctrineType;
    }

    public function getControlTypes()
    {
        $control_types = array("Calendar", "Checkbox", "Label", "Radio button", "Simple text", "Textarea", "Text");
        return $control_types;
    }

    public function getDoctrineClassTypes()
    {
        $array = array("Doctrine\ORM\Mapping\ManyToOne", "Doctrine\ORM\Mapping\ManyToMany", "Doctrine\ORM\Mapping\OneToMany", "Doctrine\ORM\Mapping\OneToOne");
        return $array;
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: Paul
 * Date: 07/02/2015
 * Time: 21:05
 */

namespace App\Lib;

use App\Services\AnnotationsParser;

/**
 * Doctrine entities utility class
 *
 * For the full copyright and license information, please view
 * the file LICENSE that was distributed with this source code.
 *
 * @author Paul Coiffier <coiffier.paul@gmail.com>
 * @copyright 2015 Paul Coiffier | Mobissime - <http://www.mobissime.com>
 */
class EntitiesUtils
{

    /**
     * Get list of all doctrine entities
     *
     * @return array List of entities
     */
    public function getEntitiesList()
    {
        $root = $_SERVER["DOCUMENT_ROOT"] . install_path . 'src/App/Entities';
        $objects = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($root),
            \RecursiveIteratorIterator::SELF_FIRST | \FilesystemIterator::SKIP_DOTS);

        $directories = array();
        $rootFiles = array();
        $i = 0;
        $iFile = 0;

        foreach ($objects as $name => $object) {
            $localPath = str_replace($root, '', $name);
            if ($object->isDir()) {
                $localPath = stripslashes($localPath);
                if (($localPath != ".") && ($localPath != "..")) {
                    $localPath = str_replace(".php","",$localPath);
                    $directories[$i] = $localPath;
                    $i++;
                }
            } else {
                $localPath = stripslashes($localPath);
                $localPath = str_replace(".php","",$localPath);
                $rootFiles[$iFile] = $localPath;
                $iFile++;
            }
        }

        return $rootFiles;
    }

    /**
     * Get list of fields for an entity
     *
     * @param $entity : Entity name
     * @param $entityManager : Doctrine entity manager
     * @return array List of entities
     */
    public function getEntityFields($entity, $entityManager)
    {
        /** Class properties parsing */
        $entity = "\App\Entities\\" . $entity;

        $parser = new AnnotationsParser();

        $class = new $entity;
        $classFields = $parser->getClassPropertiesList($class);

        $r = new \ReflectionClass($class);
        $doc = $r->getDocComment();
        preg_match_all('#@(.*?)\n#s', $doc, $annotations);

        $array_fields = array();
        $i = 0;
        foreach ($classFields as $field) {

            $array = $parser->getPropertyAnnotations($class, $field);

            $array_fields[$i] = array();
            $arrayB = array_shift($array);

            foreach ($arrayB as $key => $value) {
                $array_fields[$i][$key] = $value;
            }

            $array_fields[$i]["name"] = $field;
            $i++;
        }

        return $array_fields;
    }

}
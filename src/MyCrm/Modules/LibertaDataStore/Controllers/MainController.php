<?php
/**
 * Created by PhpStorm.
 * User: Paul
 * Date: 28/01/2015
 * Time: 15:56
 */

namespace MyCrm\Modules\LibertaDataStore\Controllers;

use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing;
use App\Lib\TwigController;
use MyCrm\Modules\LibertaTodos\Model\ModulesModel;
use App\Engine\YamlWriter;
use App\Engine\YamlParser;
use MyCrm\Modules\LibertaDataStore\Lib\DoctrineUtils;
use MyCrm\Modules\LibertaDataStore\Lib\RepositoryUtils;

use Doctrine\Common\Collections\ArrayCollection;
use App\Lib\ObjectSerializer;
use MyCrm\Modules\LibertaDataStore\Model\DataStoreModel;

class MainController extends TwigController
{

    public function indexAction(Request $request, $appParams)
    {
        /** Internal controller mixture */
        $this->setValues(__DIR__ . '/../Views/', $appParams, $appParams['container']);
        $this->setRequest($request);
        /** End internal controller mixture */

        $model = new DataStoreModel();

        /** Page Template */
        $this->setPageTemplate('Index.html');
        /** Rendered options */
        $this->setModuleRendererOptions(array('entities' => $model->getEntitiesList(), 'doctrine_classes' => $model->getDoctrineClassTypes(), 'listOfDoctrineType' => $model->getListOfDoctrineTypes()));

        /** Response */
        return $this->getResponse();
    }

    public function getEntitiesAjax(Request $request, $appParams)
    {

        /** Internal controller mixture */
        $this->setValues(__DIR__ . '/../Views/', $appParams, $appParams['container']);
        $this->setRequest($request);
        /** End internal controller mixture */

        $model = new DataStoreModel();

        /** Page Template */
        $this->setPageTemplate('EntitiesList.html');
        /** Rendered options */
        $this->setModuleRendererOptions(array('entities' => $model->getEntitiesList()));

        /** Response */
        return $this->getResponse();
    }

    public function editEntityAjax(Request $request, $appParams)
    {

        /** Internal controller mixture */
        $this->setValues(__DIR__ . '/../Views/', $appParams, $appParams['container']);
        $this->setRequest($request);
        /** End internal controller mixture */

        $container = $request->get('container');

        /** Update XML file */
        $o = new ObjectSerializer();
        $entity = str_replace(".php", "", $_POST['entity']);
        $xml_entity = $o->find_xml_entity($entity);

        $parser = $container->get('annotationsParser');

        /** Class properties parsing */
        $entity = str_replace(".php", "", $_POST['entity']);
        $entity = "\App\Entities\\" . $entity;

        $model = new DataStoreModel();

        $class = new $entity;
        $classFields = $parser->getClassPropertiesList($class);

        $r = new \ReflectionClass($class);
        $doc = $r->getDocComment();
        preg_match_all('#@(.*?)\n#s', $doc, $annotations);

        $tableName = $appParams['entityManager']->getClassMetadata($entity)->getTableName();

        $array_fields = array();
        $i = 0;

        foreach ($classFields as $field) {

            $array = $parser->getPropertyAnnotations($class, $field);
            $arrayB = array_shift($array);

            foreach ($arrayB as $key => $value) {
                $array_fields[$i][$key] = $value;
            }

            $array_fields[$i]['object_type'] = get_class($arrayB);
            $array_fields[$i]['display_type'] = "Text";
            $array_fields[$i]['display_width'] = "";
            $array_fields[$i]['display_tooltip'] = "";
            $array_fields[$i]['display_error'] = "";
            $array_fields[$i]['display_length'] = "";
            $array_fields[$i]['display_mandatory'] = "";
            $array_fields[$i]['display_mandatory_label'] = "";

            $array_fields[$i]["name"] = $field;
            $i++;
        }

        /** Update XML file */
        $xml_entity->setEntityTableName($tableName);
        $xml_entity->setEntityFields(array('Field' => $array_fields));

        /** Page Template */
        $this->setPageTemplate('EditEntity.html');
        /** Rendered options */
        $this->setModuleRendererOptions(array('doctrine_classes' => $model->getDoctrineClassTypes(), 'classFields' => ($array_fields), 'listOfDoctrineType' => $model->getListOfDoctrineTypes(), 'tableName' => $tableName));

        /** Create XML file if not exist */
        $entity = str_replace(".php", "", $_POST['entity']);
        // TODO FIX
        //if (!file_exists($_SERVER["DOCUMENT_ROOT"] . install_path . 'src/App/Data/' . $entity . ".xml")) {
        //print_r($xml_entity);
        $o->serializeEntity($entity, "xml", $xml_entity);
        //}

        /** Response */
        return $this->getResponse();
    }

    public function writeEntityAjax(Request $request, $appParams)
    {
        $request = Request::createFromGlobals();

        if ($request->isXmlHttpRequest()) {
            $fields = $_REQUEST['fields'];
            $options = $_REQUEST['options'];

            $entityName = $options['entity'];
            $tableName = $options['tableName'];

            print_r($options);

            $doctrineUtils = new DoctrineUtils();
            $doctrineUtils->writeEntity($fields, $entityName, $tableName);

            return new Response('ok');
        }
    }

    public function createEntityAjax(Request $request, $appParams)
    {
        $request = Request::createFromGlobals();

        if ($request->isXmlHttpRequest()) {

            $entity_name = $_POST['entity_name'];
            $table_name = $_POST['table_name'];

            $doctrineUtils = new DoctrineUtils();
            $doctrineUtils->writeEntity(null, $entity_name, $table_name);

            return new Response('ok');
        }
    }

    public function removeEntityAjax(Request $request, $appParams)
    {
        $request = Request::createFromGlobals();

        if ($request->isXmlHttpRequest()) {

            $entity_name = $_POST['entity_name'];
            $table_name = $_POST['table_name'];

            $doctrineUtils = new DoctrineUtils();
            $doctrineUtils->removeEntity($entity_name, $table_name, $appParams['entityManager']);

            return new Response('ok');
        }
    }

    public function entityFormulaireAjax(Request $request, $appParams)
    {
        $request = Request::createFromGlobals();

        if ($request->isXmlHttpRequest()) {

            /** Internal controller mixture */
            $this->setValues(__DIR__ . '/../Views/', $appParams, $appParams['container']);
            $this->setRequest($request);
            /** End internal controller mixture */

            /** Parse entity XML file */
            $entity = $_POST['entity'];
            $o = new ObjectSerializer();
            $xml_entity = $o->find_xml_entity($entity);

            $options = array("fields" => "");


            $i = 0;
            foreach ($xml_entity->getEntityFields() as $f) {
                foreach ($f as $field) {
                    $array_fields = array();

                    if ($field['name'] != "id") {

                        $field_name = $field['name'];

                        $array_fields['display_tooltip'] = $field['display_tooltip'];
                        $array_fields['display_error'] = $field['display_error'];
                        $array_fields['display_length'] = $field['display_length'];
                        $array_fields['display_mandatory'] = $field['display_mandatory'];
                        $array_fields['object_type'] = $field['object_type'];

                        if (array_key_exists('type', $field)) {
                            $array_fields['type'] = $field['type'];
                            $array_fields['type'] = null;
                        } else {
                            $array_fields['type'] = null;
                        }

                        if (array_key_exists('length', $field)) {
                            $array_fields['length'] = $field['length'];
                        } else {
                            $array_fields['length'] = "relation";
                        }

                        if (array_key_exists('precision', $field)) {
                            $array_fields['precision'] = $field['precision'];
                        } else {
                            $array_fields['precision'] = "relation";
                        }

                        if (array_key_exists('scale', $field)) {
                            $array_fields['scale'] = $field['scale'];
                        } else {
                            $array_fields['scale'] = "relation";
                        }

                        if (array_key_exists('unique', $field)) {
                            $array_fields['unique'] = $field['unique'];
                        } else {
                            $array_fields['unique'] = "relation";
                        }

                        if (array_key_exists('nullable', $field)) {
                            $array_fields['nullable'] = $field['nullable'];
                        } else {
                            $array_fields['nullable'] = "relation";
                        }

                        if (array_key_exists('targetEntity', $field)) {
                            $array_fields['targetEntity'] = $field['targetEntity'];
                            $array_fields['fieldRelation'] = "yes";
                        } else {
                            $array_fields['fieldRelation'] = "no";
                            $array_fields['targetEntity'] = null;
                        }

                        if (array_key_exists('cascade', $field)) {
                            $array_fields['cascade'] = $field['cascade'];
                        } else {
                            $array_fields['cascade'] = "relation";
                        }

                        $array_fields['display_type'] = $field['display_type'];
                        $array_fields['name'] = $field['name'];

                        $options["$field_name"] = $array_fields;

                        $i++;
                    }
                }
            }

            $model = new DataStoreModel();
            /** Page Template */
            $this->setPageTemplate('Formulaire.html');
            /** Rendered options */
            $this->setModuleRendererOptions(array('entities' => $model->getEntitiesList(), 'doctrine_classes' => $model->getDoctrineClassTypes(), 'fields' => $options, 'control_types' => $model->getControlTypes()));
            /** Response */
            return $this->getResponse();
        }
    }

    public function entityQueriesAjax(Request $request, $appParams)
    {
        $request = Request::createFromGlobals();

        if ($request->isXmlHttpRequest()) {

            /** Internal controller mixture */
            $this->setValues(__DIR__ . '/../Views/', $appParams, $appParams['container']);
            $this->setRequest($request);
            /** End internal controller mixture */

            $entity = $_POST['entity'];
            $repo_utils = new RepositoryUtils();
            $ifExist = $repo_utils->ifRepositoryExist($entity);

            /** Create repository for entity if needed */
            if (!$ifExist) {
                $repo_utils->createRepository($entity);
            }

            $this->setPageTemplate('Queries.html');
            /** Rendered options */
            $this->setModuleRendererOptions(array('queries' => $repo_utils->getRepositoryQueries($entity)));
            /** Response */
            return $this->getResponse();
        }
    }

}

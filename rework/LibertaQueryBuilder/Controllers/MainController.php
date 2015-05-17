<?php
/**
 * Created by PhpStorm.
 * User: Paul
 * Date: 28/01/2015
 * Time: 15:56
 */

namespace MyCrm\Modules\LibertaQueryBuilder\Controllers;

use Symfony\Component\Routing;
use Symfony\Component\HttpFoundation\Request;
use App\Lib\TwigController;
use MyCrm\Modules\LibertaDatastore\Model\DataStoreModel;
use App\Services\AnnotationsParser;

class MainController extends TwigController
{

    public function indexAction(Request $request, $appParams)
    {

        /** Internal controller mixture */
        $this->setValues(__DIR__ . '/../Views/', $appParams, $appParams['container']);
        $this->setRequest($request);
        /** End internal controller mixture */

        $model = new DataStoreModel();

        $this->setPageTemplate('Index.html');
        $this->setModuleRendererOptions(array('entities' => $model->getEntitiesList()));

        /** Response */
        return $this->getResponse();
    }

    public function entityTableAction(Request $request, $appParams)
    {
        $request = Request::createFromGlobals();

        if ($request->isXmlHttpRequest()) {
            /** Internal controller mixture */
            $this->setValues(__DIR__ . '/../Views/', $appParams, $appParams['container']);
            $this->setRequest($request);
            /** End internal controller mixture */

            $parser = new AnnotationsParser();
            $entity = $_REQUEST['entity'];
            $entity_name = $_REQUEST['entity'];

            $entity = "\App\Entities\\" . $entity;
            $class = new $entity;
            $classFields = $parser->getClassPropertiesList($class);

            $r = new \ReflectionClass($class);
            $doc = $r->getDocComment();
            preg_match_all('#@(.*?)\n#s', $doc, $annotations);

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

            $this->setPageTemplate('EntityTable.html');
            $this->setModuleRendererOptions(array('entity' => $entity_name, 'fields' => $array_fields));

            /** Response */
            return $this->getResponse();
        }
    }

}
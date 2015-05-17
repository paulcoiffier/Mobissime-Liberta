<?php

namespace MyCrm\Modules\LibertaQueryBuilder\Controllers;

use Symfony\Component\Routing;
use Symfony\Component\HttpFoundation\Request;
use App\Lib\TwigController;
use MyCrm\Modules\LibertaModules\Model\ModulesModel;

class MainController extends TwigController
{

    public function indexAction(Request $request, $appParams, $moduleId)
    {

        /** Internal controller mixture */
        $this->setValues(__DIR__ . '/../Views/', $appParams, $appParams['container']);
        $this->setRequest($request);
        /** End internal controller mixture */

        /** Read XML Module queries file "queries.xml" */
        $moduleModel = new ModulesModel($appParams['entityManager']);
        $moduleToView = $moduleModel->getModuleById($moduleId);
        $queries = simplexml_load_file(install_sys_dir . 'src/MyCrm/Modules/' . $moduleToView->getModName() . '/Conf/queries.xml');

        /** Apply page template and parameters */
        $this->setPageTemplate('Index.html');
        $this->setModuleRendererOptions(array('queries' => $queries));
        // print_r($queries);

        /** Response */
        return $this->getResponse();
    }

}
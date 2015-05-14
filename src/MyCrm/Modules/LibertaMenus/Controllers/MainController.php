<?php
/**
 * Created by PhpStorm.
 * User: Paul
 * Date: 28/01/2015
 * Time: 15:56
 */

namespace MyCrm\Modules\LibertaMenus\Controllers;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing;
use Symfony\Component\HttpFoundation\Request;
use App\Lib\TwigController;

class MainController extends TwigController
{

    public function indexAction(Request $request, $appParams)
    {

        /** Internal controller mixture */
        $this->setValues(__DIR__ . '/../Views/', $appParams, $appParams['container']);
        $this->setRequest($request);
        /** End internal controller mixture */

        $this->setPageTemplate('Index.html');
        $this->setModuleRendererOptions(array());

        /** Response */
        return $this->getResponse();
    }

    public function createMenuAction(Request $request, $appParams)
    {

        /** Internal controller mixture */
        $this->setValues(__DIR__ . '/../Views/', $appParams, $appParams['container']);
        $this->setRequest($request);
        /** End internal controller mixture */

        $this->setPageTemplate('Menu.html');
        $this->setModuleRendererOptions(array(
            'db_action' => "insert_menu",
            'title' => "Add menu item"
        ));

        /** Response */
        return $this->getResponse();
    }

    public function addMenuItemAjax(Request $request, $appParams)
    {
        $request = Request::createFromGlobals();

        if ($request->isXmlHttpRequest()) {
            $id = $_POST['id'];
            $menu_item_name = $_POST['menu_item_name'];
            $menu_static_link = $_POST['menu_static_link'];
            $menu_descriptiop = $_POST['menu_descriptiop'];
            $menu_position = $_POST['menu_position'];
            $a_menu_font_awesome_icon = $_POST['a_menu_font_awesome_icon'];

            $menu = $appParams['entityManager']->getRepository('\App\Entities\Menu')->findOneBy(array('id' => $id));

            $menuItem = new MenuItem();
            $menuItem->setMenu($menu);
            $menuItem->setMenuDescriptiop($menu_descriptiop);
            $menuItem->setMenuItemName($menu_item_name);
            $menuItem->setMenuItemPosition($menu_position);
            $menuItem->setMenuStaticLink($menu_static_link);
            $menuItem->setMenuFontAwesomeIcon($a_menu_font_awesome_icon);

            $appParams['entityManager']->persist($menuItem);
            $appParams['entityManager']->flush();

            $arr = array(
                'error' => 'no'
            );

            return new Response(json_encode($arr));
        }

    }

    public function changeMenuOrderAjax(Request $request, $appParams)
    {
        $request = Request::createFromGlobals();

        if ($request->isXmlHttpRequest()) {
            $id = $_POST['id'];
            $order = $_POST['order'];
            $menu = $appParams['entityManager']->getRepository('\App\Entities\Menu')->findOneBy(array('id' => $id));
            $menu->setMenuOrder($order);

            $appParams['entityManager']->merge($menu);
            $appParams['entityManager']->flush();

            $arr = array(
                'error' => 'no'
            );

            return new Response(json_encode($arr));
        }
    }

    public function deleteMenuOrderAjax(Request $request, $appParams)
    {
        $request = Request::createFromGlobals();

        if ($request->isXmlHttpRequest()) {
            $id = $_POST['id'];
            $menu = $appParams['entityManager']->getRepository('\App\Entities\Menu')->findOneBy(array('id' => $id));

            $appParams['entityManager']->remove($menu);
            $appParams['entityManager']->flush();

            $arr = array(
                'error' => 'no'
            );

            return new Response(json_encode($arr));
        }
    }

    public function deleteSubItemAjax(Request $request, $appParams)
    {
        $request = Request::createFromGlobals();

        if ($request->isXmlHttpRequest()) {
            $id = $_POST['id'];
            $menu = $appParams['entityManager']->getRepository('\App\Entities\MenuItem')->findOneBy(array('id' => $id));

            $appParams['entityManager']->remove($menu);
            $appParams['entityManager']->flush();

            $arr = array(
                'error' => 'no'
            );

            return new Response(json_encode($arr));

        }
    }

    public function updateMenuItemAjax(Request $request, $appParams)
    {
        $request = Request::createFromGlobals();

        if ($request->isXmlHttpRequest()) {
            $id = $_POST['id'];
            $menu_item_name = $_POST['menu_item_name'];
            $menu_static_link = $_POST['menu_static_link'];
            $menu_descriptiop = $_POST['menu_descriptiop'];
            $update_menu_item_position = $_POST['update_menu_item_position'];
            $a_menu_font_awesome_icon = $_POST['u_menu_font_awesome_icon'];

            $menu = $appParams['entityManager']->getRepository('\App\Entities\MenuItem')->findOneBy(array('id' => $id));

            $menu->setMenuDescriptiop($menu_descriptiop);
            $menu->setMenuItemName($menu_item_name);
            $menu->setMenuItemPosition($update_menu_item_position);
            $menu->setMenuStaticLink($menu_static_link);
            $menu->setMenuFontAwesomeIcon($a_menu_font_awesome_icon);

            $appParams['entityManager']->merge($menu);
            $appParams['entityManager']->flush();

            $arr = array(
                'error' => 'no'
            );

            return new Response(json_encode($arr));
        }
    }
}

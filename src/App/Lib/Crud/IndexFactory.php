<?php

namespace App\Lib\Crud;

Class IndexFactory


{

    private $entity_fields;
    private $module;

    public function createTableIndex($entityName)
    {
        $tpl_content = file_get_contents('../src/App/Lib/Templates/Code/Views/Index.html.txt');

        $thContent = "";
        foreach ($this->entity_fields as $field) {
            $thContent .= "<th>{{module_words." . $field . "}}</th>\n";
        }
        $tpl_content = str_replace("[[TH_ZONE]]", $thContent, $tpl_content);

        $tdContent = "";
        foreach ($this->entity_fields as $field) {
            $tdContent .= "<td>{{ obj." . $field . " }}</td>\n";
        }
        $tpl_content = str_replace("[[TD_ZONE]]", $tdContent, $tpl_content);

        $tpl_content = str_replace("[[ENTITY_NAME]]", $entityName, $tpl_content);

        $fp = fopen('../src/MyCrm/Modules/' . $this->module . '/Views/Index.html', 'w');
        fwrite($fp, $tpl_content);
    }

    public function createEmptyindex()
    {
        $tpl_content = file_get_contents('../src/App/Lib/Templates/Code/Views/IndexEmpty.html.txt');

        $thContent = "";
        foreach ($this->entity_fields as $field) {
            $thContent .= "<th>{{module_words." . $field . "}}</th>\n";
        }
        $tpl_content = str_replace("[[MODULE_NAME]]", "{{module_title}}", $tpl_content);

        $fp = fopen('../src/MyCrm/Modules/' . $this->module . '/Views/Index.html', 'w');
        fwrite($fp, $tpl_content);

        /** Create file for visual builder */
        $fp = fopen('../src/MyCrm/Modules/' . $this->module . '/Data/Views/Index.html', 'w');
        fwrite($fp, $tpl_content);
    }

    public function createEmptyXmlIndex()
    {
        $fp = fopen('../src/MyCrm/Modules/' . $this->module . '/Data/Views_xml/Index.xml', 'w');
        fwrite($fp, '<?xml version="1.0"?>');

        fwrite($fp, "<Form>");
        fwrite($fp, "    <Name>Index</Name>");
        fwrite($fp, "    <Components>");
        fwrite($fp, "    </Components>");
        fwrite($fp, "</Form>");
        fclose($fp);
    }

    /**
     * @return mixed
     */
    public function getEntityFields()
    {
        return $this->entity_fields;
    }

    /**
     * @param mixed $entity_fields
     */
    public function setEntityFields($entity_fields)
    {
        $this->entity_fields = $entity_fields;
    }

    /**
     * @return mixed
     */
    public function getModule()
    {
        return $this->module;
    }

    /**
     * @param mixed $module
     */
    public function setModule($module)
    {
        $this->module = $module;
    }

}
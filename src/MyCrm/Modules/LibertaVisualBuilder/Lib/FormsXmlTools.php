<?php
/**
 * Created by PhpStorm.
 * User: Paul
 * Date: 22/02/2015
 * Time: 22:15
 */

namespace MyCrm\Modules\LibertaVisualBuilder\Lib;


class FormsXmlTools
{

    public function testAndCreateXmlDef($module_name, $form_name)
    {
        $form_name = str_replace(".html", "", $form_name);
        if (!file_exists($_SERVER["DOCUMENT_ROOT"] . install_path . 'src/MyCrm/Modules/' . $module_name . '/Data/Views_xml/' . $form_name . ".xml")) {
            $this->createXmlDef($module_name, $form_name);
        }
    }

    public function createXmlDef($module_name, $form_name)
    {
        $form_name = str_replace(".html", "", $form_name);

        $xml = new \DOMDocument();
        $xml_form = $xml->createElement("Form");

        $xml_form_name = $xml->createElement("Name");
        $xml_form_name->nodeValue = $form_name;
        $xml_form->appendChild($xml_form_name);

        $xml_components = $xml->createElement("Components");

        $xml_form->appendChild($xml_components);
        $xml->appendChild($xml_form);

        $xml->save($_SERVER["DOCUMENT_ROOT"] . install_path . 'src/MyCrm/Modules/' . $module_name . '/Data/Views_xml/' . $form_name . ".xml");
    }

    public function addXmlComponentDef($module_name, $form_name, $entity, $query_name, $component, $fields)
    {

        $form_name = str_replace(".html", "", $form_name);

        $xml = new \DOMDocument();
        $xml->load($_SERVER["DOCUMENT_ROOT"] . install_path . 'src/MyCrm/Modules/' . $module_name . '/Data/Views_xml/' . $form_name . ".xml");

        $components = $xml->getElementsByTagName("Components");

        foreach ($components as $c) {
            $xml_component = $xml->createElement("Component");

            /** Component name */
            $xml_component_name = $xml->createElement("Name");
            $xml_component_name->nodeValue = $component['name'];
            $xml_component->appendChild($xml_component_name);

            /** Component type */
            $xml_component_type = $xml->createElement("Type");
            $xml_component_type->nodeValue = $component['type'];
            $xml_component->appendChild($xml_component_type);

            /** Entity / Repository query binding */
            $xml_component_entity = $xml->createElement("Entity");
            $xml_component_entity->nodeValue = $entity;
            $xml_component->appendChild($xml_component_entity);

            /** Component query binding */
            $xml_component_query_binding = $xml->createElement("QueryBinding");
            $xml_component_query_binding->nodeValue = $query_name;
            $xml_component->appendChild($xml_component_query_binding);

            /** Component fields */
            $xml_component_fields = $xml->createElement("Fields");
            $xml_component->appendChild($xml_component_fields);

            foreach ($fields as $field) {

                $field_name = $field['field'];
                $field_type = $field['fieldType'];
                $field_entity = $field['entity'];

                /** Field */
                $xml_component_field = $xml->createElement("Field");

                $component_field = $xml->createElement("Name");
                $component_field->nodeValue = $field_name;

                $component_type = $xml->createElement("Type");
                $component_type->nodeValue = $field_type;

                $component_entity = $xml->createElement("Entity");
                $component_entity->nodeValue = $field_entity;

                $xml_component_field->appendChild($component_field);
                $xml_component_field->appendChild($component_type);
                $xml_component_field->appendChild($component_entity);

                $xml_component_fields->appendChild($xml_component_field);

            }

            $c->appendChild($xml_component);
        }


        $xml->save($_SERVER["DOCUMENT_ROOT"] . install_path . 'src/MyCrm/Modules/' . $module_name . '/Data/Views_xml/' . $form_name . ".xml");
    }

    public function removeXmlComponent($module_name, $form_name, $component_name)
    {

        $form_name = str_replace(".html", "", $form_name);

        $xml = new \DOMDocument();
        $xml->load($_SERVER["DOCUMENT_ROOT"] . install_path . 'src/MyCrm/Modules/' . $module_name . '/Data/Views_xml/' . $form_name . ".xml");

        $components = $xml->getElementsByTagName("Components");

        foreach ($components as $c) {
            foreach ($c->childNodes as $cn) {
                foreach ($cn->childNodes as $ccn) {
                    if ($ccn->nodeName == "Name") {
                        if ($ccn->nodeValue == $component_name) {
                            $c->removeChild($cn);
                            break;
                        }
                    }
                }
            }
        }

        $xml->save($_SERVER["DOCUMENT_ROOT"] . install_path . 'src/MyCrm/Modules/' . $module_name . '/Data/Views_xml/' . $form_name . ".xml");
    }

    public function createFormXmlBindings($module_name, $form_name)
    {
        /** Parse XML */
        $form_name = str_replace(".html", "", $form_name);

        $xml = new \DOMDocument();
        $xml->load($_SERVER["DOCUMENT_ROOT"] . install_path . 'src/MyCrm/Modules/' . $module_name . '/Data/Views_xml/' . $form_name . ".xml");

        /** Open form file */
        $page = file_get_contents($_SERVER["DOCUMENT_ROOT"] . install_path . 'src/MyCrm/Modules/' . $module_name . '/Views/' . $form_name . ".html");

        /** Traitment for each components    */
        $components = $xml->getElementsByTagName("Components");

        $_replace = true;
        $_type = "";
        $_name = "";

        foreach ($components as $c) {
            foreach ($c->childNodes as $cn) {

                if ($cn->nodeName == "Component") {
                    foreach ($cn->childNodes as $ccn) {

                        /** Get field html ID / Name */
                        if ($ccn->nodeName == "Name") {
                            $_name = $ccn->nodeValue;
                        }

                        /** Replace html content by type */
                        if ($ccn->nodeName == "Type") {
                            if ($ccn->nodeValue == "datatable") {
                                $_replace = true;
                                $_type = "datatable";
                            }
                        }

                        if ($ccn->nodeName == "Fields") {
                            if ($_replace == true) {

                                /** Datatable creation */
                                if ($_type == "datatable") {
                                    /** Process replace content by loop */
                                    $html_dataTable = "{% for var in " . $_name . " %}";
                                    $html_dataTable .= "<tr>";

                                    foreach ($ccn->childNodes as $cccn) {
                                        if ($cccn->hasChildNodes()) {
                                            foreach ($cccn->childNodes as $field) {
                                                if ($field->nodeName == "Name") {
                                                    /** Add fields by query xml */
                                                    $html_dataTable .= "<td>{{ var." . $field->nodeValue . " }}</td>";
                                                }
                                            }
                                        }
                                    }
                                    $html_dataTable .= "</tr>";
                                    $html_dataTable .= "{% endfor %}";
                                    /** Replace content with datatable fields */
                                    $page = str_replace("<!-- " . $_name . " -->", $html_dataTable, $page);
                                }

                                /** Other creations / replacements... */
                            }
                        }

                    }
                }
            }
        }

        /** Write new html file */
        $file = fopen($_SERVER["DOCUMENT_ROOT"] . install_path . 'src/MyCrm/Modules/' . $module_name . '/Views/' . $form_name . ".html", "w");
        fwrite($file, $page);
        fclose($file);

    }

    public function getFormXmlControllers($module_name, $form_name)
    {
        /** Parse XML */
        $form_name = str_replace(".html", "", $form_name);

        $xml = new \DOMDocument();
        $xml->load($_SERVER["DOCUMENT_ROOT"] . install_path . 'src/MyCrm/Modules/' . $module_name . '/Data/Views_xml/' . $form_name . ".xml");

        $components = $xml->getElementsByTagName("Components");

        $_name = "";
        $_entity = "";
        $_query_binding = "";
        $tab = array();

        foreach ($components as $c) {
            foreach ($c->childNodes as $cn) {

                if ($cn->nodeName == "Component") {
                    foreach ($cn->childNodes as $ccn) {
                        if ($ccn->nodeName == "Name") {
                            $_name = $ccn->nodeValue;
                        }
                        else if ($ccn->nodeName == "Entity") {
                            $_entity = $ccn->nodeValue;
                        }
                        else if ($ccn->nodeName == "QueryBinding") {
                            $_query_binding = $ccn->nodeValue;
                            $tab[] = array("name" => $_name, "entity" => $_entity, "QueryBinding" => $_query_binding);
                        }
                    }
                }
            }
        }
        return $tab;
    }
}
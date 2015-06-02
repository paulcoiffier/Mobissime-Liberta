<?php

namespace MyCrm\Modules\LibertaQueryBuilder\Model;

/**
 * Created by IntelliJ IDEA.
 * User: Paul
 * Date: 17/05/2015
 * Time: 23:08
 */

class QueriesModel
{

    /** Get list of module queries
     * @param $moduleName : Module Name
     */
    public function getQueries($module_name)
    {
        /** Open Queries module XML File */
        $xml = new \DOMDocument();
        $xml->load($_SERVER["DOCUMENT_ROOT"] . install_path . 'src/MyCrm/Modules/' . $module_name . '/Conf/queries.xml');

        $queries = $xml->getElementsByTagName("queries");

        $_name = "";
        $_description = "";
        $_id = "";
        foreach ($queries as $c) {
            $tab = array();

            foreach ($c->childNodes as $cn) {

                if ($cn->nodeName == "query") {
                    foreach ($cn->childNodes as $ccn) {
                        if ($ccn->nodeName == "id") {
                            $_id = $ccn->nodeValue;
                        } else if ($ccn->nodeName == "name") {
                            $_name = $ccn->nodeValue;
                        } else if ($ccn->nodeName == "description") {
                            $_description = $ccn->nodeValue;
                        } else if ($ccn->nodeName == "valeur") {
                            $_value = $ccn->nodeValue;
                            $tab[] = array("id" => $_id, "name" => $_name, "description" => $_description, "value" => $_value);
                        }
                    }
                }
            }
        }
        return $tab;
    }

    public function deleteQuery($module_name, $query_id)
    {
        /** Open Queries module XML File */
        $xml = new \DOMDocument();
        $xml->load($_SERVER["DOCUMENT_ROOT"] . install_path . 'src/MyCrm/Modules/' . $module_name . '/Conf/queries.xml');

        $queries = $xml->getElementsByTagName("queries");

        foreach ($queries as $c) {
            $tab = array();

            foreach ($c->childNodes as $cn) {

                if ($cn->nodeName == "query") {
                    foreach ($cn->childNodes as $ccn) {
                        if (($ccn->nodeName == "id") && ($ccn->nodeValue == $query_id)) {
                            $c->removeChild($cn);
                            break;
                        }
                    }
                }
            }
        }

        /** Update xml file */
        $xml->save($_SERVER["DOCUMENT_ROOT"] . install_path . 'src/MyCrm/Modules/' . $module_name . '/Conf/queries.xml');
    }

    public function addQuery($module_name, $query_id, $query_name, $query_description, $query_value)
    {
        /** Open Queries module XML File */
        $xml = new \DOMDocument();
        $xml->load($_SERVER["DOCUMENT_ROOT"] . install_path . 'src/MyCrm/Modules/' . $module_name . '/Conf/queries.xml');

        $queries = $xml->getElementsByTagName("queries");

        foreach ($queries as $c) {

            $new_query = $xml->createElement('query');
            /** Id attribute */
            $new_id = $xml->createElement('id');
            $new_id_text = $xml->createTextNode($query_id);
            $new_id->appendChild($new_id_text);

            /** Name attribute */
            $new_name = $xml->createElement('name');
            $new_name_text = $xml->createTextNode($query_name);
            $new_name->appendChild($new_name_text);

            /** Description attribute */
            $new_description = $xml->createElement('description');
            $new_description_text = $xml->createTextNode($query_description);
            $new_description->appendChild($new_description_text);

            /** Value attribute */
            $new_value = $xml->createElement('valeur');
            $new_value_text = $xml->createTextNode($query_value);
            $new_value->appendChild($new_value_text);

            /** Append childs */
            $new_query->appendChild($new_id);
            $new_query->appendChild($new_name);
            $new_query->appendChild($new_description);
            $new_query->appendChild($new_value);

            $c->appendChild($new_query);
        }


        /** Update xml file */
        $xml->save($_SERVER["DOCUMENT_ROOT"] . install_path . 'src/MyCrm/Modules/' . $module_name . '/Conf/queries.xml');
    }

    /** Update a query in the xml Queries file */
    public function updateQuery($module_name, $query_id, $query_name, $query_description, $query_value)
    {
        /** Open Queries module XML File */
        $xml = new \DOMDocument();
        $xml->load($_SERVER["DOCUMENT_ROOT"] . install_path . 'src/MyCrm/Modules/' . $module_name . '/Conf/queries.xml');

        $queries = $xml->getElementsByTagName("queries");

        foreach ($queries as $c) {
            $tab = array();

            foreach ($c->childNodes as $cn) {

                if ($cn->nodeName == "query") {
                    foreach ($cn->childNodes as $ccn) {
                        if (($ccn->nodeName == "id") && ($ccn->nodeValue == $query_id)) {

                            /** Replace node with new values */
                            $new_query = $xml->createElement('query');

                            /** Id attribute */
                            $new_id = $xml->createElement('id');
                            $new_id_text = $xml->createTextNode($query_id);
                            $new_id->appendChild($new_id_text);

                            /** Name attribute */
                            $new_name = $xml->createElement('name');
                            $new_name_text = $xml->createTextNode($query_name);
                            $new_name->appendChild($new_name_text);

                            /** Description attribute */
                            $new_description = $xml->createElement('description');
                            $new_description_text = $xml->createTextNode($query_description);
                            $new_description->appendChild($new_description_text);

                            /** Value attribute */
                            $new_value = $xml->createElement('valeur');
                            $new_value_text = $xml->createTextNode($query_value);
                            $new_value->appendChild($new_value_text);

                            /** Append childs */
                            $new_query->appendChild($new_id);
                            $new_query->appendChild($new_name);
                            $new_query->appendChild($new_description);
                            $new_query->appendChild($new_value);

                            /** Replace old element with new */
                            $cn->parentNode->replaceChild($new_query, $cn);
                            break;

                        }
                    }
                }
            }
        }

        /** Update xml file */
        $xml->save($_SERVER["DOCUMENT_ROOT"] . install_path . 'src/MyCrm/Modules/' . $module_name . '/Conf/queries.xml');
    }

    /** Random an ID and check if it's not already exist in the xml queries file */
    public function getNewQueryId($module_name)
    {
        $id = rand(1, 1000);
        $xml = new \DOMDocument();
        $xml->load($_SERVER["DOCUMENT_ROOT"] . install_path . 'src/MyCrm/Modules/' . $module_name . '/Conf/queries.xml');

        $queries = $xml->getElementsByTagName("queries");
        $trouve = false;

        foreach ($queries as $c) {

            foreach ($c->childNodes as $cn) {

                if ($cn->nodeName == "query") {
                    foreach ($cn->childNodes as $ccn) {
                        if (($ccn->nodeName == "id") && ($ccn->nodeValue == $id)) {
                            $trouve = true;
                            break;
                        }
                    }
                }
            }
        }

        if ($trouve == true) {
            // Run the function again
            getNewQueryId($module_name);
        } else {
            return $id;
        }
    }
}

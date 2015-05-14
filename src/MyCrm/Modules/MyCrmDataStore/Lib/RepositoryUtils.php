<?php
/**
 * Created by PhpStorm.
 * User: Paul
 * Date: 19/02/2015
 * Time: 13:32
 */

namespace MyCrm\Modules\MyCrmDatastore\Lib;


class RepositoryUtils
{

    public function ifRepositoryExist($entityName)
    {
        if (file_exists($_SERVER["DOCUMENT_ROOT"] . install_path . 'src/App/Repositories/' . $entityName . 'Repository.php')) {
            return true;
        } else {
            return false;
        }
    }

    public function createRepository($entityName)
    {
        $this->createRepositoryClass($entityName);
        $this->createRepositoryXml($entityName);

        /** TODO : We have to add the annotation for the repository in the php entity ??? */

    }

    public function createRepositoryXml($entityName)
    {
        $xml = new \DOMDocument();

        $xml_entity = $xml->createElement("Entity");

        $xml_entity_name = $xml->createElement("Name");
        $xml_entity_name->nodeValue = $entityName;

        $xml_queries = $xml->createElement("Queries");
        $xml_query = $xml->createElement("Query");
        $xml_query_name = $xml->createElement("Name");

        $xml_query_name->nodeValue = 'findAllOrderedById';
        $xml_query->nodeValue = 'findAllOrderedById';
        $xml_query->appendChild($xml_query_name);

        $xml_queries->appendChild($xml_query);

        $xml_entity->appendChild($xml_entity_name);
        $xml_entity->appendChild($xml_queries);

        $xml->appendChild($xml_entity);

        $xml->save($_SERVER["DOCUMENT_ROOT"] . install_path . 'src/App/Repositories_xml/' . $entityName . ".xml");
    }

    public function getRepositoryQueries($entityName)
    {
        $xml_content = file_get_contents($_SERVER["DOCUMENT_ROOT"] . install_path . 'src/App/Repositories_xml/' . $entityName . ".xml");
        $params = new \SimpleXMLElement($xml_content);

        $queries = $params->Queries->Query;
        /*foreach ($params->Queries->Query as $query) {
            echo $query->Name, PHP_EOL;
        }*/

        //print_r($params);
        return $queries;
    }

    public function createRepositoryClass($entityName)
    {
        $html = "<?php";
        $html .= "\n";
        $html .= "namespace App\Repositories;";
        $html .= "\n";
        $html .= "use Doctrine\ORM\EntityRepository;";
        $html .= "\n";
        $html .= "class " . $entityName . "Repository extends EntityRepository";
        $html .= "\n";
        $html .= "{";
        $html .= "\n";

        /** Global function to get all object in a list classed by Id */
        $html .= "public function findAllOrderedById()";
        $html .= "\n";
        $html .= "{";
        $html .= "\n";
        $html .= 'return $this->getEntityManager()';
        $html .= "\n";
        $html .= '->createQuery(';
        $html .= "\n";

        $fullEntity = "\App\Entities\\" . $entityName;

        $html .= "'SELECT a FROM " . $fullEntity . " a ORDER BY a.id ASC'";
        $html .= "\n";
        $html .= ")";
        $html .= "\n";
        $html .= "->getResult();";
        $html .= "\n";
        $html .= "}";
        $html .= "\n";

        $html .= "}";
        $html .= "\n";

        /** Write entity file */
        $file = fopen($_SERVER["DOCUMENT_ROOT"] . install_path . 'src/App/Repositories/' . $entityName . 'Repository.php', "w");
        fwrite($file, $html);
        fclose($file);

        return $html;
    }

}
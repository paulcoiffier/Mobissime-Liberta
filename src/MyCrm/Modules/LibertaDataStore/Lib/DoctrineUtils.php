<?php
/**
 * Created by PhpStorm.
 * User: Paul
 * Date: 10/02/2015
 * Time: 12:50
 */

namespace MyCrm\Modules\LibertaDatastore\Lib;


class DoctrineUtils
{

    public function writeEntity($fields, $entityName, $tableName)
    {

        $html = "<?php \n";
        $html .= "namespace App\Entities; \n";
        $html .= "use Doctrine\ORM\Mapping\Id; \n";
        $html .= "use Doctrine\ORM\Mapping\GeneratedValue; \n";
        $html .= "use Doctrine\ORM\Mapping\Entity; \n";
        $html .= "use Doctrine\ORM\Mapping\Table; \n";
        $html .= "use Doctrine\ORM\Mapping\Column; \n";
        $html .= "use Doctrine\ORM\Mapping\OneToMany; \n";
        $html .= "use Doctrine\ORM\Mapping\OneToOne; \n";
        $html .= "use Doctrine\ORM\Mapping\ManyToOne; \n";
        $html .= "use Doctrine\ORM\Mapping\ManyToMany; \n";
        $html .= "use Doctrine\ORM\Mapping\JoinColumn; \n";
        $html .= "/** \n";
        $html .= ' * @Entity(repositoryClass="App\Repositories\\' . $entityName . 'Repository") @Table(name="' . $tableName . '")';
        $html .= " \n";
        $html .= " **/ \n";
        $html .= "class " . $entityName . " \n";
        $html .= "{ \n";

        /** Write generic id autoincrement field */
        $id = $this->writeIdField();
        $html .= $id;

        /** Write fields */
        foreach ($fields as $field) {
            if ($field['field_name'] != "id") {
                $html .= $this->writeField($field);
            }
        }

        $html .= "} \n";

        /** Write entity file */
        $file = fopen($_SERVER["DOCUMENT_ROOT"] . install_path . 'src/App/Entities/' . $entityName . '.php', "w");
        fwrite($file, $html);
        fclose($file);

        /** Remove namespace */
        $this->removeClassNamespace($entityName);

        /** Generate getters and setters */
        $this->generateEntity($entityName);

        /** Add namespace */
        $this->addClassNamespace($entityName);

        /** Update database */
        $this->synchronizeDatabase();

        /** Remove temporary file */
        $this->removeTemporaryFile($entityName);
    }

    public function removeEntity($entity_name, $table_name, $entity_manager)
    {
        unlink($_SERVER["DOCUMENT_ROOT"] . install_path . 'src/App/Entities/' . $entity_name . '.php');

        $sql = "DROP TABLE $table_name;";
        $connection = $entity_manager->getConnection();
        $stmt = $connection->prepare($sql);
        $stmt->execute();
        $stmt->closeCursor();

    }

    public function removeTemporaryFile($entityName)
    {
        unlink($_SERVER["DOCUMENT_ROOT"] . install_path . 'src/App/Entities/' . $entityName . '.php~');
    }

    public function writeField($field)
    {
        $field_name = $field['field_name'];
        $field_type = $field['field_type'];
        $field_size = $field['field_size'];
        $field_nullable = $field['field_nullable'];

        if ($field_size == null) {
            $field_size = "255";
        }

        if ($field_nullable == "true") {
            $field_nullable = "true";
        } else {
            $field_nullable = "false";
        }

        if (strpos($field_type, 'Doctrine') !== false) {
            if (strpos($field_type, 'Doctrine\ORM\Mapping\Id') !== true) {
                /** Add relation field */

                $field_type = str_replace("Doctrine\ORM\Mapping\\", "", $field_type);

                $field_target_entity = $field['field_target_entity'];
                $html = '/**';
                $html .= " \n";
                $html .= '* @' . $field_type . '(targetEntity="' . $field_target_entity . '", cascade={"persist", "merge"}) ';
                $html .= " \n";
                $html .= '* @JoinColumn(name="' . $field_name . '", referencedColumnName="id", nullable=' . $field_nullable . ')';
                $html .= " \n";
                $html .= '*/';
                $html .= " \n";
                $html .= 'public $' . $field_name . ';';
                $html .= " \n\n";
            }

        } else {
            $html = '/** @Column(type="' . $field_type . '", length=' . $field_size . ', nullable=' . $field_nullable . ') * */';
            $html .= " \n";
            $html .= 'public $' . $field_name . ';';
            $html .= " \n\n";
        }

        return $html;

    }

    public function writeIdField()
    {
        $html = '/** @Id @Column(type="integer") @GeneratedValue * */';
        $html .= "\n";
        $html .= 'public $id;';
        $html .= "\n\n";

        return $html;
    }


    public function generateEntity($entityName)
    {
        $results = exec('cd .. && vendor/bin/doctrine orm:generate:entities src/App/Entities --filter="' . $entityName . '"');
    }

    public function synchronizeDatabase()
    {
        $results = exec('cd .. && vendor/bin/doctrine orm:schema-tool:update --force');
    }

    public function addClassNamespace($entityName)
    {
        $file_content = file_get_contents($_SERVER["DOCUMENT_ROOT"] . install_path . 'src/App/Entities/' . $entityName . '.php');
        $file_content = str_replace('//namespace App\Entities;', 'namespace App\Entities;', $file_content);

        $file = fopen($_SERVER["DOCUMENT_ROOT"] . install_path . 'src/App/Entities/' . $entityName . '.php', "w");
        fwrite($file, $file_content);
        fclose($file);
    }

    public function removeClassNamespace($entityName)
    {
        $file_content = file_get_contents($_SERVER["DOCUMENT_ROOT"] . install_path . 'src/App/Entities/' . $entityName . '.php');
        $file_content = str_replace('namespace App\Entities;', '//namespace App\Entities;', $file_content);

        $file = fopen($_SERVER["DOCUMENT_ROOT"] . install_path . 'src/App/Entities/' . $entityName . '.php', "w");
        fwrite($file, $file_content);
        fclose($file);
    }

}
<?php
/**
 * MyCRM
 * Created by Paul Coiffier.
 * Date: 15/01/2015
 * Time: 16:05
 * MyCRM Console script
 */

require('conf/app.inc.php');

date_default_timezone_set('utc');

$ret = arguments($argv);

if ($ret['arguments'] != null) {
    if ($ret['arguments'][0] == 'add:module') {
        echo "***********************************\n";
        echo "**     MyCRM module creation     **\n";
        echo "***********************************\n";

        $errors = false;

        echo "Create new module ?  Type 'yes' to continue: (y)";
        $handle = fopen("php://stdin", "r");
        $line = fgets($handle);
        if (trim($line) == null) {
            $line = "yes";
        }
        if (trim($line) != 'yes') {
            echo "Module creation abort\n";
            exit;
        }

        /**
         * Module name
         */

        $line = " ";
        while (strpos($line, ' ') !== false) {
            echo "Module name : ";
            $handle = fopen("php://stdin", "r");
            $line = fgets($handle);
            if ((strpos($line, ' ') !== false)) {
                echo "Module name does not respect naming convention. Please don't use spaces and special characters in module name\n";
            }
        }

        $module_name = trim($line);

        /**
         * Module description
         */
        echo "Module description : ";
        $handle = fopen("php://stdin", "r");
        $line = fgets($handle);
        $module_description = trim($line);

        /**
         * Author name
         */
        $line = " ";
        while (strlen(trim($line)) < 1) {
            echo "Module author name : ";
            $handle = fopen("php://stdin", "r");
            $line = fgets($handle);
            if (strlen(trim($line)) < 1) {
                echo "Module author name is mandatory\n";
            }
        }

        $author_name = trim($line);

        /**
         * Create module directories
         */
        $errors += createModuleDirectories($module_name, $errors);

        /**
         * Create "ini" file for module
         */
        createIniFile($module_name, $author_name, $module_description);

        /**
         * Create default module header file
         */
        createDefaultModuleHeader($module_name);

        /**
         * Create defaults i18n files
         */
        createI18nFile($module_name, 'french');
        createI18nFile($module_name, 'english');

        /**
         * Create a simple index file for module
         */
        createIndexFile($module_name);

        /**
         * Create a simple controller for module from template
         */
        $controllerFile = 'include/templates/controllerTpl.php';
        $newControllerFile = "modules/" . $module_name . "/controllers/nav_controller.php";

        if (!copy($controllerFile, $newControllerFile)) {
            echo 'Default Controller generated\n';
        }

        $contentViewFile = 'include/templates/contentTpl.html';
        $newsContentViewFile = "modules/" . $module_name . "/views/index.twig.html";

        if (!copy($contentViewFile, $newsContentViewFile)) {
            echo 'Default content template generated\n';
        }

        /**
         * Show error message if needed
         */
        if ($errors) {
            echo "Module creation failed";
        } else {
            echo "Module creation successfull";
        }

    } else if (trim($ret['arguments'][0]) == 'entity:help') {
        echo "***********************************\n";
        echo "**       MyCRM entity help       **\n";
        echo "***********************************\n";
        echo "Differents possible fields type for Doctrine entity\n";
        echo "- string: Type that maps a SQL VARCHAR to a PHP string\n";
        echo "- integer: Type that maps a SQL INT to a PHP integer\n";
        echo "- smallint: Type that maps a database SMALLINT to a PHP integer\n";
        echo "- bigint: Type that maps a database BIGINT to a PHP string\n";
        echo "- boolean: Type that maps a SQL boolean or equivalent (TINYINT) to a PHP boolean\n";
        echo "- decimal: Type that maps a SQL DECIMAL to a PHP string\n";
        echo "- date: Type that maps a SQL DATETIME to a PHP DateTime object\n";
        echo "- time: Type that maps a SQL TIME to a PHP DateTime object\n";
        echo "- datetime: Type that maps a SQL DATETIME/TIMESTAMP to a PHP DateTime object\n";
        echo "- datetimetz: Type that maps a SQL DATETIME/TIMESTAMP to a PHP DateTime object with timezone\n";
        echo "- text: Type that maps a SQL CLOB to a PHP string\n";
        echo "- object: Type that maps a SQL CLOB to a PHP object using serialize() and unserialize()\n";
        echo "- array: Type that maps a SQL CLOB to a PHP array using serialize() and unserialize()\n";
        echo "- simple_array: Type that maps a SQL CLOB to a PHP array using implode() and explode(), with a comma as delimiter\n";
        echo "- json_array: Type that maps a SQL CLOB to a PHP array using json_encode() and json_decode()\n";
        echo "- float: Type that maps a SQL Float (Double Precision) to a PHP double. IMPORTANT: Works only with locale settings that use decimal points as separator\n";
        echo "- guid: Type that maps a database GUID/UUID to a PHP string. Defaults to varchar but uses a specific type if the platform supports it\n";
        echo "- blob: Type that maps a SQL BLOB to a PHP resource stream";

    } else if (trim($ret['arguments'][0]) == 'generate:entity') {
        echo "***********************************\n";
        echo "**     MyCRM entity creation     **\n";
        echo "***********************************\n";

        /**
         * If module is precised, entity will be create in the module "entities" directory
         */
        $isForModule = false;
        if (sizeof($ret['arguments']) >= 2) {
            $moduleName = $ret['arguments'][1];
            $moduleName = substr($moduleName, 7);
            echo "Generate entity for module '" . $moduleName . "'\n";
            $isForModule = true;
        }

        /**
         * Entity name
         */
        $r = false;
        while ($r == false) {
            echo "Entity name : ";
            $handle = fopen("php://stdin", "r");
            $line = fgets($handle);
            $r = true;

            if (strlen((trim($line))) < 1) {
                echo "Entity name is mandatory\n";
                $r = false;
            }

            if ((strpos($line, ' ') !== false)) {
                echo "Entity name does not respect naming convention. Please don't use spaces and special characters in entity name\n";
                $r = false;
            }

        }

        $tableName = "";
        while (strlen(trim($tableName)) < 1) {
            echo "Referenced table name : ";
            $handle = fopen("php://stdin", "r");
            $tableName = fgets($handle);
            $tableName = trim($tableName);
            if (strlen(trim($tableName)) < 1) {
                echo "Referenced table name is mandatory\n";
            }
        }

        $entityName = trim($line);
        $r = "n";

        $fieldList = array();

        while ($r != "f") {
            echo "Add field options : (n) New (r) Relationship (f) Finish: ";
            $handle = fopen("php://stdin", "r");
            $line = fgets($handle);
            $r = trim($line);

            switch ($r) {
                case "n":
                    $fieldName = "";
                    while (strlen(trim($fieldName)) < 1) {
                        echo "Field name : ";
                        $handle = fopen("php://stdin", "r");
                        $fieldName = fgets($handle);
                        $fieldName = trim($fieldName);
                        if (strlen(trim($fieldName)) < 1) {
                            echo "Field name is mandatory\n";
                        }
                    }

                    echo "Field type (string) : ";
                    $handle = fopen("php://stdin", "r");

                    $fieldType = fgets($handle);
                    if (strlen(trim($fieldType) < 1)) {
                        $fieldType = "string";
                    }
                    $fieldType = trim($fieldType);

                    echo "Adding field : Name : " . $fieldName . " | Type : " . $fieldType . "\n";

                    /** Add in array */
                    $newArrayField = array();

                    //array_push($newArrayField, "field_name" . "=>" . $fieldName);
                    //array_push($newArrayField, "field_type" . "=>" . $fieldType);
                    //array_push($newArrayField, "field_size" ."=>". $fieldType );

                    $newArrayField['field_name'] = $fieldName;
                    $newArrayField['field_type'] = $fieldType;

                    array_push($fieldList, $newArrayField);

                    break;

                case "r":
                    echo "Adding OneToOne relationship";
                    $tableName = "";
                    while (strlen(trim($tableName)) < 1) {
                        echo "Referenced table name : ";
                        $handle = fopen("php://stdin", "r");
                        $tableName = fgets($handle);
                        $tableName = trim($tableName);
                        if (strlen(trim($tableName)) < 1) {
                            echo "Referenced table name is mandatory\n";
                        }
                    }

                    $referencedFieldName = "";
                    while (strlen(trim($referencedFieldName)) < 1) {
                        echo "Referenced field name : ";
                        $handle = fopen("php://stdin", "r");
                        $referencedFieldName = fgets($handle);
                        $referencedFieldName = trim($referencedFieldName);
                        if (strlen(trim($referencedFieldName)) < 1) {
                            echo "Referenced field name is mandatory\n";
                        }
                    }

                    $entityFieldName = "";
                    while (strlen(trim($entityFieldName)) < 1) {
                        echo "Entity field name referenced : ";
                        $handle = fopen("php://stdin", "r");
                        $entityFieldName = fgets($handle);
                        $entityFieldName = trim($entityFieldName);
                        if (strlen(trim($entityFieldName)) < 1) {
                            echo "Entity field name referenced is mandatory\n";
                        }
                    }
                    break;
            }
        }

        /**
         * Write the entity file
         */
        if ($isForModule) {
            $entityFile = fopen("modules/" . $moduleName . "/entities/" . $entityName . ".php", "w") or die("Unable to create entity file for module " . $moduleName);
        } else {
            $entityFile = fopen("include/entities/" . $entityName . ".php", "w") or die("Unable to create entity file");
        }

        fwrite($entityFile, "<?php\n");
        fwrite($entityFile, "/** \n");
        fwrite($entityFile, " * @Entity @Table(name=\"" . $tableName . "\") \n");
        fwrite($entityFile, " **/ \n");
        fwrite($entityFile, "class " . $entityName . " \n");
        fwrite($entityFile, "{ \n");

        // Default ID column
        fwrite($entityFile, "    /** @Id @Column(type=\"integer\") @GeneratedValue * */ \n");
        fwrite($entityFile, "    protected \$id; \n");

        //Entity fields
        fwrite($entityFile, " \n");
        fwrite($entityFile, " \n");
        fwrite($entityFile, " \n");
        fwrite($entityFile, " \n");
        fwrite($entityFile, " \n");
        fwrite($entityFile, " \n");
        fwrite($entityFile, " \n");
        fwrite($entityFile, " \n");
        fwrite($entityFile, " \n");
        fwrite($entityFile, " \n");

        foreach ($fieldList as $arr) {
            /**
             * Create new entity field
             */
            foreach ($arr as $key => $value) {
                echo "Key : $key; - Valeur : $value\n";
                if ($key == "field_name") {
                    $field_name = $value;
                } else if ($key == "field_type") {
                    $field_type = $value;
                } else if ($key == "field_length") {
                    $field_length = $value;
                }
            }
            echo "Create new Field : ";
            echo "Name : " . $field_name;
            echo "Type : " . $field_type;
        }


        //print_r($fieldList);
    }
} else {
    echo "***********************************\n";
    echo "**     MyCRM entity creation     **\n";
    echo "***********************************\n";
    echo "Options : \n";
    echo "     add:module : Create a new module\n";
    echo "     generate:entity : Generate a Doctrine entity\n";
    echo "     generate:entity module:<module_name>: Generate a Doctrine entity for a module\n";
    echo "     entity:help : List all Doctrine fields type \n";
}

/**
 * Create INI file for module
 * @param $module_name
 */
function createIniFile($module_name, $author_name, $module_description)
{
    $iniFile = fopen("modules/" . $module_name . "/module.ini", "w") or die("Unable to create ini file for module");
    fwrite($iniFile, "; Module infos\n");
    fwrite($iniFile, "module_name=" . $module_name . "\n");
    fwrite($iniFile, "module_author=" . $author_name . "\n");
    fwrite($iniFile, "module_description=" . $module_description . "\n\n");

    fwrite($iniFile, "; Menu integration\n");
    fwrite($iniFile, "module_has_menu_entry=yes;\n");
    fwrite($iniFile, "module_menu_category=global;\n");
    fwrite($iniFile, "module_menu_sub_category=null;\n");

    fwrite($iniFile, "; If user must be connected to access to this module \n");
    fwrite($iniFile, "module_require_login=yes; \n");
    fwrite($iniFile, " \n");
    fwrite($iniFile, "; Module actions (for rights and security) \n");
    fwrite($iniFile, "[actions] \n");
    fwrite($iniFile, "action[] = Read; \n");
    fwrite($iniFile, "action[] = Create; \n");
    fwrite($iniFile, "action[] = Update; \n");
    fwrite($iniFile, "action[] = Delete; \n");
    fwrite($iniFile, " \n");
    fwrite($iniFile, "; Groups required for module actions \n");
    fwrite($iniFile, "; Define the groups order by actions (example : group[1] if for action[1]) \n");
    fwrite($iniFile, "[groups] \n");
    fwrite($iniFile, "group.Read = admin; \n");
    fwrite($iniFile, "group.Create = admin; \n");
    fwrite($iniFile, "group.Update = admin; \n");
    fwrite($iniFile, "group.Delete = admin; \n");

    fclose($iniFile);
}

function createDefaultModuleHeader($module_name)
{
    $headerFile = fopen("modules/" . $module_name . "/navigation/header.php", "w") or die("Unable to create ini file for module");

    fwrite($headerFile, "<div class=\"row wrapper border-bottom white-bg page-heading\">\n");
    fwrite($headerFile, "    <div class=\"col-sm-4\">\n");
    fwrite($headerFile, "        <h2>" . $module_name . "</h2>\n");
    fwrite($headerFile, "        <ol class=\"breadcrumb\">\n");
    fwrite($headerFile, "            <li>\n");
    fwrite($headerFile, "                <a href=\"index.php\">Home</a>\n");
    fwrite($headerFile, "            </li>\n");
    fwrite($headerFile, "            <li class=\"active\">\n");
    fwrite($headerFile, "                <strong>" . $module_name . "</strong>\n");
    fwrite($headerFile, "            </li>\n");
    fwrite($headerFile, "        </ol>\n");
    fwrite($headerFile, "    </div>\n");
    fwrite($headerFile, "</div>\n");

    fclose($headerFile);
}

/**
 * Create INDEX file for module
 * @param $module_name
 */
function createIndexFile($module_name)
{
    $indexFile = fopen("modules/" . $module_name . "/index.php", "w") or die("Unable to create index file for module");
    fwrite($indexFile, "<?php\n");
    fwrite($indexFile, "/**\n");
    fwrite($indexFile, " * Created by MyCRM Console\n");
    $currentDate = date("D M j G:i:s T Y");
    fwrite($indexFile, " * Date: " . $currentDate . "\n");
    fwrite($indexFile, " */\n");

    fwrite($indexFile, "include 'controllers/nav_controller.php';");
    fwrite($indexFile, "?>");

    fclose($indexFile);
}

function createI18nFile($module_name, $language)
{
    $indexFile = fopen("modules/" . $module_name . "/" . $language . ".php", "w") or die("Unable to create i18n file for module " . $module_name);
    fwrite($indexFile, "[module] \n");
    fwrite($indexFile, "module_name = " . $module_name . " \n");

    fclose($indexFile);
}

/**
 * Module directories creation
 * @param $module_name : Module Name
 */
function createModuleDirectories($module_name, $errors)
{
    /**
     * Directories creation
     */
    echo "Creating directory 'modules/" . $module_name . "' directory...\n";
    $result = makeDir('modules/' . $module_name);
    if (intval($result) == 0) {
        echo "Creating directory 'modules/" . $module_name . "' directory...\n";
    } else {
        echo "Error : a directory with module name already exist in 'modules/" . $module_name . "' directory\n";
        $errors = true;
    }

    /**
     * Navigation directory
     */
    $result = makeDir('modules/' . $module_name . '/navigation');
    if (intval($result) == 0) {
        echo "Creating directory 'navigation'...\n";
    } else {
        echo "Error : creating directory 'navigation'\n";
        $errors = true;
    }

    /**
     * i18n directory
     */
    $result = makeDir('modules/' . $module_name . '/i18n');
    if (intval($result) == 0) {
        echo "Creating directory 'i18n'...\n";
    } else {
        echo "Error : creating directory 'i18n'\n";
        $errors = true;
    }

    /**
     * Controllers directory
     */
    $result = makeDir('modules/' . $module_name . '/controllers');
    if (intval($result) == 0) {
        echo "Creating directory 'controllers'...\n";
    } else {
        echo "Error : creating directory 'controllers'\n";
        $errors = true;
    }

    /**
     * Entities directory
     */
    $result = makeDir('modules/' . $module_name . '/entities');
    if (intval($result) == 0) {
        echo "Creating directory 'entities'...\n";
    } else {
        echo "Error : creating directory 'entities'\n";
        $errors = true;
    }

    /**
     * JS directory
     */
    $result = makeDir('modules/' . $module_name . '/js');
    if (intval($result) == 0) {
        echo "Creating directory 'js'...\n";
    } else {
        echo "Error : creating directory 'js'\n";
        $errors = true;
    }

    /**
     * CSS directory
     */
    $result = makeDir('modules/' . $module_name . '/css');
    if (intval($result) == 0) {
        echo "Creating directory 'css'...\n";
    } else {
        echo "Error : creating directory 'css'\n";
        $errors = true;
    }

    /**
     * Views directory
     */
    $result = makeDir('modules/' . $module_name . '/views');
    if (intval($result) == 0) {
        echo "Creating directory 'views'...\n";
    } else {
        echo "Error : creating directory 'views'\n";
        $errors = true;
    }

    return $errors;
}

/**
 * Create a directory
 * @param $path : direcotry path to create
 * @return int : result
 */
function makeDir($path)
{
    if (!file_exists($path)) {
        $ret = mkdir($path);
        return 0;
    } else {
        return 1;
    }
}

/**
 * Analyse arguments
 * @param $args : arguments list
 * @return array : results
 */
function arguments($args)
{
    array_shift($args);
    $endofoptions = false;

    $ret = array
    (
        'commands' => array(),
        'options' => array(),
        'flags' => array(),
        'arguments' => array(),
    );

    while ($arg = array_shift($args)) {

// if we have reached end of options,
//we cast all remaining argvs as arguments
        if ($endofoptions) {
            $ret['arguments'][] = $arg;
            continue;
        }

// Is it a command? (prefixed with --)
        if (substr($arg, 0, 2) === '--') {

// is it the end of options flag?
            if (!isset ($arg[3])) {
                $endofoptions = true;; // end of options;
                continue;
            }

            $value = "";
            $com = substr($arg, 2);

// is it the syntax '--option=argument'?
            if (strpos($com, '='))
                list($com, $value) = split("=", $com, 2);

// is the option not followed by another option but by arguments
            elseif (strpos($args[0], '-') !== 0) {
                while (strpos($args[0], '-') !== 0)
                    $value .= array_shift($args) . ' ';
                $value = rtrim($value, ' ');
            }

            $ret['options'][$com] = !empty($value) ? $value : true;
            continue;

        }

// Is it a flag or a serial of flags? (prefixed with -)
        if (substr($arg, 0, 1) === '-') {
            for ($i = 1; isset($arg[$i]); $i++)
                $ret['flags'][] = $arg[$i];
            continue;
        }

// finally, it is not option, nor flag, nor argument
        $ret['commands'][] = $arg;
        continue;
    }

    if (!count($ret['options']) && !count($ret['flags'])) {
        $ret['arguments'] = array_merge($ret['commands'], $ret['arguments']);
        $ret['commands'] = array();
    }


    return $ret;
}

exit (0)

/* vim: set expandtab tabstop=2 shiftwidth=2: */
?>
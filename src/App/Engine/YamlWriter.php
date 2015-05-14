<?php
/**
 * Created by PhpStorm.
 * User: Paul
 * Date: 06/02/2015
 * Time: 21:48
 */

namespace App\Engine;


class YamlWriter
{

    public function resetYamlFile($file_path)
    {
        unlink($file_path);
    }

    public function appendToYaml($array, $field_name, $file_path)
    {
        $handle = fopen($file_path, "a+");
        fwrite($handle, $field_name . ":\n");
        $hasNameField = false;

        foreach ($array as $key => $value) {
            if (($key != "options") && ($key != "cascade") && ($key != "fetch") && ($key != "inversedBy") && ($key != "columnDefinition") && ($key != "unique")) {
                if ($key == "name") {
                    $hasNameField = true;
                    fwrite($handle, "    $key: " . $field_name . "\n");
                } else {
                    fwrite($handle, "    $key: " . $value . "\n");
                }

                if ($key == "targetEntity") {
                    fwrite($handle, "    type: " . $value . "\n");
                    fwrite($handle, "    size: \n");
                }
            }
        }
        if (!$hasNameField) {
            fwrite($handle, "    name: " . $field_name . "\n");
        }

        fwrite($handle, "\n");
    }

}
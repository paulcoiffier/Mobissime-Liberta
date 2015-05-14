<?php
/**
 * Created by PhpStorm.
 * User: Paul
 * Date: 30/01/2015
 * Time: 20:24
 */

namespace App\Services;

use Doctrine\Common\Annotations\AnnotationReader;


class AnnotationsParser
{

    public function getClassPropertiesList($class){
        $class_vars = get_class_vars(get_class($class));

        $fields = array();

        foreach ($class_vars as $name => $value) {
            //echo "$name : $value\n";
            $fields[] = $name;
        }

        return $fields;
    }

    public function getClassAnnotations($class)
    {
        $r = new ReflectionClass($class);
        $doc = $r->getDocComment();
        preg_match_all('#@(.*?)\n#s', $doc, $annotations);
        return $annotations[1];
    }

    public function getPropertiesAnnotations($class)
    {
        $annotationReader = new AnnotationReader();
        $reflectionClass = new \ReflectionClass('\App\Entities\User');
        $classAnnotations = $annotationReader->getClassAnnotations($reflectionClass);
        return $classAnnotations;
    }

    public function getPropertyAnnotations($class, $propertyName)
    {
        $annotationReader = new AnnotationReader();
        $reflectionProperty = new \ReflectionProperty($class, $propertyName);
        $propertyAnnotations = $annotationReader->getPropertyAnnotations($reflectionProperty);
        return $propertyAnnotations;
    }

}
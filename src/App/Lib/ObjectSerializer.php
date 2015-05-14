<?php
/**
 * Created by PhpStorm.
 * User: Paul
 * Date: 13/02/2015
 * Time: 22:50
 */

namespace App\Lib;

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;

use \App\Objects\Field;

class ObjectSerializer
{

    public function serializeFile($file, $format, $content)
    {

        $encoders = array(new XmlEncoder('Entity'), new JsonEncoder());
        $normalizers = array(new GetSetMethodNormalizer());
        $serializer = new Serializer($normalizers, $encoders);

        /*$aaa = new \App\Objects\Field();
        $aaa->setFieldName("Test");
        $content->setEntityFields($aaa);*/

        $fp = fopen($file, 'w');
        fwrite($fp, $serializer->serialize($content, $format));
        fclose($fp);
    }

    public function serializeEntity($entity_name, $format, $content){
        $encoders = array(new XmlEncoder('Entity'), new JsonEncoder());
        $normalizers = array(new GetSetMethodNormalizer());
        $serializer = new Serializer($normalizers, $encoders);

        $fp = fopen($_SERVER["DOCUMENT_ROOT"] . install_path . 'src/App/Data/' . $entity_name . ".xml", 'w');
        fwrite($fp, $serializer->serialize($content, $format));
        fclose($fp);
    }

    public function find_xml_entity($entity_name){
        $encoders = array(new XmlEncoder('Entity'), new JsonEncoder());
        $normalizers = array(new GetSetMethodNormalizer());

        $serializer = new Serializer($normalizers, $encoders);
        $data = file_get_contents($_SERVER["DOCUMENT_ROOT"] . install_path . '/src/App/Data/' . $entity_name . ".xml");

        $entity = $serializer->deserialize($data ,'App\Objects\Entity','xml');
        return $entity;
    }

}
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

/**
 * XML Object serializer
 *
 * For the full copyright and license information, please view
 * the file LICENSE that was distributed with this source code.
 *
 * @author Paul Coiffier <coiffier.paul@gmail.com>
 * @copyright 2015 Paul Coiffier | Mobissime - <http://www.mobissime.com>
 */
class ObjectSerializer
{

    /**
     * Serialize to file
     * @param $file Filename
     * @param $format Format (xml, etc)
     * @param $content Content to serialize
     */
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

    /**
     * Serialize a doctrine entity
     * @param $entity_name Entity name
     * @param $format Format (xml, etc)
     * @param $content Content to serialize
     */
    public function serializeEntity($entity_name, $format, $content){
        $encoders = array(new XmlEncoder('Entity'), new JsonEncoder());
        $normalizers = array(new GetSetMethodNormalizer());
        $serializer = new Serializer($normalizers, $encoders);

        $fp = fopen($_SERVER["DOCUMENT_ROOT"] . install_path . 'src/App/Data/' . $entity_name . ".xml", 'w');
        fwrite($fp, $serializer->serialize($content, $format));
        fclose($fp);
    }

    /**
     * Find and return an xml entity
     * @param $entity_name Entity to find
     * @return \App\Objects\Entity Entity object
     */
    public function find_xml_entity($entity_name){
        $encoders = array(new XmlEncoder('Entity'), new JsonEncoder());
        $normalizers = array(new GetSetMethodNormalizer());

        $serializer = new Serializer($normalizers, $encoders);
        $data = file_get_contents($_SERVER["DOCUMENT_ROOT"] . install_path . '/src/App/Data/' . $entity_name . ".xml");

        $entity = $serializer->deserialize($data ,'App\Objects\Entity','xml');
        return $entity;
    }

}
<?php
/**
 * Created by PhpStorm.
 * User: Paul
 * Date: 08/02/2015
 * Time: 20:32
 */

namespace MyCrm\Modules\LibertaModules\Lib;


class FormsGenerator
{

    public function getTextFieldDraggable($field_name, $field_length)
    {
        $html = ' <div class="box box-element ui-draggable" style="display: block;">';
        $html .= '<a href="#close" class="remove label label-danger"><i class="glyphicon glyphicon-remove"></i> remove</a>';
        $html .= '<span class="drag label label-default"><i class="glyphicon glyphicon-move"></i> drag</span>';
        $html .= '<div class="preview">'.$field_name.'</div>';
        $html .= '<div class="view">';
        $html .= $this->getTextField($field_name, $field_length);
        $html .= '</div >';
        $html .= '</div >';

        return $html;
    }

    public function getTextField($field_name, $field_length)
    {

        $html = '<div class="form-group">';
        $html .= '<label for="' . $field_name . '" class="control-label">' . $field_name . ':</label>';
        $html .= '<input type="text" class="form-control" name="' . $field_name . '" id="' . $field_name . '" data-error="' . $field_name . ' is required" required>';
        $html .= '<div class="help-block with-errors" ></div >';
        $html .= '</div >';

        return $html;
    }

}
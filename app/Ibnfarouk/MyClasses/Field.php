<?php

namespace App\Ibnfarouk\MyClasses;

use Form;

/**
 * to create dynamic fields for modules
 */
class Field
{
    function __construct()
    {
        # code...
    }

    /**
     * @param $name
     * @param $label
     * @return string
     */
    public static function text($name , $label)
    {
        return ' 
            <div class="form-group" id="'.$name.'_wrap">
                <label for="'.$name.'">'.$label.'</label>
                <div class="">
                     '. Form::text($name, null , [
            "class" => "form-control",
            "id" =>$name
        ]) .'
                </div>
            </div>
        ';
    }

    /**
     * @param $name
     * @param $label
     * @param float $step
     * @return string
     */
    public static function number($name , $label , $step = 0.01)
    {
        return ' 
            <div class="form-group" id="'.$name.'_wrap">
                <label for="'.$name.'">'.$label.'</label>
                <div class="">
                     '. Form::number($name, null , [
            "class" => "form-control",
            "id" =>$name,
            "step" => $step
        ]) .'
                </div>
            </div>
        ';
    }

    /**
     * @param $name
     * @param $label
     * @return string
     */
    public static function email($name , $label)
    {
        return ' 
            <div class="form-group" id="'.$name.'_wrap">
                <label for="'.$name.'">'.$label.'</label>
                <div class="">
                     '. Form::email($name, null , [
            "class" => "form-control",
            "id" =>$name
        ]) .'
                </div>
            </div>
        ';
    }

    /**
     * @param $name
     * @param $label
     * @return string
     */
    public static function password($name , $label)
    {
        return ' 
            <div class="form-group" id="'.$name.'_wrap">
                <label for="'.$name.'">'.$label.'</label>
                <div class="">
                     '. Form::password($name, [
            "class" => "form-control",
            "id" =>$name
        ]) .'
                </div>
            </div>
        ';
    }

    /**
     * @param $name
     * @param $label
     * @param $plugin
     * @return string
     */
    public static function date($name , $label , $plugin = 'datepicker')
    {
        return ' 
            <div class="form-group" id="'.$name.'_wrap">
                <label for="'.$name.'">'.$label.'</label>
                <div class="">
                     '. Form::text($name, null , [
            "class" => "form-control ".$plugin,
            "id" =>$name
        ]) .'
                </div>
            </div>
        ';
    }


    /**
     * @param $name
     * @param $label
     * @param $options
     * @param string $plugin
     * @param string $placeholder
     * @param null $selected
     * @return string
     */
    public static function select($name , $label, $options , $plugin = 'select2' , $placeholder = 'قم بالاختيار' , $selected = null)
    {
        return '  
            <div class="form-group" id="'.$name.'_wrap">
                <label for="'.$name.'">'.$label.'</label>                              
                <div class="">
                     '.Form::select($name,$options,$selected,[
            "class" => "form-control ".$plugin,
            "id" => $name,
            "placeholder"=> $placeholder
        ]).'
                </div>
            </div>
        ';
    }

    
    public static function multiSelect($name , $label, $options , $selected = null , $plugin = 'select2' , $placeholder = 'قم بالاختيار' )
    {
        return '  
            <div class="form-group" id="'.$name.'_wrap">
                <label for="'.$name.'">'.$label.'</label>                              
                <div class="">
                     '.Form::select($name.'[]',$options,$selected,[
            "class" => "form-control ".$plugin,
            "id" => $name,
            "multiple" =>"multiple",
//            "placeholder"=> $placeholder
        ]).'
                </div>
            </div>
        ';
    }

    /**
     * @param $name
     * @param $label
     * @return string
     */
    public static function textarea($name , $label)
    {
        return ' 
            <div class="form-group" id="'.$name.'_wrap">
                <label for="'.$name.'">'.$label.'</label>
                <div class="">
                     '. Form::textarea($name, null , [
            "class" => "form-control",
            "id" =>$name,
            "rows" => 5
        ]) .'
                </div>
            </div>
        ';
    }

    /**
     * @param $id
     * @param bool $address
     * @param bool $coordinates
     * @param string $height
     * @return string
     */
    public static function gMap($id, $address = true , $coordinates = true , $height = '350')
    {
        $field = new static;

        $addressField = '';
        if ($address)
        {
            $addressField = $field->text('address_en','Address');
        }

        $coordinatesFields = '';
        if ($coordinates) {
            $coordinatesFields = '
                <div class="row">
                    <div class="col-xs-6">
                        ' . $field->text('latitude', 'خط الطول') . '
                    </div>
                    <div class="col-xs-6">
                        ' . $field->text('longitude', 'خط العرض') . '
                    </div>
                </div>
            ';
        }

        return '<div id="'.$id.'">'.$addressField.'<div id="mapField" style="width: 100%; height: '.$height.'px;"></div>'.$coordinatesFields.'</div>';

    }

    /**
     * @param $name
     * @param $label
     * @param string $plugin
     * @return string
     */
    public static function fileWithPreview($name , $label , $plugin = "file_upload_preview")
    {
        return ' 
            <div class="form-group">
                <label for="'.$name.'">'.$label.'</label>
                <div class="">
                     '. Form::file($name , [
            "class" => "form-control ".$plugin,
            "id" =>$name,
            "data-preview-file-type" => "text"
        ]) .'
                </div>
            </div>
        ';
    }

    /**
     * @param $name
     * @param $label
     * @param string $plugin
     * @return string
     */
    public static function multiFileUpload($name , $label , $plugin = "file_upload_preview")
    {
        return ' 
            <div class="form-group">
                <label for="'.$name.'">'.$label.'</label>
                <div class="">
                     '. Form::file($name , [
            "class" => "form-control ".$plugin,
            "id" =>$name,
            "multiple" => "multiple",
            "data-preview-file-type" => "text"
        ]) .'
                </div>
            </div>
        ';
    }

    /**
     * @param $name
     * @param $label
     * @return string
     */
    public static function tagsInput($name , $label)
    {
        return ' 
            <div class="form-group">
                <label for="'.$name.'">'.$label.'</label>
                <div class="">
                     '. Form::text($name, null , [
            "class" => "form-control tagsinput",
            "id" =>$name,
            "data-role" => "tagsinput",
            "onchange" => "return false"
        ]) .'
                </div>
            </div>
        ';
    }

    /**
     * summernote editor
     *
     *
     */
    public static function editor($name, $label, $plugin = 'summernote')
    {
        return '<div class="form-group"><label for="' . $name . '">' . $label . '</label>
                  <div class=""> ' . Form::textarea($name, null, [
            "class" => "form-control " . $plugin,
            "id" => $name,
            "rows" => 10
        ]) . ' </div></div>';
    }
}
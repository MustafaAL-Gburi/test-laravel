<?php

namespace App\Services\FormService;


class FormService {

    private $type = null;
    private $horizontal = false;
    private $labelElement = false;
    private $attributes = [];
    private $options = [];
    private $formGroup = true;
    public $colLabelClasses = 'col-md-4';
    public $colElementClasses = 'col-md-8';

    public function __construct($colLabelClasses = 'col-md-4', $colElementClasses = 'col-md-8')
    {
        $this->colLabelClasses = $colLabelClasses;
        $this->colElementClasses = $colElementClasses;
        $this->reset();
    }

    public function setColLabelClasses($colLabelClasses)
    {
        $this->colLabelClasses = $colLabelClasses;
    }

    public function setColElementClasses($colElementClasses)
    {
        $this->colElementClasses = $colElementClasses;
    }

    private function reset()
    {
        $this->type = null;
        $this->formGroup = true;
        $this->labelElement = false;
        $this->attributes = [];
        $this->options = [];
    }

    public function open($action = '#', $method = 'POST')
    {
        $this->setType('form');
        $this->setAttribute('action', $action);
        $this->method($method);
        $this->setAttribute('accept-charset', 'utf-8');
        $this->noGroup();
        return $this;
    }

    public function openHorizontal($action = '#', $method = 'POST')
    {
        $this->horizontal = true;
        return $this->open($action, $method);
    }

    public function openInline($action = '#', $method = 'POST')
    {
        return $this->open($action, $method)->addClass('form-inline');
    }

    public function method($method = 'POST')
    {
        if ($this->type == 'form') {
            if ($method == 'file' || $method == 'FILE') {
                $this->setAttribute('enctype', 'multipart/form-data');
            }
            $this->setAttribute('method', $method);
        }
        return $this;
    }

    public function action($action = '#')
    {
        if ($this->type == 'form') {
            $this->setAttribute('action', $action);
        }
        return $this;
    }

    public function close()
    {
        return '</form><script>if(window.jQuery){$( ".dialog" ).ready(function(){$(\'[data-toggle="tooltip"]\').tooltip()});}</script>';
    }

    public function setAttribute($name, $value = '')
    {
        $this->attributes[$name] = $value;
        return $this;
    }

    public function setTooltip($value = '',$placement='right')
    {
        $this->attributes['title'] = $value;
        $this->attributes['data-toggle']='tooltip';
        $this->attributes['data-html']='true';
        $this->attributes['data-placement']=$placement;
        /*if ($this->hasAttribute('class')) {
            if (!strpos($this->getAttribute('class'), 'select2')) {
                echo "select";
            }
        }*/
        $this->Tooltip = ['title' => $value, 'data-toggle' => 'tooltip', 'data-html'=> 'true', 'data-placement'=>$placement];
        return $this;
    }

    public function hasAttribute($name)
    {
        return isset($this->attributes[$name]);
    }

    public function getAttribute($name)
    {
        return (isset($this->attributes[$name])) ? $this->attributes[$name] : null;
    }

    public function removeAttribute($name)
    {
        if ($this->hasAttribute($name)) {
            $value = $this->getAttribute($name);
            unset($this->attributes[$name]);
            return $value;
        }
        return null;
    }

    public function addClass($class)
    {
        if (!isset($this->attributes['class'])) {
            $this->setAttribute('class', $class);
        } else {
            $this->setAttribute('class', $this->attributes['class'].' '.$class);
        }
        return $this;
    }

    private function setType($type)
    {
        $this->reset();
        $this->type = $type;
    }

    public function label($label)
    {
        if ($label !== false) {
            $this->labelElement = ['name' => $label, 'attributes' => []];
            if (isset($this->attributes['id'])) {
                $this->addLabelAttribute('for', $this->attributes['id']);
            }
        }
        return $this;
    }

    public function addLabelAttribute($name, $value = '')
    {
        if (isset($this->labelElement['attributes'])) {
            $this->labelElement['attributes'][$name] = $value;
        }
        return $this;
    }

    public function addLabelClass($class)
    {
        if (!isset($this->labelElement['attributes']['class'])) {
            $this->addLabelAttribute('class', $class);
        } else {
            $this->addLabelAttribute('class', $this->labelElement['attributes']['class'].' '.$class);
        }
        return $this;
    }

    public function select($name, $label = false, $options = [])
    {
        $this->setType('select');
        $this->setAttribute('name', $name);
        $this->setAttribute('id', $name);
        $this->addClass('form-control');
        $this->label($label);
        $this->options($options);
        return $this;
    }

    public function radio($name, $label = false, $options = [])
    {
        $this->setType('radio');
        $this->setAttribute('name', $name);
        $this->setAttribute('id', $name);
        $this->setAttribute('type', 'radio');
        $this->label($label);
        $this->options($options);
        return $this;
    }

    public function options($options = [])
    {
        $this->options = $options;
        return $this;
    }

    public function checkbox($name, $label = false, $value = 1)
    {
        $this->setType('checkbox');
        $this->setAttribute('name', $name);
        $this->setAttribute('id', $name);
        $this->setAttribute('value', $value);
        $this->label($label);
        return $this;
    }

    public function textarea($name, $label = false)
    {
        $this->setType('textarea');
        $this->setAttribute('name', $name);
        $this->setAttribute('id', $name);
        $this->addClass('form-control');
        $this->label($label);
        return $this;
    }

    public function text($name, $label = false)
    {
        $this->setType('text');
        $this->setAttribute('name', $name);
        $this->setAttribute('id', $name);
        $this->addClass('form-control');
        $this->label($label);
        return $this;
    }

    public function number($name, $label = false)
    {
        $this->setType('number');
        $this->setAttribute('name', $name);
        $this->setAttribute('id', $name);
        $this->addClass('form-control');
        $this->label($label);
        return $this;
    }

    public function hidden($name, $value = '')
    {
        $this->setType('hidden');
        $this->setAttribute('name', $name);
        $this->setAttribute('id', $name);
        $this->value($value);
        return $this;
    }

    public function input($name, $label = false, $type = 'text', $value = '')
    {
        if ($type == 'hidden') {
            return $this->hidden($name, $value);
        } else {
            if (method_exists($this, $type)) {
                return call_user_func($type, [$name, $label]);
            }
        }
        return $this;
    }

    public function id($id)
    {
        return $this->setAttribute('id', $id);
    }

    public function readonly()
    {
        return $this->setAttribute('readonly', true);
    }

    public function placeholder($placeholder)
    {
        return $this->setAttribute('placeholder', $placeholder);
    }

    public function value($value)
    {
        return $this->setAttribute('value', $value);
    }

    public function disabled()
    {
        return $this->setAttribute('disabled', true);
    }

    public function noGroup()
    {
        $this->formGroup = false;
    }

    private function render()
    {
        $html = '';
        if (!$this->hasAttribute('value') && $this->hasAttribute('name') && request()->has($this->getAttribute('name'))) {
            $key = $this->getAttribute('name');
            $this->setAttribute('value', request()->$key);
        }
        switch ($this->type) {
            case 'form':
                $html = '<form' . $this->_renderAttributes() . '>';
                break;
            case 'select':
                $selected = null;
                if ($this->hasAttribute('value')) {
                    $selected = $this->removeAttribute('value');
                }
                $html = '<select' . $this->_renderAttributes() .'>';
                $html .= $this->_renderOptions($selected);
                $html .= '</select>';
                break;
            case 'radio':
                $selected = null;
                if ($this->hasAttribute('value')) {
                    $selected = $this->removeAttribute('value');
                }
                if ($this->hasAttribute('class')) {
                    $html .= '<div class="'.$this->removeAttribute('class').'">';
                } else {
                    $html .= '<div>';
                }
                $html .= $this->_renderRadioOptions($selected);
                $html .= '</div>';
            //    $this->formGroup = false;
                break;
            case 'hidden':
                $html = '<input type="hidden"' . $this->_renderAttributes() . '>';
                break;
            case 'textarea':
                $value = '';
                if ($this->hasAttribute('value')) {
                    $value = $this->removeAttribute('value');
                }
                $html = '<textarea' . $this->_renderAttributes() . '>' . $value . '</textarea>';
                break;
            case 'text':
                $html = '<input type="text"' . $this->_renderAttributes() . '>';
                break;
            case 'checkbox':
                $html = '<input type="checkbox"' . $this->_renderAttributes() . '>';
                break;
        }
        if ($html != '') {
            if ($this->formGroup) {
                $label = $this->_renderLabel();
                if ($this->horizontal && $label != '') {
                    return '<div class="form-group row" '.(($this->type == 'select' && isset($this->Tooltip) && strpos($this->getAttribute('class'), 'select2'))?$this->_renderAttributes($this->Tooltip):'').'>'.$label.'<div class="'.$this->colElementClasses.'">'.$html.'</div></div>';
                } else {
                    return '<div class="form-group">'.$label.$html.'</div>';
                }
            } else {
                return $this->_renderLabel() . $html;
            }
        }
        return $html;
    }

    private function _renderOptions($selected)
    {
        $html = '';
        foreach ($this->options as $k1 => $v1) {
            if (is_array($v1)) {
                if (!isset($v1['value'])) {
                    $html .= '<optgroup label="' . $k1 . '">';
                    foreach ($v1 as $k2 => $v2) {
                        $html .= $this->_selectAddOption($k2, $v2, $selected);
                    }
                    $html .= '</optgroup>';
                } else {
                    $html .= $this->_selectAddOption($k1, $v1, $selected);
                }
            } else {
                $html .= $this->_selectAddOption($k1, $v1, $selected);
            }
        }
        return $html;
    }

    private function _renderRadioOptions($selected)
    {
        $html = '';
        foreach ($this->options as $key => $value) {
            $attr = $this->attributes;
            $attr['id'] .= '-'.$key;
            if (is_array($value)) {
                $name = '';
                if (isset($value['name'])) {
                    $name = $value['name'];
                    unset($value['name']);
                }
                $val = $name;
                if (isset($value['value'])) {
                    $val = $value['value'];
                    unset($value['value']);
                }
                foreach ($value as $k1 => $v1) {
                    $attr[$k1] = $v1;
                }
                $html .= '<input class="form-control" value="' . $val . '"'. $this->_attributesToHtml($attr) . ((!is_null($selected) && $val == $selected) ? ' checked>' : '>') . '<label for="' . $attr['id'] . '">' . $name . '</label>';
            } else {
                $html .= '<input class="form-control" value="' . $key . '"'. $this->_attributesToHtml($attr) . ((!is_null($selected) && $key == $selected) ? ' checked>' : '>') . '<label for="' . $attr['id'] . '">' . $value . '</label>';
            }
        }
        return $html;
    }

    private function _selectAddOption($value, $name, $selected)
    {
        if (is_array($name)) {
            $attr = $name;
            if (isset($attr['name'])) {
                $name = $attr['name'];
                unset($attr['name']);
            }
            if (!isset($attr['value'])) {
                $attr['value'] = $value;
            }
        } else {
            $attr = ['value' => $value];
        }
        if (is_array($selected)) {
            $sel = (in_array($attr['value'], $selected)) ? ' selected' : '';
        } else {
            $sel = (!is_null($selected) && $attr['value'] == $selected) ? ' selected' : '';
        }
        return '<option ' . $this->_attributesToHtml($attr) . $sel . '>' . $name . '</option>';
    }

    private function _renderAttributes()
    {
        return $this->_attributesToHtml($this->attributes);
    }

    private function _renderLabel()
    {
        $html = '';
        if ($this->labelElement !== false) {

            if ($this->formGroup && $this->horizontal) {
                $this->addLabelClass('col-form-label');
                $this->addLabelClass($this->colLabelClasses);
            }
            $html .= '<label' . $this->_attributesToHtml($this->labelElement['attributes']) . '>' . $this->labelElement['name'] . '</label>';
        }
        return $html;
    }

    private function _attributesToHtml($attributes)
    {
        $rc = '';
        if (!empty($attributes)) {
            foreach ($attributes as $key => $val) {
                $rc .= (is_bool($val)) ? (($val === true) ? ' ' . $key : '') : ' ' . $key . '="' . $val . '"';
            }
        }
        return $rc;
    }

    public function __toString()
    {
        return $this->render();
    }


}

<?php

namespace App\Core;

class Form
{
    private $formCode = '';

    public function create()
    {
        return $this->formCode;
    }


    public static function validate(array $form, array $champs)
    {
        foreach($champs as $champ){
            if(!isset($form[$champ]) || empty($form[$champ])){
                return false;
            }
        }
        return true;
    }

    private function addAttributs(array $attributs): string
    {
        $str = '';

        $short = ['checked', 'disabled', 'readonly', 'multiple', 'required', 'autofocus', 'novalidate', 'formnovalidate'];

        foreach($attributs as $attribut => $value){
            if(in_array($attribut, $short) && $value == true){
                $str.= " $attribut";
            }else{
                $str .= " $attribut=\"$value\"";
            }
        }

        return $str;

    }

    public function startForm(string $method = 'post', string $action = '#', array $attributs = []): self
    {
        $this->formCode .= "<form action='$action' method='$method'";

        $this->formCode .= $attributs ? $this->addAttributs($attributs).'>' : '>';
       
        return $this;
    }

    public function endForm(): self
    {
        $this->formCode .= '</form>';

        return $this;
    }

    public function addlabelFor(string $for, string $texte, array $attributs = []): self
    {
        $this->formCode .= "<label for='$for'";

        $this->formCode .= $attributs ? $this->addAttributs($attributs) : '';

        $this->formCode .= ">$texte</label>";

        return $this;
    }

    public function addInput(string $type, string $name, array $attributs = []): self
    {
        $this->formCode .= "<input type='$type' name='$name'";

        $this->formCode .= $attributs ? $this->addAttributs($attributs). '>' : '>';

        return $this;
    }

    public function addTextarea(string $name, string $value = '', array $attributs = []):self
    {
        $this->formCode .= "<textarea name='$name'";

        $this->formCode .= $attributs ? $this->addAttributs($attributs) : '';

        $this->formCode .= ">$value</textarea>";

        return $this;
    }

    public function addSelect(string $name, array $option, $attributs = []) : self
    {
        $this->formCode .= "<select name='$name'";

        $this->formCode .= $attributs ? $this->addAttributs($attributs).'>' : '>';

        foreach($option as $value => $texte){
            $this->formCode .= "<option value=\"$value\">'$texte'</option>";  
        }

        $this->formCode .= "</select>";

        return $this;
    }

    public function addButton(string $texte, array $attributs = []):self
    {
        $this->formCode .= '<button ';

        $this->formCode .= $attributs ? $this->addAttributs($attributs) : '';

        $this->formCode .= ">$texte</button>";

        return $this;
    }
    

}
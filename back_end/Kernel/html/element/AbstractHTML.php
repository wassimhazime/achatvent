<?php

namespace Kernel\html\element;

class AbstractHTML
{

    protected $intent;

    function __construct($intent)
    {
        $this->intent = $intent;
    }

    protected function labelHTML(array $input, $att = 'class="control-label" '): string
    {
        return '<label ' . $att . 'for="' . $input['Field'] . '">' . str_replace("_", " ", $input['Field']) . '</label>';
        ;
    }

    protected function textareaHTML(array $input, $att = '  class="form-control" '): string
    {
        return ' <textarea  ' . $att . '   name="' . $input['Field'] . '"  placeholder="' . str_replace("_", " ", $input['Field']) . '" value="' . $input['Default'] . '"> </textarea>';
    }

    protected function inputHTML(array $input, $att = ' class="form-control" '): string
    {
        return ' <input type="' . $input['Type'] . '" ' . $att . ' name="' . $input['Field'] . '" placeholder="' . str_replace("_", " ", $input['Field']) . '" value="' . $input['Default'] . '">';
    }

    protected function divHTML(array $TAG, $att = ' class="form-group" ')
    {
        $tag = implode("\n", $TAG);
        return "<div $att> \n $tag \n </div> \n";
    }

    protected function selectHTML(array $input, $att = ' class="form-control" '): string
    {
        $inputHTML = ' <select ' . $att . ' name="' . $input['Field'] . '" >' . "\n";

        foreach ($input['DataFOREIGN_KEY'] as $op) {
            $name = ($input['Field']);

            $inputHTML .= '  <option value="' . $op->id . '">' . $op->$name . '</option>' . "\n";
        }
        $inputHTML .= '</select>';
        return $inputHTML;
    }

    protected function multiSelectHTML(array $input, $att = '  class="multiSelectItemwassim form-control"  '): string
    {
       // class="multiSelectItemwassim form-control"
        $inputHTML = ' <select multiple  ' . $att . '   name="' . $input['Field'] . '[]" >';
        $inputHTML .= $this->chargeListHtml($input['DataCHILDRENS']) . ' </select>';
        return $inputHTML;
    }

    private function chargeListHtml($DataCHILDRENS, $param = '')
    {
        $TAGoption = "";
        foreach ($DataCHILDRENS as $row) {
            if (!isset($row->id)) {
                return "<option></option>";
            }
            $dataOption = '';
            foreach ($row as $column => $value) {
                $dataOption .= $column . '$$$' . $value . ' £££ ';
            }
            $popover = 'data-container="body" data-toggle="popover" data-placement="top" data-content="' . $dataOption . ' "';
            $TAGoption .= "<option $param $popover " . "  value ={$row->id}> $dataOption </option> ";
           // $TAGoption .= "<option $param $popover " . "  value ={$row->id}> {$row->id} </option> ";
        }
        return $TAGoption;
    }
}

<?php
namespace core\html\Bootstrap;

class DialogHTML
{
    
    
    
    public function getBodyDialog($data)
    {
        
        if (isset($data)) {
            $content='';
            foreach ($data[0] as $key => $value) {
                $content.= "<h4 ><small >$key  :</small> <span class='spandialog'>$value </span></h4>";
            }
        }
                return $content;
    }
}

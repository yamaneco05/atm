<?php

class PasswordValid extends BaseValidation{

    public function check($memo) {
    
        if($memo === "") {
            $this->errors[] = "入力されていません。\n正しい暗証番号を入力してください。";
            return false;
        }
        return $memo;
    }  
}

?>
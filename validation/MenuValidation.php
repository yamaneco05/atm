<?php

class MenuValid extends BaseValidation{

    public function check($memo) {

        if($memo === "") {
            $this->errors[] =  "入力されていません。\n1-4の番号を入力してください。";
            return false;
        }
        if( !ctype_digit($memo) || $memo >= Atm::VALID ) {
            $this->errors[] = "1-4の番号を入力してください。";
            return false;
        }
        return $memo;
    }
}
?>
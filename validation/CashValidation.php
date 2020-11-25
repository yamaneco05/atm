<?php

class CashValid extends BaseValidation{

    public function check($memo) {

        if($memo === "") {
            $this->errors[] = "入力されていません。\n正しい金額を入力してください。";
            return false;
        }
        if( !ctype_digit($memo) || $memo < Atm::CLEAR) {
            $this->errors[] = "正しい金額を入力してください。";
            return false;
        }
        return $memo;
    }
}

?>
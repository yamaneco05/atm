<?php

class IdValid extends BaseValidation{

    public function check($memo) {

        if($memo === "") {
            $this->errors[] = "入力されていません。\n正しいid番号を入力してください。";
            return false;
        }
        return $memo;
    }
}

?>
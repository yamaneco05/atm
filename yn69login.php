<?php

require_once 'validation/IdValidation.php';
require_once 'validation/PasswordValidation.php';
require_once 'validation/MenuValidation.php';
require_once 'validation/CashValidation.php';

class User {
    public static $user_list = array(
        0 => array(
            "id" => "1",
            "password" => "1234",
            "name" => "tanaka",
            "balance" => "500000"
        ),
        1 => array(
            "id" => "2",
            "password" => "3456",
            "name" => "suzuki",
            "balance" => "1000000"
        )
    );

    public static function isExistById($id) {
        $keyIndex = array_search($id, array_column(self::$user_list, 'id'));
        return $keyIndex;
    }
    public static function getUserById($keyIndex) {
        $user = self::$user_list[$keyIndex];
        return $user;
    }
}

class BaseValidation {

    protected $errors = array();

    public function getErrorMessages() {
        return $this->errors;
    }
}

class Atm {
    public $user;
    public $keyIndex;
    public $id;
    public $password;
    public $cash = 0;
    public $pay = 0;
    public $with = 0;
    public $validation;
    const BALANCE = 1;
    const PAYMENT = 2;
    const WITHDRAW = 3;
    const CLOSE = 4;
    const VALID = 5;
    const CLEAR = 0;

    public function __construct() {
        $this->login();
    }
    public function login() {

        echo "id番号を入力してください。" . PHP_EOL;
        echo "id番号:" . PHP_EOL;
        $id = $this->input('id');

        $keyIndex = User::isExistById($id);

        if (is_int($keyIndex) === false) {
            echo "そのidは存在しません。" . PHP_EOL;
            return $this->login();
        }
        
        $user = User::getUserById($keyIndex);

        $userPassword = $user["password"];

        echo "暗証番号を入力してください。" . PHP_EOL;
        echo "暗証番号:" . PHP_EOL;
        $password = $this->input('password');

        if ($password == $userPassword) {
            echo "ログインしました。" . PHP_EOL;

            $this->user = $user;
            $this->cash = $user["balance"];
            print_r($this->user);
            $this->main();
            return;
        }
        echo "暗証番号が違います。" . PHP_EOL;
        echo "TOP画面に戻ります。" . PHP_EOL;
        echo "" . PHP_EOL;
        return $this->login();
    }

    public function main() {

        echo "ご希望のお取引内容をお選びください。" . PHP_EOL;
        echo "残高照会は[1],ご入金は[2],お引き出しは[3],終了は[4]を入力して" . PHP_EOL;
        echo "リターンキーを押してください。" . PHP_EOL;
    
        $this->selectMenu();
        return;
    }

    public function selectMenu() {
        
        $memo = $this->input('deal');
        
        if($memo == self::BALANCE) {
            $this->showBalance();
            return;
        }
        if($memo == self::PAYMENT) {
            $this->payment($pay);
            return;
        }
        if($memo == self::WITHDRAW) {
            $this->withdraw($with);
            return;
        }
        if($memo == self::CLOSE) {
            $this->close();
            return;
        }
    }
    public function input($type) {

        $memo = trim(fgets(STDIN));
        
        if($type === 'id') {
    
            $validation = new IdValid;
            $check = $validation->check($memo);
        }

        if($type === 'password') {

            $validation = new PasswordValid;
            $check = $validation->check($memo);
        }

        if($type === 'deal') {
         
            $validation = new MenuValid;
            $check = $validation->check($memo);
        }

        if($type === 'cash') {

            $validation = new CashValid;
            $check = $validation->check($memo);
        }

        if($check == false) {
            foreach( $validation->getErrorMessages() as $error ) {
                echo $error . PHP_EOL;
            }
            return $this->input($type);
        }
        return $memo;
    }

    public function setBalance() {

        if($pay =! self::CLEAR) {
            $cash = $this->pay + $this->cash;
            $this->cash = $cash;
        } 
        if($with =! self::CLEAR) {
            $cash = $this->cash - $this->with;
            $this->cash = $cash;
        }
        $this->cash = $cash;
        return;
    }

    public function showBalance() {
    
        echo "残高:" . $this->cash . "円" . PHP_EOL;
        $this->main();
        return;
    }

    public function payment($pay) {
        echo "ご希望のご入金金額を入力してください。" . PHP_EOL;
        $pay = $this->input('cash');
        $this->pay = $pay;
       
        echo $this->pay . "円のご入金を承りました。" . PHP_EOL;
        
        $this->setBalance();
        $this->pay = self::CLEAR;
        $this->showBalance();
        return;
    }

    public function withdraw($with) {
        echo "ご希望のお引き出し金額を入力してください。" . PHP_EOL;
        $with = $this->input('cash');
        $this->with = $with;
    
        echo $this->with . "円のお引き出しを承りました。" . PHP_EOL;
        
        $this->setBalance();
        $this->with = self::CLEAR;
        $this->showBalance();
        return;
    }

    public function close() {
        echo "ご利用ありがとうございました。" . PHP_EOL;
        return;
    }
}
    $user = new Atm;
    
?>
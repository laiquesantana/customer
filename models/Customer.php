<?php
namespace app\models;

use yii\db\ActiveRecord;

class Customer extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%customer}}';
    }

    public function rules()
    {
        return [
            [['name', 'cpf', 'cep', 'number', 'gender'], 'required'],
            ['cpf', 'match', 'pattern' => '/^\d{11}$/', 'message' => 'Invalid CPF format'], // Validação de formato
            ['cpf', 'validateCpf'], // Validação personalizada de CPF brasileiro
            ['cpf', 'unique', 'message' => 'This CPF has already been taken'], // Validação de unicidade
            ['cep', 'match', 'pattern' => '/^\d{8}$/', 'message' => 'Invalid CEP'],
            ['gender', 'in', 'range' => ['M', 'F'], 'message' => 'Invalid gender'],
            ['complement', 'string'],
            ['address', 'string'],
            ['city', 'string'],
            ['state', 'string', 'max' => 2],
        ];
    }


    public function validateCpf($attribute, $params)
    {
        if (!$this->isValidCpf($this->$attribute)) {
            $this->addError($attribute, 'Invalid CPF');
        }
    }


    private function isValidCpf($cpf)
    {
        $cpf = preg_replace('/[^0-9]/is', '', $cpf);

        if (strlen($cpf) != 11) {
            return false;
        }

        if (preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }

        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }

            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c] != $d) {
                return false;
            }
        }

        return true;
    }
}

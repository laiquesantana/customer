<?php
namespace app\models;

use Firebase\JWT\Key;
use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use Firebase\JWT\JWT;

class User extends ActiveRecord implements IdentityInterface
{
    public $password;

    public static function tableName()
    {
        return '{{%user}}';
    }

    public function rules()
    {
        return [
            [['username', 'password', 'name'], 'required'],
            [['username', 'name'], 'string', 'max' => 255],
            [['password'], 'string', 'min' => 6],
            [['username'], 'unique'],
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->password) {
                $this->password_hash = Yii::$app->security->generatePasswordHash($this->password);
                $this->password = null;
            }
            return true;
        }
        return false;
    }

    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    public function generateJwtToken()
    {
        $params = Yii::$app->params;
        $payload = [
            'iss' => $params['jwtIssuer'],
            'aud' => $params['jwtAudience'],
            'iat' => time(),
            'exp' => time() + $params['jwtExpiry'],
            'uid' => $this->id,
        ];
        return JWT::encode($payload, $params['jwtSecret']);
    }

    // Implementação dos métodos do IdentityInterface
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null): User | IdentityInterface | null
    {
        try {
            $secretKey = Yii::$app->params['jwtSecret'];
            $decoded = JWT::decode($token, new Key($secretKey, 'HS256'));
            return static::findOne($decoded['uid']);
        } catch (\Exception $e) {
            return null;
        }
    }
    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return $this->auth_key;
    }

    public function validateAuthKey($authKey)
    {
        return $this->auth_key === $authKey;
    }
}

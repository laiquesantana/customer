<?php
// commands/CreateUserController.php
namespace app\commands;

use yii\console\Controller;
use yii\console\ExitCode;
use app\models\User;
use Yii;
use yii\db\Exception;

class CreateUserController extends Controller
{
    /**
     * This command creates a new user.
     * @param string $username
     * @param string $password
     * @param string $name
     * @return int Exit code
     * @throws Exception
     */
    public function actionIndex(string $username, string $password, string $name)
    {
        $user = new User();
        $user->username = $username;
        $user->name = $name;
        $user->password = $password;
        $user->generateAuthKey();

        if ($user->save()) {
            echo "User '{$username}' created successfully.\n";
            return ExitCode::OK;
        } else {
            echo "Failed to create user:\n";
            foreach ($user->errors as $errors) {
                foreach ($errors as $error) {
                    echo "- $error\n";
                }
            }
            return ExitCode::UNSPECIFIED_ERROR;
        }
    }

}


<?php
/**
 * @copyright Copyright (c) 2021 深圳市酷瓜软件有限公司
 * @license https://opensource.org/licenses/GPL-2.0
 * @link https://www.koogua.com
 */

namespace App\Services\Logic\Account;

use App\Repos\Account as AccountRepo;
use App\Services\Logic\Service as LogicService;
use App\Validators\Account as AccountValidator;
use App\Validators\Verify as VerifyValidator;

class EmailUpdate extends LogicService
{

    public function handle()
    {
        $post = $this->request->getPost();

        $user = $this->getLoginUser();

        $accountRepo = new AccountRepo();

        $account = $accountRepo->findById($user->id);

        $accountValidator = new AccountValidator();

        $email = $accountValidator->checkEmail($post['email']);

        if ($email != $account->email) {
            $accountValidator->checkIfEmailTaken($post['email']);
        }

        $accountValidator->checkLoginPassword($account, $post['login_password']);

        $verifyValidator = new VerifyValidator();

        $verifyValidator->checkCode($post['email'], $post['verify_code']);

        $account->email = $email;

        $account->update();

        return $account;
    }

}

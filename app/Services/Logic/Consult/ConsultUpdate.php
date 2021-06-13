<?php
/**
 * @copyright Copyright (c) 2021 深圳市酷瓜软件有限公司
 * @license https://opensource.org/licenses/GPL-2.0
 * @link https://www.koogua.com
 */

namespace App\Services\Logic\Consult;

use App\Services\Logic\ConsultTrait;
use App\Services\Logic\Service as LogicService;
use App\Validators\Consult as ConsultValidator;

class ConsultUpdate extends LogicService
{

    use ConsultTrait;

    public function handle($id)
    {
        $post = $this->request->getPost();

        $user = $this->getLoginUser();

        $consult = $this->checkConsult($id);

        $validator = new ConsultValidator();

        $validator->checkEditPriv($consult, $user);

        $data = [];

        if (isset($post['question'])) {
            $data['question'] = $validator->checkQuestion($post['question']);
        }

        if (isset($post['private'])) {
            $data['private'] = $validator->checkPrivateStatus($post['private']);
        }

        $consult->update($data);

        $this->eventsManager->fire('Consult:afterUpdate', $this, $consult);

        return $consult;
    }

}

<?php
/**
 * @copyright Copyright (c) 2021 深圳市酷瓜软件有限公司
 * @license https://opensource.org/licenses/GPL-2.0
 * @link https://www.koogua.com
 */

namespace App\Providers;

use App\Library\Http\Request as MyRequest;

class Request extends Provider
{

    protected $serviceName = 'request';

    public function register()
    {
        $this->di->setShared($this->serviceName, function () {
            return new MyRequest();
        });
    }

}

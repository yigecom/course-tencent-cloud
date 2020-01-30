<?php

namespace App\Models;

use Phalcon\Mvc\Model\Behavior\SoftDelete;

class Consult extends Model
{

    /**
     * 主键编号
     *
     * @var integer
     */
    public $id;

    /**
     * 课程编号
     *
     * @var integer
     */
    public $course_id;

    /**
     * 用户编号
     *
     * @var integer
     */
    public $user_id;

    /**
     * 提问
     *
     * @var string
     */
    public $question;

    /**
     * 回答
     *
     * @var string
     */
    public $answer;

    /**
     * 点赞数量
     *
     * @var int
     */
    public $like_count;

    /**
     * 发布标识
     *
     * @var int
     */
    public $published;

    /**
     * 删除标识
     *
     * @var int
     */
    public $deleted;

    /**
     * 创建时间
     *
     * @var integer
     */
    public $created_at;

    /**
     * 更新时间
     *
     * @var integer
     */
    public $updated_at;

    public function getSource()
    {
        return 'consult';
    }

    public function initialize()
    {
        parent::initialize();

        $this->addBehavior(
            new SoftDelete([
                'field' => 'deleted',
                'value' => 1,
            ])
        );
    }

    public function beforeCreate()
    {
        $this->created_at = time();
    }

    public function beforeUpdate()
    {
        $this->updated_at = time();
    }

}

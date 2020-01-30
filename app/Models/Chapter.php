<?php

namespace App\Models;

use App\Caches\MaxChapterId as MaxChapterIdCache;
use App\Services\ChapterCacheSyncer;
use Phalcon\Mvc\Model\Behavior\SoftDelete;

class Chapter extends Model
{

    /**
     * 文件状态
     */
    const FS_PENDING = 'pending'; // 待上传
    const FS_UPLOADED = 'uploaded'; // 已上传
    const FS_TRANSLATING = 'translating'; // 转码中
    const FS_TRANSLATED = 'translated'; // 已转码
    const FS_FAILED = 'failed'; // 已失败

    /**
     * @var array
     *
     * 点播扩展属性
     */
    protected $_vod_attrs = [
        'model' => 'vod',
        'duration' => 0,
        'file_id' => 0,
        'file_status' => 'pending',
    ];

    /**
     * @var array
     *
     * 直播扩展属性
     */
    protected $_live_attrs = [
        'model' => 'live',
        'start_time' => 0,
        'end_time' => 0,
    ];

    /**
     * @var array
     *
     * 图文扩展属性
     */
    protected $_read_attrs = [
        'model' => 'read',
        'duration' => 0,
        'word_count' => 0,
    ];

    /**
     * 主键编号
     *
     * @var int
     */
    public $id;

    /**
     * 父级编号
     *
     * @var int
     */
    public $parent_id;

    /**
     * 课程编号
     *
     * @var int
     */
    public $course_id;

    /**
     * 标题
     *
     * @var string
     */
    public $title;

    /**
     * 摘要
     *
     * @var string
     */
    public $summary;

    /**
     * 优先级
     *
     * @var int
     */
    public $priority;

    /**
     * 免费标识
     *
     * @var int
     */
    public $free;

    /**
     * 扩展属性
     *
     * @var string
     */
    public $attrs;

    /**
     * 课时数量
     *
     * @var int
     */
    public $lesson_count;

    /**
     * 学员数量
     *
     * @var int
     */
    public $user_count;

    /**
     * 评论数量
     *
     * @var int
     */
    public $comment_count;

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
     * @var int
     */
    public $created_at;

    /**
     * 更新时间
     *
     * @var int
     */
    public $updated_at;

    public function getSource()
    {
        return 'chapter';
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

        if ($this->parent_id > 0) {

            $course = Course::findFirst($this->course_id);

            $attrs = [];

            switch ($course->model) {
                case Course::MODEL_VOD:
                    $attrs = $this->_vod_attrs;
                    break;
                case Course::MODEL_LIVE:
                    $attrs = $this->_live_attrs;
                    break;
                case Course::MODEL_READ:
                    $attrs = $this->_read_attrs;
                    break;
            }

            if (!empty($attrs)) {
                $this->attrs = kg_json_encode($attrs);
            }
        }
    }

    public function beforeUpdate()
    {
        $this->updated_at = time();

        if (!empty($this->attrs)) {
            $this->attrs = kg_json_encode($this->attrs);
        }
    }

    public function afterFetch()
    {
        if (!empty($this->attrs)) {
            $this->attrs = json_decode($this->attrs, true);
        }
    }

    public function afterCreate()
    {
        if ($this->parent_id > 0) {

            $course = Course::findFirst($this->course_id);

            $data = [
                'course_id' => $course->id,
                'chapter_id' => $this->id,
            ];

            switch ($course->model) {
                case Course::MODEL_VOD:
                    $model = new ChapterVod();
                    $model->create($data);
                    break;
                case Course::MODEL_LIVE:
                    $model = new ChapterLive();
                    $model->create($data);
                    break;
                case Course::MODEL_READ:
                    $model = new ChapterRead();
                    $model->create($data);
                    break;
            }
        }

        $maxChapterIdCache = new MaxChapterIdCache();
        $maxChapterIdCache->rebuild();
    }

    public function afterUpdate()
    {
        $chapterCacheSyncer = new ChapterCacheSyncer();
        $chapterCacheSyncer->addItem($this->id);
    }

}

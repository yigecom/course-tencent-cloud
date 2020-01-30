<?php

namespace App\Validators;

use App\Caches\Course as CourseCache;
use App\Caches\MaxCourseId as MaxCourseIdCache;
use App\Exceptions\BadRequest as BadRequestException;
use App\Library\Validator\Common as CommonValidator;
use App\Models\Course as CourseModel;
use App\Repos\Course as CourseRepo;

class Course extends Validator
{

    /**
     * @param int $id
     * @return \App\Models\Course
     * @throws BadRequestException
     */
    public function checkCourseCache($id)
    {
        $id = intval($id);

        $maxCourseIdCache = new MaxCourseIdCache();

        $maxCourseId = $maxCourseIdCache->get();

        /**
         * 防止缓存穿透
         */
        if ($id < 1 || $id > $maxCourseId) {
            throw new BadRequestException('course.not_found');
        }

        $courseCache = new CourseCache();

        $course = $courseCache->get($id);

        if (!$course) {
            throw new BadRequestException('course.not_found');
        }

        return $course;
    }

    /**
     * @param int $id
     * @return \App\Models\Course
     * @throws BadRequestException
     */
    public function checkCourse($id)
    {
        $courseRepo = new CourseRepo();

        $course = $courseRepo->findById($id);

        if (!$course) {
            throw new BadRequestException('course.not_found');
        }

        return $course;
    }

    public function checkModel($model)
    {
        $list = CourseModel::models();

        if (!isset($list[$model])) {
            throw new BadRequestException('course.invalid_model');
        }

        return $model;
    }

    public function checkCover($cover)
    {
        $value = $this->filter->sanitize($cover, ['trim', 'string']);

        if (!CommonValidator::url($value)) {
            throw new BadRequestException('course.invalid_cover');
        }

        $result = parse_url($value, PHP_URL_PATH);

        return $result;
    }

    public function checkTitle($title)
    {
        $value = $this->filter->sanitize($title, ['trim', 'string']);

        $length = kg_strlen($value);

        if ($length < 5) {
            throw new BadRequestException('course.title_too_short');
        }

        if ($length > 50) {
            throw new BadRequestException('course.title_too_long');
        }

        return $value;
    }

    public function checkDetails($details)
    {
        $value = $this->filter->sanitize($details, ['trim']);

        return $value;
    }

    public function checkSummary($summary)
    {
        $value = $this->filter->sanitize($summary, ['trim', 'string']);

        return $value;
    }

    public function checkKeywords($keywords)
    {
        $keywords = $this->filter->sanitize($keywords, ['trim', 'string']);
        $keywords = str_replace(['|', ';', '；', '、', ','], '@', $keywords);
        $keywords = explode('@', $keywords);

        $list = [];

        foreach ($keywords as $keyword) {
            $keyword = trim($keyword);
            if (kg_strlen($keyword) > 1) {
                $list[] = $keyword;
            }
        }

        return implode('，', $list);
    }

    public function checkMarketPrice($price)
    {
        $value = $this->filter->sanitize($price, ['trim', 'float']);

        if ($value < 0 || $value > 10000) {
            throw new BadRequestException('course.invalid_market_price');
        }

        return (float)$value;
    }

    public function checkVipPrice($price)
    {
        $value = $this->filter->sanitize($price, ['trim', 'float']);

        if ($value < 0 || $value > 10000) {
            throw new BadRequestException('course.invalid_vip_price');
        }

        return (float)$value;
    }

    public function checkExpiry($expiry)
    {
        $value = $this->filter->sanitize($expiry, ['trim', 'int']);

        if ($value < 1 || $value > 3 * 365) {
            throw new BadRequestException('course.invalid_expiry');
        }

        return (int)$value;
    }

    public function checkLevel($level)
    {
        $list = CourseModel::levels();

        if (!isset($list[$level])) {
            throw new BadRequestException('course.invalid_level');
        }

        return $level;
    }

    public function checkPublishStatus($status)
    {
        if (!in_array($status, [0, 1])) {
            throw new BadRequestException('course.invalid_publish_status');
        }

        return (int)$status;
    }

    public function checkPublishAbility($course)
    {
        $courseRepo = new CourseRepo();

        $chapters = $courseRepo->findChapters($course->id);

        $totalCount = $chapters->count();

        if ($totalCount == 0) {
            throw new BadRequestException('course.pub_chapter_not_found');
        }

        $publishedCount = 0;

        foreach ($chapters as $chapter) {
            if ($chapter->parent_id > 0 && $chapter->published == 1) {
                $publishedCount++;
            }
        }

        if ($publishedCount < $totalCount / 3) {
            throw new BadRequestException('course.pub_chapter_too_few');
        }
    }

}

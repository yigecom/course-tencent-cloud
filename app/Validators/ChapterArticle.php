<?php

namespace App\Validators;

use App\Exceptions\BadRequest as BadRequestException;

class ChapterArticle extends Validator
{

    public function checkContent($content)
    {
        $value = $this->filter->sanitize($content, ['trim']);

        $length = kg_strlen($value);

        if ($length < 10) {
            throw new BadRequestException('chapter_article.content_too_short');
        }

        if ($length > 65535) {
            throw new BadRequestException('chapter_article.content_too_long');
        }

        return $value;
    }
}
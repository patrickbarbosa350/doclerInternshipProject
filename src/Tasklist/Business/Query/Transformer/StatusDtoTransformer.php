<?php

declare(strict_types=1);

namespace Tasklist\Business\Query\Transformer;

use Tasklist\Business\Query\StatusDTO;

class StatusDtoTransformer
{
    public function transformIntoStatusDto($name): StatusDto
    {
        $dto = new StatusDto();
        $dto->name = $name;
        return $dto;
    }
}
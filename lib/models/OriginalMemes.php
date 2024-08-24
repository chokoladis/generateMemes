<?php

namespace Main\Models;

use Main\Base\Model;

class OriginalMemes extends Model {

    public function getTableName(): string
    {
        return 'm_original_name';
    }

}
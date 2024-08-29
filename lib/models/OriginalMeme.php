<?php

namespace Main\Models;

use Main\Base\Model;

class OriginalMeme extends Model {

    public function getTable(): string
    {
        return 'm_original_meme';
    }

    public function views(string $action = ''){

        $id = $this->id;

        $views = new OriginalMemeViews();
        $count_views = $views->findOne($id, 'views');
        var_dump($count_views);

        if (isset($action) && $action === 'add'){

            if (empty($count_views)){
                echo 'empty- --';
                // add
            } else {
                echo 'no empty- --';
                // $count_views++;
                // $this->model->update(['views' => $count_views], ['id' => $id]);
            }
        }

        return $count_views;
    }
}
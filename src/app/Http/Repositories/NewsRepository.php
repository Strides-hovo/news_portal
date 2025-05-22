<?php

namespace App\Http\Repositories;

use App\Models\News;

class NewsRepository
{
    public function search(array $data)
    {
        return News::whereRaw(
            "MATCH(content, preview) AGAINST (? IN NATURAL LANGUAGE MODE)",
            [$data['search']]
        )
            ->paginate(12);
    }
}

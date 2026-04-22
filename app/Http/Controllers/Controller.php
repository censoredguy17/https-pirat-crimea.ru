<?php

namespace App\Http\Controllers;

use App\Models\Admin\CategoryModel;
use App\Models\Admin\ContentModel;

abstract class Controller
{
    public function __construct(){
        $this->data['categoriesContent'] = CategoryModel::where('showInList', 1)->get();
        $this->data['categoriesIsset'] = ContentModel::where('is_published', 1)->distinct()->pluck('category_id');
    }
}

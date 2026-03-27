<?php

namespace App\Http\Controllers;

use App\Models\Admin\CategoryModel;

abstract class Controller
{
    public function __construct(){
        $this->data['categoriesContent'] = CategoryModel::where('showInList', 1)->get();
    }
}

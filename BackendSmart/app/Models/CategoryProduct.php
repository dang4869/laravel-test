<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryProduct extends Model
{
    use HasFactory;
    protected $table = 'categoryproducts';
    protected $fillable = [
        'category_name', 'slug', 'category_parent'
    ];
    function product(){
        return $this->hasMany('App\Models\Product');
    }
    public static function recursive($categoryproducts, $parents = 0, $level = 1, &$listCategory){
        if(count($categoryproducts)>0){
            foreach($categoryproducts as $key => $value){
                if($value->category_parent == $parents){
                    $value->level = $level;
                    $listCategory[]=$value;
                    unset($categoryproducts[$key]);

                    $parent = $value->id;
                    self::recursive($categoryproducts, $parent, $level + 1, $listCategory);
                }
            }
        }
    }
}

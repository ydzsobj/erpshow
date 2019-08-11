<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //
    protected $table="category";
    public  $timestamps=false;

    //一对一关联
    public function type()
    {
        return $this->hasOne('App\Models\Type','id','type_id');
    }


    public function tree(){
        $category = $this->all();
        return $this->getTree($category,'category_name','id','parent_id');

    }

    //获取分类项
    public function getTree($data,$field_name,$field_id='id',$field_pid='parent_id',$pid='0'){
        $arr = array();
        foreach ($data as $key=>$value){
            if($value->$field_pid == $pid){
                $data[$key][$field_name]=$data[$key][$field_name];
                $arr[] = $data[$key];
                foreach ($data as $k=>$v){
                    if($v->$field_pid == $value->$field_id){
                        $data[$k][$field_name] = '╠═'.$data[$k][$field_name];
                        $arr[] = $data[$k];
                    }
                }
            }
        }
        return $arr;
    }


}

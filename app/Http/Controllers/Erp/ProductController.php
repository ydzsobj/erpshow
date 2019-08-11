<?php

namespace App\Http\Controllers\Erp;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductGoods;
use App\Models\ProductImages;
use App\Models\Type;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('erp.product.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = (new Category())->tree();
        $brand = Brand::get();
        return view('erp.product.create', compact('category','brand'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $table = $request->table;
        if(isset($request->sp_val)){
            foreach ($request->sp_val as $key=>$value){
                $spec_value[$key]['attr_id'] = $key;
                $spec_value[$key]['attr_name'] = $value['attr_name'];
                foreach ($value['attr_value'] as $k=>$v){
                    if($key==1){
                        $spec_color[$k]['color_id'] = $k;
                        $spec_color[$k]['color_name'] = $v;
                        $color_image = 'color_image'.$k;
                        $spec_value[$key]['attr_value'][$k]['attr_value_image'] = $request->$color_image;
                    }
                    $spec_value[$key]['attr_value'][$k]['attr_value_id'] = $k;
                    $spec_value[$key]['attr_value'][$k]['attr_value_name'] = $v;
                }
            }
        }else{
            $spec_value='';
            $request->sp_val='';
        }


        //存储表单信息
        $arr = [
            'product_name' => $request->product_name,
            'product_english' => $request->product_english,
            'category_id' => $request->category_id,
            'type_id' => $request->type_id,
            'brand_id' => $request->brand_id,
            'product_spu' => $request->product_spu,
            'product_barcode' => $request->product_barcode,
            'product_cost_price' => $request->product_cost_price,
            'product_price' => $request->product_price,
            'product_freight' => $request->product_freight,
            'product_size' => $request->product_size,
            'product_weight' => $request->product_weight,
            'product_image' => $request->product_image,
            'product_content' => $request->product_content,
            'supplier_id' => $request->supplier_id,
            'supplier_bid' => $request->supplier_bid,
            'product_commend' => $request->product_commend,
            'product_state' => $request->product_state,
            'spec_name' => is_array($request->sp_val) ? serialize($request->sp_val) : serialize(null),
            'spec_value' => is_array($spec_value) ? serialize($spec_value) : serialize(null),
            'created_at' => date('Y-m-d H:i:s', time()),
        ];
        $lastId = DB::table('product')->insertGetId($arr);


        if(isset($spec_color)){
            foreach($spec_color as $ke=>$val){
                $colorArr[$ke]['color_id'] = $val['color_id'];
                $colorArr[$ke]['color_name'] = $val['color_name'];
                $colorArr[$ke]['product_id'] = $lastId;
                $color_image = 'color_image'.$ke;
                $colorArr[$ke]['product_color_image'] = $request->$color_image;
            }
            ProductImages::insert($colorArr);
        }


        if(isset($table['table-cellEdit'])){
            foreach ($table['table-cellEdit'] as $key=>$value){
                for($i=1;$i<5;$i++){
                    if(isset($value['title_'.$i])){
                        $sku_value[$i] = ['sku_value_id'=>$value['title_'.$i.'_id'],'sku_value_name'=>$value['title_'.$i]];
                    }
                }

                $skuArr[] = [
                    'product_id' => $lastId,
                    'sku_id'=>mt_rand(100000000,999999999),
                    'sku_name'=>$request->product_name,
                    'sku_english' => $request->product_english,
                    'category_id' => $request->category_id,
                    'brand_id' => $request->brand_id,
                    'sku_barcode' => $value['sku_barcode']!=''?$value['sku_barcode']:'',
                    'sku_cost_price' => $value['sku_cost_price']==0?$request->product_cost_price:$value['sku_cost_price'],
                    'sku_price' => $value['sku_price']==0?$request->product_price:$value['sku_price'],
                    'sku_num' => $value['sku_num']!=0?$value['sku_num']:0,
                    'sku_num_alarm' => 0,
                    'sku_value' => serialize($sku_value),
                    'sku_image' => $request->product_image,
                    'sku_state' => $request->product_state,
                    'created_at' => date('Y-m-d H:i:s', time()),
                ];
            }
        }else{
            $skuArr = [
                'product_id' => $lastId,
                'sku_id'=>mt_rand(100000000,999999999),
                'sku_name'=>$request->product_name,
                'sku_english' => $request->product_english,
                'category_id' => $request->category_id,
                'brand_id' => $request->brand_id,
                'sku_barcode' => $request->sku_barcode,
                'sku_cost_price' => $request->product_cost_price,
                'sku_price' => $request->product_price,
                'sku_num' => 0,
                'sku_num_alarm' => 0,
                'sku_value' => serialize(null),
                'sku_image' => $request->product_image,
                'sku_state' => $request->product_state,
                'created_at' => date('Y-m-d H:i:s', time()),
            ];
        }


        $result = ProductGoods::insert($skuArr);
        return $result ? '0' : '1';

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //展示操作
        $data = Product::find($id);
        return view('erp.product.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $category = (new Category())->tree();
        $data = Product::find($id);
        return view('erp.product.edit', compact('data', 'category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //更新操作
        $result = Product::find($id);
        $result->product_name = $request->product_name;
        $result->product_english = $request->product_english;
        $result->category_id = $request->category_id;
        $result->type_id = $request->type_id;
        $result->brand_id = $request->brand_id;
        $result->product_spu = $request->product_spu;
        $result->product_barcode = $request->product_barcode;
        $result->product_costprice = $request->product_costprice;
        $result->product_price = $request->product_price;
        $result->product_freight = $request->product_freight;
        $result->product_size = $request->product_size;
        $result->product_weight = $request->product_weight;
        $result->product_image = $request->product_image;
        $result->product_content = $request->product_content;
        $result->supllier_id = $request->supllier_id;
        $result->supllier_bakid = $request->supllier_bakid;
        $result->product_commend = $request->product_commend;
        $result->product_state = $request->product_state;
        $result->updated_at = date('Y-m-d H:i:s', time());
        return $result->save() ? '0' : '1';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
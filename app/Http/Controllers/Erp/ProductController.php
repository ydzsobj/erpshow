<?php

namespace App\Http\Controllers\Erp;

use App\Exports\ProductExport;
use App\Models\AttributeValue;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductGoods;
use App\Models\ProductImages;
use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

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
        $category = (new Category())->group();
        $brand = Brand::where('show','1')->get();
        $supplier = Supplier::where('show','1')->get();
        return view('erp.product.create', compact('category','brand','supplier'));
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
                $spec_value[$key]['attr_english'] = $value['attr_english'];
                $tmp_array = AttributeValue::where('attr_id',$key)->get(['id','attr_value_english'])->toArray();
                $attr_array=array_column($tmp_array,'attr_value_english','id');
                foreach ($value['attr_value'] as $k=>$v){
                    if($key==1){
                        $spec_color[$k]['color_id'] = $k;
                        $spec_color[$k]['color_name'] = $v;
                        $color_image = 'color_image'.$k;
                        $spec_value[$key]['attr_value'][$k]['attr_value_image'] = $request->$color_image;
                    }

                    $spec_value[$key]['attr_value'][$k]['attr_value_id'] = $k;
                    $spec_value[$key]['attr_value'][$k]['attr_value_name'] = $v;
                    $spec_value[$key]['attr_value'][$k]['attr_value_english'] = $attr_array[$k];
                }
            }
        }else{
            $spec_value='';
            $request->sp_val='';
        }

        $max_spuId = Product::where('category_id',$request->category_id)->max('spu_id');
        if(isset($max_spuId)){$spuId = $max_spuId+1;}else{$spuId = 1;}
        $spuStr = str_pad($spuId,4,'0',STR_PAD_LEFT);
        $cate = Category::where('id',$request->category_id)->first('category_code');
        $category_code = substr($cate->category_code,0,2);
        $product_spu = $category_code.'00'.$spuStr;


        //存储表单信息
        $arr = [
            'product_name' => $request->product_name,
            'product_english' => $request->product_english,
            'spu_id' => $spuId,
            'category_id' => $request->category_id,
            'type_id' => $request->type_id,
            'brand_id' => $request->brand_id,
            'product_spu' => $product_spu,
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
            'supplier_url' => $request->supplier_url,
            'supplier_burl' => $request->supplier_burl,
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
                $sku_5 = $value['title_1_code'];
                if(isset($value['title_2_code'])){$sku_6=$value['title_2_code'];}else{$sku_6='00';}

                $skuArr[] = [
                    'product_id' => $lastId,
                    'sku_id'=>$product_spu.$sku_5.$sku_6,
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
                'sku_id'=>$product_spu.'0000',
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
        $brand = Brand::get();
        $supplier = Supplier::get();
        return view('erp.product.edit', compact('data', 'category','brand','supplier'));
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
        $result->product_cost_price = $request->product_cost_price;
        $result->product_price = $request->product_price;
        $result->product_freight = $request->product_freight;
        $result->product_size = $request->product_size;
        $result->product_weight = $request->product_weight;
        $result->product_image = $request->product_image;
        $result->product_content = $request->product_content;
        $result->supplier_id = $request->supplier_id;
        $result->supplier_bid = $request->supplier_bid;
        $result->supplier_url = $request->supplier_url;
        $result->supplier_burl = $request->supplier_burl;
        $result->product_commend = $request->product_commend;
        $result->product_state = $request->product_state;
        //$result->updated_at = date('Y-m-d H:i:s', time());
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


    public function export()
    {
        $data = Product::all(['id','product_name','product_english','product_spu']);
        $headings = [
            '产品ID',
            '产品名称',
            '产品英文名称',
            '产品spu'
        ];
        return Excel::download(new ProductExport($data,$headings),'产品列表'.date('Y-m-d H_i_s').'.xlsx');
    }


}

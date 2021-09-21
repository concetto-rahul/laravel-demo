<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Validator;
use Storage;
use Mail;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
            "success"=>true,
            "message"=>"Profile",
            "data"=>Product::orderBy('id','desc')->with('user')->paginate(5)
        ],200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $save_data=$request->all();

        $validator = Validator::make($save_data, [
            "name"=>['required', 'string', 'max:255'],
            "sku_code"=>['required','unique:products'],
            "description"=>['required', 'string'],
            "imageviewfile"=>['image','mimes:png,gif','max:2048']
        ]);

        if ($validator->fails()) {
            return response()->json(["success"=>false,'message'=>"Validation fail",'data'=>$validator->errors()], 422);
        }
        
        $filename = null;
        if(!empty($request->file('imageviewfile'))){
            $filename = Storage::put('product_image',$request->file('imageviewfile'));
        }
        
        $product_data=Product::create([
            'name' => $save_data['name'],
            'sku_code' => $save_data['sku_code'],
            'imageviewfile' => $filename,
            'description' => $save_data['description'],
            'added_by' =>auth('api')->user()->id,
            'update_by' =>auth('api')->user()->id
        ]);
        
        $details=[
            'name' => $save_data['name'],
            'sku_code' => $save_data['sku_code'],
            'imageviewfile' => $filename,
            'added_by'=>auth('api')->user()->name,
            'added_id'=>auth('api')->user()->id
        ];
        Mail::to('rahul.patil@concettolabs.com')->send(new \App\Mail\ProductAddMail($details));
        
        return response()->json([
            "success"=>true,
            "message"=>"Product Added",
            "data"=>$product_data
        ],200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product_data=Product::find($id);
        if($product_data){
            return response()->json([
                "success"=>true,
                "message"=>"Product Data",
                "data"=>Product::find($id)
            ],200);
        }else{
            return response()->json(["success"=>false,'message'=>"Invalid Id",'data'=>[]], 422);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product_data=Product::find($id);
        if($product_data){
            return response()->json([
                "success"=>true,
                "message"=>"Product Data",
                "data"=>Product::find($id)
            ],200);
        }else{
            return response()->json(["success"=>false,'message'=>"Invalid Id",'data'=>[]], 422);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if(Product::find($id)){
            $save_data=$request->all();
            
            $validator = Validator::make($save_data, [
                "name"=>['required', 'string', 'max:255'],
                "sku_code"=>['required','unique:products,sku_code,'.$id],
                "description"=>['required', 'string'],
                "imageviewfile"=>['image','mimes:png,gif','max:2048']
            ]);

            if ($validator->fails()) {
                return response()->json(["success"=>false,'message'=>"Validation fail",'data'=>$validator->errors()], 422);
            }

            $update_data=[
                'name' => $save_data['name'],
                'sku_code' => $save_data['sku_code'],
                'description' => $save_data['description'],
                'update_by' =>auth('api')->user()->id
            ];

            if(!empty($request->file('imageviewfile'))){
                $update_data['imageviewfile'] = Storage::put('product_image',$request->file('imageviewfile'));
            }
            
            $product_data=Product::where('id',$id)->update($update_data);

            return response()->json([
                "success"=>true,
                "message"=>"Product Updated",
                "data"=>Product::find($id)
            ],200);
        }else{
            return response()->json(["success"=>false,'message'=>"Invalid Id",'data'=>[]], 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Product::where('id',$id)->delete();
        return response()->json([
            "success"=>true,
            "message"=>"Product Deleted",
            "data"=>[]
        ],200);
    }
}

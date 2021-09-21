<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Validator;
use Auth;
use Storage;
use Mail;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $tab="products";
        $title="Products List";
        $list=Product::orderBy('id','desc')->with('user')->paginate(2);
        return view('products.list',compact('tab','title','list'));
    }

    public function add()
    {
        $tab="products";
        $title="Product Add";
        $detail=[];
        return view('products.form',compact('tab','title','detail'));
    }

    public function save(Request $request){
        
        $this->validate($request,[
            "name"=>['required', 'string', 'max:255'],
            "sku_code"=>['required','unique:products'],
            "description"=>['required', 'string'],
            "imageviewfile"=>['image','mimes:png,gif','max:2048']
        ]);
        $save_data=$request->all();
        
        $filename = null;
        if(!empty($request->file('imageviewfile'))){
            $filename = Storage::put('product_image',$request->file('imageviewfile'));
        }
        
        Product::create([
            'name' => $save_data['name'],
            'sku_code' => $save_data['sku_code'],
            'imageviewfile' => $filename,
            'description' => $save_data['description'],
            'added_by' =>Auth::user()->id,
            'update_by' =>Auth::user()->id
        ]);
        
        $details=[
            'name' => $save_data['name'],
            'sku_code' => $save_data['sku_code'],
            'imageviewfile' => $filename,
            'added_by'=>Auth::user()->name,
            'added_id'=>Auth::user()->id
        ];
        Mail::to('rahul.patil@concettolabs.com')->send(new \App\Mail\ProductAddMail($details));
        
        return redirect()->route('products.list')
            ->with('status', 'Data added successfully');
    }

    public function edit($id)
    {
        $tab="products";
        $title="Product Update";
        $detail=Product::find($id);
        return view('products.form',compact('tab','title','detail'));
    }

    function save_update(Request $request,$id){

        $this->validate($request,[
            "name"=>['required', 'string', 'max:255'],
            "sku_code"=>['required','unique:products,sku_code,'.$id],
            "description"=>['required', 'string'],
            "imageviewfile"=>['image','mimes:png,gif','max:2048']
        ]);
        $save_data=$request->all();

        $update_data=[
            'name' => $save_data['name'],
            'sku_code' => $save_data['sku_code'],
            'description' => $save_data['description'],
            'update_by' =>Auth::user()->id
        ];

        if(!empty($request->file('imageviewfile'))){
            $update_data['imageviewfile'] = Storage::put('product_image',$request->file('imageviewfile'));
        }

        Product::where('id',$id)->update($update_data);

        return redirect()->route('products.list')
            ->with('status', 'Data update successfully');

    }

    function delete_data($id){
        Product::where('id',$id)->delete();
        return redirect()->route('products.list')
            ->with('status', 'Data deleted successfully');
    }
}

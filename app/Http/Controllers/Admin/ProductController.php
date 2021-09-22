<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Validator;
use Auth;
use Storage;
use Mail;
use DB;
use Log;
use App\Http\Requests\Product\UpdateProduct;
use App\Http\Requests\Product\StoreRequest;

use Spatie\Permission\Traits\HasRoles;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:product-list|product-create|product-edit|product-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:product-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:product-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:product-delete', ['only' => ['destroy']]);
    }

    public function index(){
        // $user = Auth::user();
        $tab="product";
        $title="Products List";
        $list=Product::orderBy('id','desc')->with('user')->paginate(2);
        return view('admin.product.index',compact('tab','title','list'));
    }

    public function tablejson(Request $request){
        
        $columns = array(
            0 => 'name',
            1 => 'sku_code',
            2 => 'created_at',
            3 => 'added_by_name',
        );
        $user = Auth::user();
        $limit = $request->input('length');
        $start = $request->input('start');
        $search = $request->input('search.value');
        $draw = $request->input('draw');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        $query = $query = Product::join('users','users.id','products.added_by')
                ->select('products.*','users.name as added_by_name');

        $totalData = $query->count();
        $totalFiltered = $totalData;

        if (!empty($search)) {
            $query = $query->where(function($q) use ($search){
                $q->where('users.name', 'LIKE', "%{$search}%")
                ->orWhere('products.name', 'LIKE', "%{$search}%")
                ->orWhere('products.sku_code', 'LIKE', "%{$search}%");
            });            

            $totalFiltered = $query->count();
        }
        $filters = $query->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

        $data = array();
        if (!empty($filters)) {
            foreach ($filters as $value) {
                $id = $value->id;
                $view = route('admin.product.show',[app()->getLocale(),$id]);
                $edit = route('admin.product.edit',[app()->getLocale(),$id]);

                $nestedData['id'] = $id;
                $nestedData['name'] = $value->name;
                $nestedData['sku_code'] = $value->sku_code;
                $nestedData['created_at'] = $value->created_at->format('d/m/Y H:i A');
                $nestedData['added_by'] = $value->added_by_name;
                
                $viewButton = "<a role='button' href='" . $view . "' title='View' data-original-title='View' class='btn btn-outline-primary btn-sm' data-toggle='tooltip'><i class='fa fa-eye'></i></a>";
                $deleteButton=$editButton="";
                if($user->can('product-edit')){
                    $editButton = "<a role='button' href='" . $edit . "' title='Edit' data-original-title='Edit' class='btn btn-outline-primary btn-sm' data-toggle='tooltip'><i class='fa fa-edit'></i></a>";
                }
                
                if($user->can('product-delete')){
                    $deleteButton = "<a role='button' href='javascript:void(0)'  onclick='deleteProduct(" . $id . ")' title='Delete' data-original-title='Delete' class='btn btn-outline-danger btn-sm' data-toggle='tooltip'><i class='fa fa-trash'></i></a>";
                }

                $nestedData['actions'] = "$editButton $viewButton $deleteButton";
                $data[] = $nestedData;
            }
        }

        $jsonData = array(
                    "draw" => intval($draw),
                    "recordsTotal" => intval($totalData),
                    "recordsFiltered" => intval($totalFiltered),
                    "data" => $data,
                );
        return response()->json($jsonData);
    }

    public function create(){
        $tab="product";
        $title="Add New Product";
        $detail=[];
        return view('admin.product.form',compact('tab','title','detail'));
    }

    public function store(StoreRequest $request){
        try {
            Log::info('Start code for add product.');
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
            
            Log::info('End code for add product.');
            
            notify()->success("Product has been added successfully.", "Success", "topRight");
            return redirect()->route('admin.product.index',app()->getLocale());
            
        } catch(\Exception $exception){
            Log::info('Exception code for add product.');
            Log::info($exception);
            notify()->error("Failed to add product", "Error", "topRight");
            return redirect()->route('admin.product.index',app()->getLocale());
        }
    }

    public function edit($lng,$id){
        $tab="product";
        $title="Edit Product";
        $detail=Product::find($id);
        return view('admin.product.form',compact('tab','title','detail'));
    }

    public function update(UpdateProduct $request,$lng,$id){
        try {
            //UpdateProduct
            // $request->segment(2);
            Log::info('Start code for update product.');
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

            Log::info('End code for update product.');
            
            notify()->success("Product has been updated successfully.", "Success", "topRight");
            return redirect()->route('admin.product.index',app()->getLocale());
        } catch(\Exception $exception) {
            Log::info('Exception code for update product.' . $exception);
            Log::info($exception);
            notify()->error("Failed to update product", "Error", "topRight");
            return redirect()->route('admin.product.index',app()->getLocale());
        }
    }

    public function show($lng,$id){
        return $id;
    }

    public function delete($lng,$id){
        return view('admin.product.delete', compact('id'));
    }
    
    public function destroy(Request $request,$lng,$id){
        try {  
            Log::info('Start code for delete product.');
            // DB::beginTransaction();
            // $product_data = Product::find($id);
            Product::where('id',$id)->delete();
            // DB::commit();
            Log::info('End code for delete product.');
            
            notify()->success("Product has been deleted successfully.", "Success", "topRight");
            return redirect()->route('admin.product.index',app()->getLocale());
        } catch(\Exception $exception) {
            // DB::rollBack();
            Log::info('Exception code for delete product.' . $exception);
            Log::info($exception);
            notify()->error("Failed to delete product", "Error", "topRight");
            return redirect()->route('admin.product.index',app()->getLocale());
        }
    }
}

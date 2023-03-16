<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\category;
use App\Models\Author;
use App\Models\author_book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\validator;
use Illuminate\Support\Facades\DB;
use App\Services\payUService\Exceptor;
use App\Http\Resources\author_book_Resource;
use Illuminate\Support\Arr;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if(is_null( $request->category_filter) and is_null($request->Author ) and is_null($request->Search)){
            $query=Book::paginate(10);
            return API_Response($query,'ok',200);
        }
        elseif(is_null( $request->category_filter) and is_null($request->Author)){
            $search=$request->Search;
            $data=Book::where('name','=',$search)->get();
            if(is_null($data)){
                return API_Response($data,'not found',404);
            }
            else{
                return API_Response($data,'ok',200) ;
            }
        }
        
        // elseif(is_null( $request->category_filter)  and is_null($request->Search)){
        //     $Author=$request->Author;
        //     $Author_Data=Author::where('Name','=',$Author)->get();
        //     if(is_null($Author_Data)){
        //         return API_Response(null,'not found',404);
        //     }
        //     else{
        //         $Author_id=$Author_Data->value('id');
        //         // $data=author_book::where('Author_id','=',$Author_id)->get();
        //         $data=author_book_Resource::collection(author_book::where('Author_id','=',$Author_id)->get());
        //         $array = Arr::undot($data);
                

        //         return $array->book;
        //         $book_id=$data->book_id;
        //         $data_book=book::where('id','=',$book_id)->get();
        //         return $data_book;
        //         // return API_Response($data,'ok','200');
        //     }
        // }
        elseif( is_null($request->Author ) and is_null($request->Search)){
            $category_filter=$request->category_filter;
            $data_category=Category::where('name','=',$category_filter)->get();
            if(is_null($data_category)){
                return API_Response(null,'not found',404);
            }
            else{
                $category_id=$data_category->value('id');
                $data=Book::where('category_id','=',$category_id)->paginate(1);
                return API_Response($data,'ok','200');
            }
            
        }
        else{
            return API_Response(null,'لايمكنك البحث باكثر من طريقه في نفس الوقت',404) ;
        } 
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator=validator::make($request->all(),validaor(),message_error());
        if($validator->fails()){
            return API_Response($validator->errors(),'errors',404) ;
        }
        $image_path=save_files($request->image);
        $book_path=save_files($request->file_path);
        $audio_book_path=save_files($request->book_audio);
        $data=Book::create([
            'name'=> $request->name,
            'Publisher_id'=>$request->Publisher_id,
            'accepted'=>$request->accepted,
            'category_id'=>$request->category_id,
            'edition'=>$request->edition,
            'description'=>$request->description,
            'file_path'=>$book_path,
            'image'=>$image_path,
            'book_audio'=>$audio_book_path
        ]);
        return API_Response($data->id,'ok',200);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $book=book::findOrfail($id);
        $category_id=$book->category_id;
        $books=DB::table('books')
        ->where('category_id','=',$category_id)
        ->where('name','<>',$book->name)->get();
        $books=[
            [$book],[$books]
        ];
        return API_Response($books,'ok',200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        //
    }
}

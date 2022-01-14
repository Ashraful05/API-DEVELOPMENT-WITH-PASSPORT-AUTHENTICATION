<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function createBook(Request $request)
    {
        //validate
        $this->validate($request,[
            'title'=>'required',
            'book_cost' => 'required'
        ]);
        //create book data...
        $book = new Book();
        $book->title = $request->title;
        $book->book_cost=$request->book_cost;
        $book->description = $request->description;
        $book->author_id = auth()->user()->id;
        $book->save();
        //send response....
        return response()->json([
            'status' => 1,
            'message' => 'Book created successfully!!!'
        ]);
    }
    public function listBook()
    {
        $book  = Book::all();
        return response()->json([
            'status' => true,
            'data' => $book
        ]);
    }
    public function authorBook(){
        $author_id = auth()->user()->id;
        $books = Author::find($author_id)->book;
        return response()->json([
            'status'=>true,
            'data'=>$books
        ]);
    }
    public function listSingleBook($id)
    {
        $author_id = auth()->user()->id;
        if(Book::where([
            'author_id' => $author_id,
            'id' => $id
        ])->exists()){
            $book = Book::find($id);
//            $book = Book::where('id',$id);
            return response()->json([
                'status' => true,
                'data' => $book,
            ]);
        }
        else{
            return response()->json([
                'status' => false,
                'message' => 'Book not found!!!'
            ]);
        }
    }
    public function updateBook(Request $request,$id)
    {
        $author_id = auth()->user()->id;
        if(Book::where([
            'author_id'=>$author_id,
            'id'=>$id
        ])->exists()){
            $book = Book::find($id);
            $book->title = isset($request->title) ? $request->title : $book->title;
            $book->description = isset($request->description) ? $request->description : $book->description;
            $book->book_cost = isset($request->book_cost) ? $request->book_cost : $book->book_cost;
            $book->update();
            return response()->json([
               'status'=>true,
               'message'=>"Book data has been updated!!!"
            ]);
        }else{
            return response()->json([
               'status'=>false,
               'message'=>'Data Not found!!!'
            ]);
        }
    }
    public function deleteBook($id)
    {
        $author_id = auth()->user()->id;
        if(Book::where([
            'author_id'=>$author_id,
            'id'=>$id
        ])->exists()){
            $book = Book::find($id);
            $book->delete();
            return response()->json([
               'status'=>true,
               'message'=>'Book deleted successfully!!!'
            ]);
        }else{
            return response()->json([
               'stats'=>false,
               'message'=>'Book not Exists!!!!'
            ]);
        }
    }
}

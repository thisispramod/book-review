<?php

namespace App\Http\Controllers;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $title = $request->input('title'); // use $title consistently

        $filter = $request->input('filter','');

        
        $books = Book::when(
            $title, 
            function ($query, $title){ 
                return $query->title($title);
            });
            $books = match($filter){  
                'highest_rated' => $books->highestRated(),
                'popular_last_month' => $books->PopularLastMonth(),
                'popular_last_6months' => $books->PopularLast6Months(),
                'popular_rated_last_month' => $books->HighestRatedLastMonth(),
                'popular_rated_last_6months' => $books->HighestRatedLast6Months(),
                default => $books->latest(),
            };
            $books = $books->get(); 
        return view('books.index', ['books' => $books]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
    public function show(Book $book)
    {
        return view(
            'books.show',
            [
                'book' => $book->load([
                    'reviews' => fn($query) => $query->latest()
                ])
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

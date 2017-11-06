<?php

namespace App\Http\Controllers;

//use
use Auth;
use App\Models\Tag;
use App\Models\User;
use App\Models\Quote;

use Illuminate\Http\Request;

class QuoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $quotes = Quote::with('tags')->get();
        return view('quotes.index', compact('quotes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tags = Tag::all();
        return view('quotes.create', compact('tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|min:3',
            'subject' => 'required|min:5',
        ]);

        $request->tags = array_diff($request->tags, [0]); //menghapus array 0, untuk validasi
        if (empty($request->tags))
            return redirect('quotes/create')->withInput($request->input())->with('tag_error', 'tag ngak boleh kosong');

        $slug = str_slug($request->title, '-');

        if(Quote::where('slug', $slug)->first() !=null)
            $slug = $slug . '-' .time();

        $quote = Quote::create([
            'title' => $request->title,
            'slug' => $slug,
            'subject' => $request->subject,
            'user_id' => Auth::user()->id
        ]);   

        
        $quote->tags()->attach($request->tags);

        return redirect('quotes')->with('msg', 'Quote berhasil dibuat');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $quote = Quote::with('comments.user')->where('slug', $slug)->first();
        
        if(empty($quote))
            abort(404);
        
        return view('quotes.single', compact('quote'));
    }

    public function random()
    {
        $quote = Quote::inRandomOrder()->first();
        return view('quotes.single', compact('quote'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $quote = Quote::findOrFail($id);
        $tags = Tag::all();
        
        return view('quotes.edit', compact('quote', 'tags'));
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
        $this->validate($request, [
            'title' => 'required|min:3',
            'subject' => 'required|min:5',
        ]);

        $request->tags = array_diff($request->tags, [0]); //menghapus array 0, untuk validasi
        if (empty($request->tags))
            return redirect('quotes/create')->withInput($request->input())->with('tag_error', 'tag ngak boleh kosong');

        $quote = Quote::findOrFail($id);
        if($quote->isOwner()) {
            $quote->update([
                'title' => $request->title,
                'subject' => $request->subject,
            ]);

            $quote->tags()->sync($request->tags);
        }
        else abort(403);
        return redirect('quotes')->with('msg', 'Quote berhasil di-update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $quote = Quote::findOrFail($id);
        if($quote->isOwner())
            $quote->delete();
        else abort(403);

        return redirect('quotes')->with('msg', 'Quote berhasil dihapus');
    }
}

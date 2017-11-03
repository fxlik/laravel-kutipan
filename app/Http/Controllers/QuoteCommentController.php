<?php

namespace App\Http\Controllers;

//use
use Auth;
use App\Models\User;
use App\Models\Quote;
use App\Models\QuoteComment;

use Illuminate\Http\Request;

class QuoteCommentController extends Controller
{
 
    public function store(Request $request, $id)
    {
        // dd('adfdfdfd');

        $this->validate($request, [
            'subject' => 'required|min:5',
        ]);

        $quote = Quote::findOrFail($id);

        $quotes = QuoteComment::create([
            'subject' => $request->subject,
            'quote_id' => $id,
            'user_id' => Auth::user()->id
        ]);   

        return redirect('/quotes/'.$quote->slug)->with('msg', 'Komentar berhasil dibuat');

    }

    
    public function show($slug)
    {
        $quote = Quote::where('slug', $slug)->first();
        
        if(empty($quote))
            abort(404);
        
        return view('quotes.single', compact('quote'));
    }

    public function random()
    {
        $quote = Quote::inRandomOrder()->first();
        return view('quotes.single', compact('quote'));
    }

    
    public function edit($id)
    {
        $quote = Quote::findOrFail($id);
        
        return view('quotes.edit', compact('quote'));
    }

   
    public function update(Request $request, $id)
    {
        $quote = Quote::findOrFail($id);
        if($quote->isOwner())
            $quote->update([
                'title' => $request->title,
                'subject' => $request->subject,
            ]);
        else abort(403);

        return redirect('quotes')->with('msg', 'Quote berhasil di-update');
    }

    
    public function destroy($id)
    {
        $quote = Quote::findOrFail($id);
        if($quote->isOwner())
            $quote->delete();
        else abort(403);

        return redirect('quotes')->with('msg', 'Quote berhasil dihapus');
    }
}

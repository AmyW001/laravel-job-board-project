<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ListingController extends Controller
{
    public function index()
    {
        // get query parameters /?tag=laravel 
        // request('tag');
        return view('listings.index', [
            'listings' => Listing::latest()
                ->filter(request(['tag', 'search']))
                ->paginate(6)
        ]);
    }

    public function show(Listing $listing)
    {
        return view('listings.show', [
            'listing' => $listing,
        ]);
    }

    public function create(Listing $listing)
    {
        return view('listings.create', [
            'listing' => $listing,
        ]);
    }

    // using dependency injection to get request
    public function store(Request $request)
    {
        $formFields = $request->validate([
            'title' => 'required',
            'company' => ['required', Rule::unique('listings', 'company')],
            'location' => 'required',
            'website' => 'required',
            'email' => ['required', 'email'],
            'tags' => 'required',
            'description' => 'required',
        ]);

        if ($request->hasFile('logo')) {
            $formFields['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $formFields['user_id'] = auth()->id();

        Listing::create($formFields);

        return redirect('/')->with('message', 'Listing created successfully!');
    }

    public function edit(Listing $listing)
    {
        return view('listings.edit', [
            'listing' => $listing,
        ]);
    }

    public function update(Request $request, Listing $listing)
    {
        // make sure logged in user is owner
        if ($listing->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $formFields = $request->validate([
            'title' => 'required',
            'company' => 'required',
            'location' => 'required',
            'website' => 'required',
            'email' => ['required', 'email'],
            'tags' => 'required',
            'description' => 'required',
        ]);

        if ($request->hasFile('logo')) {
            $formFields['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $listing->update($formFields);

        return back()->with('message', 'Listing updated successfully!');
    }

    public function manage()
    {
        // return view('listings.manage', ['listings' => auth()->user()->listings()->get()]);
        return view('listings.manage', ['listings' => Listing::where('user_id', auth()->id())->get()]);
    }

    public function destroy(Listing $listing)
    {
        // make sure logged in user is owner
        if ($listing->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $listing->delete();

        return redirect('/')->with('message', 'Listing deleted successfully!');
    }
}

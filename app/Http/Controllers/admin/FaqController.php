<?php

namespace App\Http\Controllers\admin;

use App\Faq;
use App\FaqCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FaqController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $faqs = Faq::leftjoin('faq_categories','faqs.faq_category_id','=','faq_categories.id')
                    ->select('faqs.*','faq_categories.title as faq_categories_title')
                    ->get();
            return datatables()->of($faqs)
                ->addColumn('action', function ($row) {
                    $html = '<a href="faqs/' . $row->id . '/edit" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Edit </a> ';
                    $html .= '<button data-rowid="' . $row->id . '" class="btn btn-danger btn-xs btn-delete"><i class="fa fa-trash-o"></i> Delete </button>';
                    return $html;
                })->toJson();
        }
         return view('admin.faq.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $faq_categories= FaqCategory::get();
        return view('admin.faq.create',compact('faq_categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         $title1 = str_replace('"',"",$request->title);
        $title = str_replace("'","",$title1);
        $request->validate([
            'title' => 'required',
            'faq_category' => 'required|not_in:0',
            'description' => 'required',
        ]);

        $faq=new Faq();
        $faq->title = $title;
        $faq->faq_category_id = $request->faq_category;
        $faq->description = $request->description;
        $faq->save();

        return redirect()->route('faqs.index')->with('success', 'Faq created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Faq  $faq
     * @return \Illuminate\Http\Response
     */
    public function show(Faq $faq)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Faq  $faq
     * @return \Illuminate\Http\Response
     */
    public function edit(Faq $faq)
    {
         $faq_categories= FaqCategory::get();
        return view('admin.faq.edit', compact('faq','faq_categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Faq  $faq
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Faq $faq)
    {
        $title1 = str_replace('"',"",$request->title);
        $title = str_replace("'","",$title1);
        $request->validate([
            'title' => 'required',
            'description' => 'required',
        ]);

        $faq=Faq::find($faq->id);
        $faq->title = $title;
        $faq->faq_category_id = $request->faq_category;
        $faq->description = $request->description;
        $faq->save();

        return redirect()->route('faqs.index')->with('success', 'Faq updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Faq  $faq
     * @return \Illuminate\Http\Response
     */
    public function destroy(Faq $faq)
    {
        $faq->delete();

        redirect()->route('faqs.index');
        return ['success' => true, 'message' => 'Faq Deleted Successfully'];
    }
}

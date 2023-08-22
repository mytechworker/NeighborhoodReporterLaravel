<?php

namespace App\Http\Controllers\admin;

use App\FaqCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FaqCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $faq_categories = FaqCategory::all();
            return datatables()->of($faq_categories)
                ->addColumn('action', function ($row) {
                    $html = '<a href="faq_categories/' . $row->id . '/edit" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Edit </a> ';
                    $html .= '<button data-rowid="' . $row->id . '" class="btn btn-danger btn-xs btn-delete"><i class="fa fa-trash-o"></i> Delete </button>';
                    return $html;
                })->toJson();
        }
         return view('admin.faq_category.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.faq_category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
        ]);

        $title1 = str_replace('"',"",$request->title);
        $title = str_replace("'","",$title1);
        $faqcategory=new FaqCategory();
        $faqcategory->title = $title;
        $faqcategory->description = $request->description;
        $faqcategory->save();

        return redirect()->route('faq_categories.index')->with('success', 'Faqcategory created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\FaqCategory  $faqCategory
     * @return \Illuminate\Http\Response
     */
    public function show(FaqCategory $faqCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\FaqCategory  $faqCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(FaqCategory $faqCategory)
    {
        return view('admin.faq_category.edit', compact('faqCategory'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\FaqCategory  $faqCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FaqCategory $faqCategory)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
        ]);

        $title1 = str_replace('"',"",$request->title);
        $title = str_replace("'","",$title1);
        $faqcategory=FaqCategory::find($faqCategory->id);
        $faqcategory->title = $title;
        $faqcategory->description = $request->description;
        $faqcategory->save();

        return redirect()->route('faq_categories.index')->with('success', 'Faqcategory updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\FaqCategory  $faqCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(FaqCategory $faqCategory)
    {
        $faqCategory->delete();

        redirect()->route('faq_categories.index');
        return ['success' => true, 'message' => 'Faqcategory Deleted Successfully'];
    }
}

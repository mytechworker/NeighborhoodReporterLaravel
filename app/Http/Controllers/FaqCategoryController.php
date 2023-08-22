<?php

namespace App\Http\Controllers;

use App\Faq;
use App\FaqCategory;
use Illuminate\Http\Request;

class FaqCategoryController extends Controller
{
    public function get_faq_category()
    {
        $faq_categories = FaqCategory::get();
        return view('faq_category',compact('faq_categories'));
    }

    public function faq_listing(Request $request)
    {
        $segment = request()->segment(2);
        preg_match_all('!\d+!', $segment, $matches);
        $faq_category_title = FaqCategory::where('id',$matches[0])->first();
        $faq_categories = FaqCategory::where('id',$matches[0])->get();
        $faqs = Faq::where('faq_category_id',$matches[0])->get();

        return view('faq_listing',compact('faq_categories','faqs','faq_category_title'));
    }

    public function faq_detail(Request $request)
    {
        $getQueryString=\Request::getRequestUri();
        $explde = explode("-",$getQueryString,2);
        $explde1 = str_replace("-"," ",$explde[1]);
        $segment = request()->segment(2);
        preg_match_all('!\d+!', $segment, $matches);

        $faqs = Faq::where('faq_category_id',$matches[0])->first();
        $faqs_lists = Faq::where('title',$explde1)->get();
        $faqs_title = $faqs_lists[0]->title;
        $faqs_list = Faq::where('faq_category_id',$matches[0])->get();
        $faq_category = FaqCategory::where('id',$matches[0])->first();
        return view('faq_detail',compact('faqs','faqs_lists','faqs_list','faq_category','faqs_title'));
    }

    public function search_faq_category(Request $request)
    {
        if($request->ajax()) {
          
            $data = FaqCategory::where('title', 'LIKE', '%'.$request->faq_category.'%')->get();
           
            $output = '';
           
            if (count($data)>0) {
              
                $output = '<ul class="list-group" style="display: block; position: relative; z-index: 1">';
              
                foreach ($data as $row){
                   
                    $output .= '<a name="'.$row->id."-".$row->title.'"><li data-id="'.strtolower(str_replace(" ","-",$row->id."-".$row->title)).'" class="list-group-item faq-category" style="cursor:pointer;">'.$row->title.'</li></a>';
                }
              
                $output .= '</ul>';
            }
            else {
             
                $output .= '<li class="list-group-item">'.'No results'.'</li>';
            }
           
            return $output;
        }
    }

    public function search_faq_listing(Request $request)
    {
        if($request->ajax()) {
            
            $data = Faq::where('faq_category_id','LIKE', '%'.$request->faq_category.'%')->get();
            
           
            $output = '';
           
            if (count($data)>0) {
              
                $output = '<ul class="list-group" style="display: block; position: relative; z-index: 1">';
              
                foreach ($data as $row){
                   
                    $output .= '<a name="'.$row->id."-".$row->title.'"><li data-id="'.strtolower(str_replace(" ","-",$row->faq_category_id."-".$row->title)).'" class="list-group-item faq-category" style="cursor:pointer;">'.$row->title.'</li></a>';
                }
              
                $output .= '</ul>';
            }
            else {
             
                $output .= '<li class="list-group-item">'.'No results'.'</li>';
            }
           
            return $output;
        }
    }
}   

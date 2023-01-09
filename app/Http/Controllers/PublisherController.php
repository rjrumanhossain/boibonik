<?php

namespace App\Http\Controllers;

use App\Models\Publisher;
use Illuminate\Http\Request;
use Illuminate\support\Str;
class PublisherController extends Controller
{
    public function index(Request $request)
    {

        $sort_search =null;
        $publishers = Publisher::orderBy('order_level', 'desc');
        if ($request->has('search')){
            $sort_search = $request->search;
            $publishers = $publishers->where('name', 'like', '%'.$sort_search.'%');
        }



        $publisher = Publisher::paginate(10);
        return view('backend.product.publisher.index',compact('publisher'));
    }

    public function added()
    {
        return view('backend.product.publisher.added');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:50'
        ]);

        $publisher = new Publisher();
        $publisher->name = $request->name;
        $publisher->slug = Str::slug($request->name);;
        if($publisher->save())
        {
            flash(translate('Publisher has been Adeed successfully'))->success();
            return redirect()->route('admin.publisher');
        }else{
            flash(translate('Publisher has been Adeed Unsuccessfully'))->success();
            return redirect()->route('admin.publisher');
        }
    }

    public function edit($id)
    {
        $publisher = Publisher::findOrFail($id);
        return view('backend.product.publisher.edit',compact('publisher'));


    }

        //===================================update section=============

        public function update(Request $request)
        {
           $id = $request->id;
           $publisher = Publisher::findOrFail($id);
           $publisher->name = $request->name;
           $publisher->slug = $request->slug;
           if( $publisher->save())
            {
                flash(translate('publisher has been updated successfully'))->success();
                return redirect()->route('admin.publisher');
            }else{
                flash(translate('publisher has been updated Unsuccessfully'))->success();
                return redirect()->route('admin.publisher');
            }
           
        }




        //delete

        public function destroy($id)
        {
            $publisher = Publisher::findOrFail($id);
            if($publisher->delete()){
                flash(translate('Publisher has been deleted successfully'))->success();
                return redirect()->back();
            }else{
                flash(translate('Publisher has been deleted Unsuccessfully'))->success();
                return redirect()->back();
            }
            
        }
}

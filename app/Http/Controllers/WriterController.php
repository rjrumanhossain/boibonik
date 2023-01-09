<?php

namespace App\Http\Controllers;

use App\Models\Writer;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
class WriterController extends Controller
{
    public function index()
    {
        $writter = Writer::paginate(10);
        return view('backend.product.writer.index',compact('writter'));
    }

    //Added page 


    public function added()
    {
        return view('backend.product.writer.added');
    }

    //store Writter 

    public function store(Request $request)
    {

        $validated = $request->validate([
            'name' => 'required|max:50'
        ]);

        $writter = new Writer();
        $writter->name = $request->name;
        $writter->slug = Str::slug($request->name);
        if($writter->save())
        {
            flash(translate('Writter has been Adeed successfully'))->success();
            return redirect()->route('admin.writer');
        }else{
            flash(translate('Writter has been Adeed Unsuccessfully'))->success();
            return redirect()->route('admin.writer');
        }

    }

    //edit controller 

    public function edit($id)
    {
        $writter = Writer::findOrFail($id);
        return view('backend.product.writer.edit',compact('writter'));


    }

    //===================================update section=============

    public function update(Request $request)
    {
       $id = $request->id;
       $writter = Writer::findOrFail($id);
       $writter->name = $request->name;
       $writter->slug = $request->slug;
       if( $writter->save())
        {
            flash(translate('Writter has been updated successfully'))->success();
            return redirect()->route('admin.writer');
        }else{
            flash(translate('Writter has been updated Unsuccessfully'))->success();
            return redirect()->route('admin.writer');
        }
       
    }


    //delete

    public function destroy($id)
    {
        $writter = Writer::findOrFail($id);
        if($writter->delete()){
            flash(translate('Writer has been deleted successfully'))->success();
            return redirect()->back();
        }else{
            flash(translate('Writer has been deleted Unsuccessfully'))->success();
            return redirect()->back();
        }
        
    }
}

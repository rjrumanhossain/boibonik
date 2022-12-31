<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
   
    public function index()
    {
        $subject = Subject::paginate(10);
        return view('backend.product.subject.index',compact('subject'));
    }

    public function added()
    {
        return view('backend.product.subject.added');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:50',
            'slug' => 'required|unique:subjects|max:255',
        ]);

        $subject = new Subject();
        $subject->name = $request->name;
        $subject->slug = $request->slug;
        if($subject->save())
        {
            flash(translate('Subject has been Adeed successfully'))->success();
            return redirect()->route('admin.subject');
        }else{
            flash(translate('Subject has been Adeed Unsuccessfully'))->success();
            return redirect()->route('admin.subject');
        }
    }

    public function edit($id)
    {
        $subject = Subject::findOrFail($id);
        return view('backend.product.subject.edit',compact('subject'));


    }

    
        //===================================update section=============

        public function update(Request $request)
        {
           $id = $request->id;
           $subject = Subject::findOrFail($id);
           $subject->name = $request->name;
           $subject->slug = $request->slug;
           if( $subject->save())
            {
                flash(translate('Subject has been updated successfully'))->success();
                return redirect()->route('admin.subject');
            }else{
                flash(translate('Subject has been updated Unsuccessfully'))->success();
                return redirect()->route('admin.subject');
            }
           
        }



            //delete

        public function destroy($id)
        {
            $subject = Subject::findOrFail($id);
            if($subject->delete()){
                flash(translate('Subject has been deleted successfully'))->success();
                return redirect()->back();
            }else{
                flash(translate('Subject has been deleted Unsuccessfully'))->success();
                return redirect()->back();
            }
            
        }

}


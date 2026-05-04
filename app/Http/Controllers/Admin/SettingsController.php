<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SchoolClass;
use App\Models\Form;
use App\Models\Position;
use App\Models\TalentSetting; 
use App\Models\Award;

class SettingsController extends Controller
{
    // ================= VIEW =================
    public function index()
    {
        $classes = SchoolClass::all();
        $forms = Form::all();
        $positions = Position::all();

        $settings = TalentSetting::all(); 

        $awardCategories = Award::all();
        
        return view('admin.settings.index', compact(
            'classes',
            'forms',
            'positions',
            'settings',
            'awardCategories'
        ));
    }


    // ================= CLASS =================
    public function storeClass(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:classes,name'
        ]);

        SchoolClass::create([
            'name' => $request->name
        ]);

        return back()->with('success', 'Class added successfully!');
    }

    public function deleteClass($id)
    {
        SchoolClass::findOrFail($id)->delete();

        return back()->with('success', 'Class deleted!');
    }


    // ================= FORM =================
    public function storeForm(Request $request)
    {
        $request->validate([
            'form_number' => 'required|unique:forms,form_number'
        ]);

        Form::create([
            'form_number' => $request->form_number
        ]);

        return back()->with('success', 'Form added successfully!');
    }

    public function deleteForm($id)
    {
        Form::findOrFail($id)->delete();

        return back()->with('success', 'Form deleted!');
    }


    // ================= POSITION =================
    public function storePosition(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:positions,name'
        ]);

        Position::create([
            'name' => $request->name
        ]);

        return back()->with('success', 'Position added successfully!');
    }

    public function deletePosition($id)
    {
        Position::findOrFail($id)->delete();

        return back()->with('success', 'Position deleted!');
    }


    // ================= AWARD POINT SETTINGS =================
    public function updateAward(Request $request, $id)
    {
        $request->validate([
            'points' => 'required|integer|min:0'
        ]);

        TalentSetting::findOrFail($id)->update([
            'points' => $request->points
        ]);

        return back()->with('success', 'Points updated successfully!');
    }

    public function storeAward(Request $request)
    {
        $request->validate([
            'award' => 'required',
            'level' => 'required',
            'points' => 'required|integer|min:0'
        ]);

        TalentSetting::create([
            'award' => $request->award,
            'level' => $request->level,
            'points' => $request->points
        ]);

        return back()->with('success', 'Award added successfully!');
    }

    public function deleteAward($id)
    {
        TalentSetting::findOrFail($id)->delete();

        return back()->with('success', 'Award deleted successfully!');
    }

    public function storeAwardCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:awards,name'
        ]);

        Award::create([
            'name' => strtolower($request->name)
        ]);

        return back()->with('success', 'Award category added!');
    }

    public function deleteAwardCategory($id)
    {
        Award::findOrFail($id)->delete();

        return back()->with('success', 'Deleted!');
    }
}
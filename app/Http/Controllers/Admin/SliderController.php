<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    public function index()
    {
        $sliders = Slider::latest()->get();
        return view('admin.sliders.index', compact('sliders'));
    }

    public function create()
    {
        return view('admin.sliders.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|url|max:1000',
            'title' => 'required|max:255',
            'subtitle' => 'required'
        ]);

        Slider::create([
            'image' => $request->image,
            'title' => $request->title,
            'subtitle' => $request->subtitle
        ]);
        
        return redirect()->route('admin.sliders.index')
            ->with('success', 'Slider created successfully');
    }

    public function edit(Slider $slider)
    {
        return view('admin.sliders.edit', compact('slider'));
    }

    public function update(Request $request, Slider $slider)
    {
        $request->validate([
            'image' => 'required|url|max:1000',
            'title' => 'required|max:255',
            'subtitle' => 'required'
        ]);

        $slider->update([
            'image' => $request->image,
            'title' => $request->title,
            'subtitle' => $request->subtitle
        ]);

        return redirect()->route('admin.sliders.index')
            ->with('success', 'Slider updated successfully');
    }

    public function destroy(Slider $slider)
    {
        $slider->delete();
        return redirect()->route('admin.sliders.index')
            ->with('success', 'Slider deleted successfully');
    }
} 
<?php

namespace App\Http\Controllers;

use App\Models\ImplanAchievement;
use Illuminate\Http\Request;

class ImplanAchievementController extends Controller
{
    public function index()
    {
        $achievements = ImplanAchievement::all();

        return view('implan.achievements.index')->with('achievements', $achievements);
    }

    public function create()
    {
        $mode = 0;

        return view('implan.achievements.create')->with('mode', $mode);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        $achievement = ImplanAchievement::findOrFail($id);

        $mode = 1;

        return view('implan.achievements.show')->with([
            'achievement' => $achievement,
            'mode' => $mode
        ]);
    }

    public function edit($id)
    {
        $achievement = ImplanAchievement::findOrFail($id);

        $mode = 2;

        return view('implan.achievements.edit')->with([
            'achievement' => $achievement,
            'mode' => $mode
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ImplanAchievement $implanAchievement)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $achievement = ImplanAchievement::findOrFail($id);
        $achievement->delete();

        return redirect()->route('implan.achievements.index')->with('success', 'Achievement deleted successfully');
    }
}

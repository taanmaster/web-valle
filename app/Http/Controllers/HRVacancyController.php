<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\HRVacancy;

class HRVacancyController extends Controller
{
    public function index()
    {
        return view('hr.vacancies.index', [
            'vacancies' => HRVacancy::latest()->paginate(10),
        ]);
    }

    public function create()
    {
        $mode = 0;

        return view('hr.vacancies.create', [
            'mode' => $mode,
        ]);
    }

    public function show($id)
    {
        $vacancy = HRVacancy::findOrFail($id);

        $mode = 1;

        return view('hr.vacancies.show', [
            'vacancy' => $vacancy,
            'mode' => $mode,
        ]);
    }

    public function edit($id)
    {
        $vacancy = HRVacancy::findOrFail($id);

        $mode = 2;

        return view('hr.vacancies.edit', [
            'vacancy' => $vacancy,
            'mode' => $mode,
        ]);
    }

    public function destroy($id)
    {
        $vacancy = HRVacancy::findOrFail($id);
        $vacancy->delete();

        return redirect()->route('hr.vacancies.admin.index')->with('success', 'Vacante eliminada correctamente.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\HrTrainingsTable;
use Illuminate\Http\Request;

class HrTrainingsController extends Controller
{
    public function createTrainingHr()
    {
        return view('hr-trainings');
    }

    public function storeTrainingHr(Request $request)
    {
        $input = $request->all();
        HrTrainingsTable::create($input);
        return redirect()->back()->with('message', 'Form Submitted Successfully');
    }
}

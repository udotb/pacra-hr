<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Settings\SettingModel;

class SettingController extends Controller
{
    public function salarySettings(Request $request)
    {
        $this->viewData['meta_title'] = 'Salary Settings';
        $salarySettingData = SettingModel::first();
        //dd($salarySettingData);
        return view('salarySettings', $this->viewData)
        ->with('salarySettingData', $salarySettingData);
    }

    public function addSalarySettings(Request $request)
    {
        $this->viewData['meta_title'] = 'Salary Settings';

        //dd($request->all());

        SettingModel::updateOrCreate([
            //Add unique field combo to match here
            //For example, perhaps you only want one entry per user:
            'id'   => $request->id,
        ],[
            'probMedicalAllowance'     => $request->probMedicalAllowance,
            'medicalAllowance' => $request->medicalAllowance,
            'probPfEmplyee'    => $request->probPfEmplyee,
            'probPfEmployer'   => $request->probPfEmployer,
            'pfEmployee'       => $request->pfEmployee,
            'pfEmployer'       => $request->pfEmployer,
            'probEobiEmployee' => $request->probEobiEmployee,
            'probEobiEmployer' => $request->probEobiEmployer,
            'eobiEmployee'     => $request->eobiEmployee,
            'eobiEmployeer'    => $request->eobiEmployeer
            
        ]);

        return redirect()->route('salarySettings');
    }
}

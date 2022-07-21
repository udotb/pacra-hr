<?php

namespace App\Http\Controllers\Reimbursement;

use App\Helpers\helpers;
use App\Http\Controllers\Controller;
use App\Models\Reimbursement\AllowanceReimbursementTable;
use App\Models\Reimbursement\AllowanceTypesTable;
use App\Models\Reimbursement\MedicalTypeTable;
use App\Models\Reimbursement\TravelTypeTable;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReimbursementController extends Controller
{
    public function reimbursementIndex()
    {
        $userId = helpers::get_orignal_id(Auth::id());

        $reimbursements = AllowanceReimbursementTable::select('allowance_reimbursement.*', 'og_users.display_name', 'pacra_employee_grade.name', 'og_companies.name as clientName', 'medical_type.type as MedType', 'travel_type.type as TravelType')
            ->leftjoin('og_users', 'og_users.id', 'allowance_reimbursement.user_id')
            ->leftjoin('pacra_employee_grade', 'pacra_employee_grade.id', 'allowance_reimbursement.user_grade')
            ->leftjoin('og_companies', 'og_companies.id', 'allowance_reimbursement.client')
            ->leftjoin('travel_type', 'travel_type.id', 'allowance_reimbursement.travel_type')
            ->leftjoin('medical_type', 'medical_type.id', 'allowance_reimbursement.medical_type')
            ->where('user_id', $userId)
            ->get();

        $fromDate = Carbon::parse($reimbursements[0]->from_date ?? '');
        $toDate = Carbon::parse($reimbursements[0]->to_date ?? '');
        $numOfDays = $fromDate->diffInDays($toDate) + 1;
        $totalAmount = AllowanceReimbursementTable::where('user_id', $userId)->where('paid_status', 0)->sum('amount');
        $spam = array('type', '"', ':', '{', '}', '[', ']', ';');

        foreach ($reimbursements as $reimbursement) {
            $reimbursement->type = AllowanceTypesTable::select('allowance_types.type')->whereIn('id', explode(',', $reimbursement->type))->get();

//            if ($reimbursement->user_grade == 4 || $reimbursement->user_grade == 3) {
//                if (($reimbursement->medical_type == 1 && $reimbursement->amount > 150000) || ($reimbursement->medical_type == 2 && $reimbursement->amount > 75000) || ($reimbursement->medical_type == 3 && $reimbursement->amount > 300000)) {
//                    $redAmountHospitalCare = 'HospitalCareRed';
//                    $redAmountMaternity = 'MaternityRed';
//                    $redAmountMajorCare = 'MajorCareRed';
//                } else {
//                    $redAmountHospitalCare = $reimbursement->amount;
//                    $redAmountMaternity = $reimbursement->amount;
//                    $redAmountMajorCare = $reimbursement->amount;
//                }
//            } else {
//                $redAmountHospitalCare = $reimbursement->amount;
//                $redAmountMaternity = $reimbursement->amount;
//                $redAmountMajorCare = $reimbursement->amount;
//            }
        }
        return view('reimbursement', compact('reimbursements', 'numOfDays', 'totalAmount', 'spam', 'userId'));
    }

    public function reimbursementApproval()
    {
        $userId = helpers::get_orignal_id(Auth::id());

        $reimbursements = AllowanceReimbursementTable::select('allowance_reimbursement.*', 'og_users.display_name', 'pacra_employee_grade.name', 'og_companies.name as clientName')
            ->leftjoin('og_users', 'og_users.id', 'allowance_reimbursement.user_id')
            ->leftjoin('pacra_employee_grade', 'pacra_employee_grade.id', 'allowance_reimbursement.user_grade')
            ->leftjoin('og_companies', 'og_companies.id', 'allowance_reimbursement.client')
            ->where('og_users.am_id', $userId)
            ->where('allowance_reimbursement.status', 'Entered')
            ->get();

        $fromDate = Carbon::parse($reimbursements[0]->from_date ?? '');
        $toDate = Carbon::parse($reimbursements[0]->to_date ?? '');
        $numOfDays = $fromDate->diffInDays($toDate) + 1;
        $totalAmount = AllowanceReimbursementTable::where('user_id', $userId)->where('paid_status', 0)->sum('amount');

        foreach ($reimbursements as $reimbursement) {
            $reimbursement->type = AllowanceTypesTable::select('allowance_types.type')->whereIn('id', explode(',', $reimbursement->type))->get();
        }

        $reimbursementsFinance = AllowanceReimbursementTable::select('allowance_reimbursement.*', 'og_users.display_name', 'pacra_employee_grade.name', 'og_companies.name as clientName')
            ->leftjoin('og_users', 'og_users.id', 'allowance_reimbursement.user_id')
            ->leftjoin('pacra_employee_grade', 'pacra_employee_grade.id', 'allowance_reimbursement.user_grade')
            ->leftjoin('og_companies', 'og_companies.id', 'allowance_reimbursement.client')
            ->where('allowance_reimbursement.status', 'Recommended')
            ->orwhere('allowance_reimbursement.status', 'Approved')
            ->get();

        $fromDate = Carbon::parse($reimbursementsFinance[0]->from_date ?? '');
        $toDate = Carbon::parse($reimbursementsFinance[0]->to_date ?? '');
        $numOfDays = $fromDate->diffInDays($toDate) + 1;
        $totalAmount = AllowanceReimbursementTable::where('user_id', $userId)->where('paid_status', 0)->sum('amount');

        foreach ($reimbursementsFinance as $reimbursement) {
            $reimbursement->type = AllowanceTypesTable::select('allowance_types.type')->whereIn('id', explode(',', $reimbursement->type))->get();
        }
        $spam = array('type', '"', ':', '{', '}', '[', ']', ';');

        return view('reimbursement-approval', compact('reimbursements', 'numOfDays', 'totalAmount', 'spam', 'userId', 'reimbursementsFinance'));
    }

    public function storeReimbursementApproval(Request $request)
    {
        $userId = helpers::get_orignal_id(Auth::id());
        $teamleademail = helpers::get_teamlead_email($request->user_id);
        $teamleadname = helpers::get_teamlead_name($request->user_id);
        $username = helpers::get_userName($request->user_id);
        $usermail = helpers::get_userEmail($request->user_id);
        $financeEmail = 'aamir.hussain@pacra.com';
        $clientName = $request->client_name;
        $status = $request->status;
        $portalLink = '<a href="https://209.97.168.200/hr/public/reimbursement">HRMS Reimbursement</a>';
        $portalLinkApproval = '<a href="https://209.97.168.200/hr/public/reimbursement-approval">HRMS Reimbursement Approval</a>';
        if ($request->decline_reason) {
            $decline = $request->decline_reason;
        } else {
            $decline = '';
        }
        if ($request->status == 'Recommended') {
            AllowanceReimbursementTable::updateOrCreate([
                'id' => $request->record_id,
            ],
                [
                    'status' => $request->status,
                ]);
//            Mail::send([], [], function ($message) use ($request, $usermail, $username, $clientName, $portalLink) {
//                $message->to($usermail)
//                    ->subject($clientName . ' Reimbursement Recommended')
//                    ->setBody('<h3>Dear ' . $username . '</h3>
//                        <br>Your Reimbursement request application has been Recommended by your TL. <br>
//                         <br>You can follow-up on that from your HRMS via given link below.<br>
//                        <br>Thank you.<br>
//                        <h3>URL:</h3>' . $portalLink, 'text/html');
//                $message->from('webmaster@pacra.com', 'Webmaster PACRA');
//            });
//            Mail::send([], [], function ($message) use ($request, $financeEmail, $username, $clientName, $portalLinkApproval, $teamleadname) {
//                $message->to($financeEmail)
//                    ->subject($username . ' Reimbursement Recommended')
//                    ->setBody('<h3>Dear Finance Dept,</h3>
//                        <br>'Team Lead Recommended Reimbursement request application of ' . $username . '. Please Approve it. <br>
//                        <br>Thank you.<br>
//                        <h3>URL:</h3>' . $portalLinkApproval, 'text/html');
//                $message->from('webmaster@pacra.com', 'Webmaster PACRA');
//            });
        } elseif ($request->status == 'Approved') {
            AllowanceReimbursementTable::updateOrCreate([
                'id' => $request->record_id,
            ],
                [
                    'status' => $request->status,
                    'paid_status' => '1'
                ]);
//            Mail::send([], [], function ($message) use ($request, $usermail, $username, $clientName, $portalLink, $teamleademail) {
//                $message->to($usermail)
//                    ->cc($teamleademail)
//                    ->subject($clientName . ' Reimbursement Approved')
//                    ->setBody('<h3>Dear ' . $username . '</h3>
//                        <br>Your Reimbursement request application has been Approved by PACRA Accounts Department. <br>
//                         <br>Please get your payment from the relevant department.<br>
//                        <br>Thank you.<br>
//                        <h3>URL:</h3>' . $portalLink, 'text/html');
//                $message->from('webmaster@pacra.com', 'Webmaster PACRA');
//            });
        } else {
            AllowanceReimbursementTable::updateOrCreate([
                'id' => $request->record_id,
            ],
                [
                    'status' => $request->status,
                    'decline_reason' => $decline,
                ]);
//            Mail::send([], [], function ($message) use ($request, $usermail, $username, $clientName, $portalLink, $teamleademail, $status) {
//                $message->to($usermail)
//                    ->cc($teamleademail)
//                    ->subject($clientName . ' Reimbursement Declined')
//                    ->setBody('<h3>Dear ' . $username . '</h3>
//                        <br>Your Reimbursement request application has been ' . $status . ' . <br>
//                         <br>Please see your application to know about the reason.<br>
//                        <br>Thank you.<br>
//                        <h3>URL:</h3>' . $portalLink, 'text/html');
//                $message->from('webmaster@pacra.com', 'Webmaster PACRA');
//            });
        }

        return back();
    }

    public function reimbursementForm()
    {
        $userId = helpers::get_orignal_id(Auth::id());
        $allowanceType = AllowanceTypesTable::all();
        $travelType = TravelTypeTable::all();
        $medicalType = MedicalTypeTable::all();
        $getGrade = helpers::get_grade(Auth::id());


        $clientName = DB::table('pacra_client_opinion_relations as PR')->select('pacra_clients.id', 'pacra_clients.title as clientName', 'og_companies.id', 'pacra_portfolio.company_id')
            ->leftJoin('pacra_clients', 'pacra_clients.id', '=', 'PR.client_id')
            ->leftJoin('og_companies', 'og_companies.id', '=', 'PR.opinion_id')
            ->leftJoin('pacra_portfolio', 'pacra_portfolio.company_id', '=', 'og_companies.id')
            ->where('pacra_portfolio.user_id', $userId)
            ->orWhere('pacra_portfolio.manager_id', $userId)
            ->orWhere('pacra_portfolio.lead_rc_id', $userId)
            ->whereNotNull('pacra_clients.title')
            ->orderBy('pacra_clients.title', 'ASC')
            ->get();

        return view('reimbursement-form', compact('allowanceType', 'clientName', 'userId', 'travelType', 'getGrade', 'medicalType'));
    }


    public function storeReimbursementForm(Request $request)
    {
        $userId = helpers::get_orignal_id(Auth::id());
        $teamleademail = helpers::get_teamlead_email($userId);
        $username = helpers::get_userName($userId);
        $usermail = helpers::get_userEmail($userId);
        $grade = helpers::get_grade(Auth::id());
        $clientName = $request->client_name;
        $portalLink = '<a href="https://209.97.168.200/hr/public/reimbursement">HRMS Reimbursement</a>';

        if ($request->hasFile('attachment')) {
            $path = 'reimbursement-attachment';
            $fileNameToStore = time() . '.' . $request->attachment->extension();
            $attachment = $request->attachment->move(public_path($path), $fileNameToStore);
            $attachment = $path . '/' . $fileNameToStore;
        } else {
            $attachment = '';
        }

        if ($request->actual) {
            $actualAmount = $request->actual;
        } else {
            $actualAmount = '';
        }

        if ($request->otherClient) {
            $otherClient = $request->otherClient;
        } else {
            $otherClient = '';
        }

        $fromDate = Carbon::parse($request->from_date);
        $toDate = Carbon::parse($request->to_date);
        $numOfDays = $fromDate->diffInDays($toDate) + 1;
        $numOfKms = $request->kms;

        /* medical calculations start */
        $haystack = $request->type;
        if ((in_array(1, $haystack))) {
            $medicalAmount = $request->otherAmount;
            switch ($grade == 7 || $grade == 6 || $grade == 5) {
                case $request->medicalType == 1 && $request->otherAmount <= 100000:
                    $hospCare = $request->otherAmount;
                    break;
                case $request->medicalType == 2 && $request->otherAmount <= 50000:
                    $maternity = $request->otherAmount;
                    break;
                case $request->medicalType == 3 && $request->otherAmount <= 200000:
                    $majorMed = $request->otherAmount;
                    break;
                default:

                    return redirect()->route('reimbursement')->withInput()->with('danger', 'Your Reimbursement Amount is exceeding your Allowance. Please see your allowance limit from "View Allowances". Thanks!');
            }

            switch ($grade == 4 || $grade == 3) {
                case $request->medicalType == 1 && $request->otherAmount <= 150000:
                    $hospCare = $request->otherAmount;
                    break;
                case $request->medicalType == 2 && $request->otherAmount <= 75000:
                    $maternity = $request->otherAmount;
                    break;
                case $request->medicalType == 3 && $request->otherAmount <= 300000:
                    $majorMed = $request->otherAmount;
                    break;
                default:

                    return redirect()->route('reimbursement-form')->withInput()->with('danger', 'Your Reimbursement Amount is exceeding your Allowance. Please see your allowance limit from "View Allowances". Thanks!');
            }

            switch ($grade == 2 || $grade == 1) {
                case $request->medicalType == 1 && $request->otherAmount <= 250000:
                    $hospCare = $request->otherAmount;
                    break;
                case $request->medicalType == 2 && $request->otherAmount <= 100000:
                    $maternity = $request->otherAmount;
                    break;
                case $request->medicalType == 3 && $request->otherAmount <= 500000:
                    $majorMed = $request->otherAmount;
                    break;
                default:

                    return redirect()->route('reimbursement')->withInput()->with('danger', 'Your Reimbursement Amount is exceeding your Allowance. Please see your allowance limit from "View Allowances". Thanks!');
            }
        } else {
            $medicalAmount = 0;
//            $hospCare = 0;
//            $maternity = 0;
//            $majorMed = 0;
        }

        /* medical calculations end */

        /* meal and accommodation calculations start */

        $haystack = $request->type;
        if ((in_array(2, $haystack)) || (in_array(3, $haystack)) || (in_array(4, $haystack))) {
            switch ((in_array(2, $haystack)) || (in_array(3, $haystack)) || (in_array(4, $haystack))) {
                case $grade == 7 || $grade == 6 || $grade == 5:
                    $mealAmount = 1500 * $numOfDays;
                    $accAmount = 3000 * $numOfDays;
                    if ($request->travelType == 4) {
                        $travelAmount = 10 * $numOfKms;
                    } else {
                        $travelAmount = $request->travelAmount;
                    }
                    break;
                case $grade == 4 || $grade == 3:
                    $mealAmount = 2000 * $numOfDays;
                    $accAmount = 5000 * $numOfDays;
                    if ($request->travelType == 4) {
                        $travelAmount = 12 * $numOfKms;
                    } else {
                        $travelAmount = $request->travelAmount;
                    }
                    break;
                case $grade == 2:
                    $mealAmount = 2500 * $numOfDays;
                    $accAmount = 7500 * $numOfDays;
                    if ($request->travelType == 4) {
                        $travelAmount = 14 * $numOfKms;
                    } else {
                        $travelAmount = $request->travelAmount;
                    }
                    break;
                case $grade == 1:
                    $mealAmount = 5000 * $numOfDays;
                    $accAmount = 15000 * $numOfDays;
                    if ($request->travelType == 4) {
                        $travelAmount = 16 * $numOfKms;
                    } else {
                        $travelAmount = $request->travelAmount;
                    }
                    break;
                default:
                    $mealAmount = 0;
                    $accAmount = 0;
                    $travelAmount = 0;
            }
        } else {
            $mealAmount = 0;
            $accAmount = 0;
            $travelAmount = 0;
        }

        /* meal and accommodation calculations end */

        /* other reiumbrsement calculation start */

        $haystack = $request->type;
        if ((in_array(5, $haystack))) {
            $otherAmount = $request->otherAmount;
        } else {
            $otherAmount = 0;
        }
        /* other reiumbrsement calculation end */

        $amount = $travelAmount + $mealAmount + $accAmount + $otherAmount + $medicalAmount;
        $input = $request->all();
        $array = $input['type'];
        $input['type'] = implode(',', $array);

        AllowanceReimbursementTable::updateOrCreate([
            'id' => $request->record_id,
        ],
            ['user_id' => $userId,
                'user_grade' => $grade,
                'dated' => Carbon::now()->format('d-M-y'),
                'from_date' => $request->from_date,
                'to_date' => $request->to_date,
                'type' => $input['type'],
                'travel_type' => $request->travelType,
                'medical_type' => $request->medicalType,
                'description' => $request->description,
                'client' => $request->client ?? 'N/A',
                'attachment' => $attachment,
                'status' => $request->submit,
                'actual' => $actualAmount,
                'amount' => $amount ?? '',
                'paid_status' => '0',
                'other_client' => $otherClient ?? ''
            ]);

//        Mail::send([], [], function ($message) use ($request, $usermail, $username, $clientName, $portalLink, $teamleademail) {
//            $message->to($usermail)
//                ->cc($teamleademail)
//                ->subject($clientName . ' Reimbursement Application Entered')
//                ->setBody('<h3>Dear ' . $username . '</h3>
//                        <br>Your Reimbursement request application has been Entered Successfully. <br>
//                         <br>You can follow-up on that from your HRMS via given link below.<br>
//                        <br>Thank you.<br>
//                        <h3>URL:</h3>' . $portalLink, 'text/html');
//            $message->from('webmaster@pacra.com', 'Webmaster PACRA');
//        });

        return redirect()->route('reimbursement')->withInput()->with('success', 'Added Successfully');
    }

    public function editReimbursementForm($id)
    {
        $userId = helpers::get_orignal_id(Auth::id());
        $allowanceType = AllowanceTypesTable::all();
        $travelType = TravelTypeTable::all();
        $medicalType = MedicalTypeTable::all();
        $getGrade = helpers::get_grade(Auth::id());

        $reimbursementData = AllowanceReimbursementTable::select('allowance_reimbursement.*', 'og_users.display_name', 'pacra_employee_grade.name', 'og_companies.name as clientName')
            ->leftjoin('og_users', 'og_users.id', 'allowance_reimbursement.user_id')
            ->leftjoin('pacra_employee_grade', 'pacra_employee_grade.id', 'allowance_reimbursement.user_grade')
            ->leftjoin('og_companies', 'og_companies.id', 'allowance_reimbursement.client')
            ->where('allowance_reimbursement.id', $id)
            ->get();

        foreach ($reimbursementData as $reimbursement) {
            $reimbursement->type = AllowanceTypesTable::select('allowance_types.type')->whereIn('id', explode(',', $reimbursement->type))->get();
        }
        $spam = array('type', '"', ':', '{', '}', '[', ']', ';');

        $clientName = DB::table('pacra_client_opinion_relations as PR')->select('pacra_clients.id', 'pacra_clients.title as clientName', 'og_companies.id', 'pacra_portfolio.company_id')
            ->leftJoin('pacra_clients', 'pacra_clients.id', '=', 'PR.client_id')
            ->leftJoin('og_companies', 'og_companies.id', '=', 'PR.opinion_id')
            ->leftJoin('pacra_portfolio', 'pacra_portfolio.company_id', '=', 'og_companies.id')
            ->where('pacra_portfolio.user_id', $userId)
            ->orWhere('pacra_portfolio.manager_id', $userId)
            ->orWhere('pacra_portfolio.lead_rc_id', $userId)
            ->whereNotNull('pacra_clients.title')
            ->orderBy('pacra_clients.title', 'ASC')
            ->get();

        return view('reimbursement-form-edit', compact('allowanceType', 'clientName', 'userId', 'travelType', 'getGrade', 'medicalType', 'reimbursementData', 'spam'));
    }

}

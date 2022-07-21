<?php

namespace App\Http\Controllers;

use App\Models\Employees\UsersModel;
use App\Models\UploadHappiness;
use Application\Services\LogFactory;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function getEmpImage(Request $request)
    {

        $getEmpImage = UsersModel::select('email', 'avatar_file')->whereIn('email', $request->email)->get();
        $path = 'http://209.97.168.200/hr/public/users/';
        $data = [];
        foreach ($getEmpImage as $key => $value) {
            if (isset($value->avatar_file)) {
                $img = file_get_contents($path . urlencode($value->avatar_file));
                $value->avatar_file = base64_encode($img);
                $data[$key] = $value;
            }
        }
        return response()->json(['status' => true, 'path' => $path, 'data' => $data]);
    }

    public function getUsersForWebsite()
    {
        $getCEO = UsersModel::where('profile_on_web', 1)->where('designation_id', 1)->with('designation')->get();
        $getUnitHead = UsersModel::where('profile_on_web', 1)->where('designation_id', 2)->get();
        return response()->json(['status' => true, 'data' => ['ceo' => $getCEO, 'unitHeads' => $getUnitHead]]);
    }

    public function getUsers()
    {
        $getUsers = UsersModel::select('email', 'display_name')->where('is_active', 1)->get();
        return response()->json(['status' => true, 'date' => ['users' => $getUsers]]);
    }

    public function getUsersForLogin(Request $request)
    {
        $email = $request->email;
        $password = $request->password;
        $decodedPassword = urldecode($password);

//        $isValid = UsersModel::where('is_active', 1)->where('email', $email)->where('password', $password)->first();
//        if ($isValid) {
//            return response()->json(['status' => true, 'user' => ['email' => $isValid->email, 'name' => $isValid->display_name]]);
//        } else {
//            return response()->json(['status' => false, 'user' => []]);
//        }

        $user = UsersModel::where('is_active', 1)->where('email', $email)->first();
        $decodedPasswordFromWizpac = urldecode($user->password);
        $emailFromWizpac = $user->email;

        if ($decodedPassword == $decodedPasswordFromWizpac && $email == $emailFromWizpac) {
            return response()->json(['status' => true, 'user' => ['email' => $user->email, 'name' => $user->display_name]]);
        } else {
            return response()->json(['status' => false, 'user' => []]);
        }
    }

    public function mohsinPostApi(Request $request)
    {
        try {
            $uploadHappinessTable = new UploadHappiness();
            $uploadHappinessTable->img = $request->img;
            $uploadHappinessTable->date = date('Y-m-d', strtotime($request->date));
            $uploadHappinessTable->description = $request->description;
            $uploadHappinessTable->save();
            return json_encode(['status' => true, 'message' => 'Data saved successfully']);
        } catch (\Exception $exception) {
            $log = new LogFactory($exception->getMessage());
            return json_encode(['status' => false, 'message' => 'Server error. Please try again later']);
        }
    }
}

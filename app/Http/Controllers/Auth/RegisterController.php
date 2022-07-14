<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\Users\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use DB;

use App\Models\Users\Subjects;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    public function registerView()
    {
        $subjects = Subjects::all();
        return view('auth.register.register', compact('subjects'));
    }

    public function registerPost(Request $request)
    {
        DB::beginTransaction();
        try{
            $old_year = $request->old_year;
            $old_month = $request->old_month;
            $old_day = $request->old_day;
            $data = $old_year . '-' . $old_month . '-' . $old_day;
            $birth_day = date('Y-m-d', strtotime($data));
               //subjectについて、roleが生徒の時のみしか選べない為、講師の場合はその値をsubjectとして利用する
               if(isset($request->subject)){
                $subjects = intval($request->subject);
            }else{
                $subjects = intval($request->role);
            }

            //--------------------------------------------------------------------------------------------------------------------
                //Add Validation
                $rules = [
                    'over_name' => 'required|string|max:10',
                    'under_name' => 'required|string|max:10',
                    'over_name_kana' => 'required|string|max:30|regex:/\A[ァ-ヴー]+\z/u',
                    'under_name_kana' => 'required|string|max:30|regex:/\A[ァ-ヴー]+\z/u',
                    'mail_address' => 'required|string|email|max:100|unique:users,mail_address',
                    'sex' => 'required|regex:/[1-3]/',
                    'birth_day' => 'required|date|after:"2000-01-01"|before:"now"',
                    'role' => 'required|regex:/[1-4]/',
                    'password' =>'required|string|regex:/\A([a-zA-Z0-9]{8,30})+\z/u|confirmed',
                ];

                $register_request = $request->all();
                $register_request += array('birth_day'=>$birth_day);

                $validator = validator::make($register_request,$rules);
                //フォーム入力に問題がある場合
                if($validator->fails()){
                    // DD($request,$subjects,$register_request);
                    return redirect('/register')
                    ->withErrors($validator)
                    ->withInput();
                }

            //--------------------------------------------------------------------------------------------------------------------

            $user_get = User::create([
                'over_name' => $request->over_name,
                'under_name' => $request->under_name,
                'over_name_kana' => $request->over_name_kana,
                'under_name_kana' => $request->under_name_kana,
                'mail_address' => $request->mail_address,
                'sex' => $request->sex,
                'birth_day' => $birth_day,
                'role' => $request->role,
                'password' => bcrypt($request->password)
            ]);
            // DD($request,$subjects,$register_request);
            $user = User::findOrFail($user_get->id);
            // DD($request,$subjects,$register_request,$user_get->id,$user);
            //　下記リレーション未改修
            // $user->subjects()->attach($subjects);
            DB::commit();
            return view('auth.login.login');
        }catch(\Exception $e){
            DB::rollback();
            return redirect()->route('loginView');
        }
    }
}
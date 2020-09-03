<?php

/*
 *
 *  if  function return boolean  then name starts with is....
 *  if  function return value  then name starts with get...
 *
 */

use App\CandidateCompany;
use App\CandidateCompanyCity;
use App\CandidateDesignation;
use App\CandidateInterviewType;
use App\CandidateStatus;
use App\City;
use App\Country;
use App\Industry;
use App\State;
use App\Town;
use App\User;
use App\UserCompany;
use App\UserCompanyCity;
use App\UserRight;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;


if (!function_exists('getHomePageRedirection')) {
    function getHomePageRedirection($page)
    {
        $response = '';

        if (\auth()->check()){
            switch (\auth()->user()->role){
                case 'admin':
                    $response = '<a href="'.route('admin.dashboard') .'" class="'.($page=='landing'?'btn btn-primary':'text-black').' text-uppercase">Dashboard</a>';
                    break;

                case 'recruiter':
                    $response = '<a href="'.route('recruiter.dashboard') .'" class="'.($page=='landing'?'btn btn-primary':'text-black').' text-uppercase">Dashboard</a>';
                    break;
            }
        } else
        {
            switch ($page){
                case 'landing':
                    $response = '<a href="'.route('login').'" class="text-uppercase">Sign in</a><a href="'.route('register').'" class="btn btn-primary text-uppercase  ml-3"> Sign up</a>';
                    break;

                case 'header':
                    $response = '';
                    break;
            }
        }

        return $response;
    }
}

if (!function_exists('getRecruiterProfile')) {
    function getRecruiterProfile($id, $name)
    {
        $link = route('portfolio.recruiter', $id);
        return '<a href="' . $link . '" target="_blank">' . $name . '</a>';
    }
}

if (!function_exists('getProfileImage')) {
    function getProfileImage($imageName)
    {
        $profileImage = ($imageName) ? ("storage/images/user/profile/" . $imageName) : "images/default_profile_image.png";
        $img = '<img src="' . asset($profileImage) . '" class="profile-image shadow-on-hover border mr-3" alt="">';
        return $img;
    }
}

if (!function_exists('getSourcingCountryImage')) {
    function getSourcingCountryImage($id)
    {
        $country = Country::find($id);
        $country_flag = 'default-country-icon.png';

        if (!empty($country)){
            $country_name = str_replace(' ','-', strtolower($country->name));
            if (file_exists(base_path('images/flags/'.$country_name.'.png'))){
                $country_flag = $country_name.'.png';
            }elseif(file_exists(public_path('images/flags/'.$country_name.'.png'))){
                $country_flag = $country_name.'.png';
            }elseif(file_exists(resource_path('images/flags/'.$country_name.'.png'))){
                $country_flag = $country_name.'.png';
            }
        }
        return $country_flag;
    }
}

if (!function_exists('getSourcingCountryFlagForAPI')) {
    function getSourcingCountryFlagForAPI($id)
    {
        $flag_path = asset('images/flags/'.getSourcingCountryImage($id));
        return $sourcing_flag  = '<img src="'.$flag_path.'" class="sourcing-flag">';
    }
}

if (!function_exists('getMonth')) {
    function getMonth()
    {
        $arr = [
            '1' => 'January',
            '2' => 'February',
            '3' => 'March',
            '4' => 'April',
            '5' => 'May',
            '6' => 'June',
            '7' => 'July',
            '8' => 'August',
            '9' => 'September',
            '10' => 'October',
            '11' => 'November',
            '12' => 'December',
        ];

        return $arr;
    }
}

if (!function_exists('getStatusColor')) {
    function getCandidateStatusColor($identifier)
    {
        $color = null;
        switch ($identifier) {
                case "4":
                $color = 'status-select-color';
                break;
                case "5":
                $color = 'status-joined-color';
                break;
                case "15":
                $color = 'status-terminated-color';
                break;
        }

        return $color;
    }
}


if (!function_exists('getYear')) {
    function getYear()
    {
        $arr = [
            '2019' => '2019',
            '2020' => '2020',
            '2021' => '2021',
            '2022' => '2022',
            '2023' => '2023',
            '2024' => '2024',
            '2025' => '2025',
            '2026' => '2026',
            '2027' => '2027',
            '2028' => '2028',
            '2029' => '2029',
            '2030' => '2030',
            '2031' => '2031',
        ];

        return $arr;
    }
}

if (!function_exists('isDateInRange')) {
    function isDateInRange($startDate, $endDate, $userDate)
    {
        $startT = strtotime($startDate);
        $endT = strtotime($endDate);
        $userT = strtotime($userDate);
        return (($userT >= $startT) && ($userT <= $endT)) ? true : false;
    }
}


if (!function_exists('getSelectOptions')) {
    function getSelectOptions($arr, $selected = NULL, $default = NULL)
    {
        $options = array();
        if (is_array($arr)) {
            if ($default != '') {
                array_push($options, '<option  value="">' . ucwords($default) . '</options>');
            }
            foreach ($arr as $key => $value) {
                if ($selected == $key) {
                    array_push($options, '<option value="' . $key . '" selected>' . ucwords($value) . '</options>');
                } else {
                    array_push($options, '<option value="' . $key . '" >' . ucwords($value) . '</options>');
                }
            }
            return implode('', $options);
        }
    }
}


if (!function_exists('getRights')) {
    function getRights($user_id)
    {
        $rights = UserRight::select('right')->where('user_id', $user_id)->get();
        return $rights->toArray();
    }
}


if (!function_exists('getCandidateLineupStatus')) {
    function getCandidateLineupStatus()
    {
        $arr = null;
        $array = CandidateStatus::select('*')->where('user_role','recruiter')->where('tag_by_name','lineup')->get()->toArray();
        foreach ($array as $ele) {
            $arr[$ele['id']] = ucwords($ele['name']);
        }
        $arr['mark-as-select']='Mark as Select';
        return $arr;
    }
}

if (!function_exists('getCandidateSelectStatus')) {
    function getCandidateSelectStatus()
    {
        $arr = null;
        $array = CandidateStatus::select('*')->where('user_role','recruiter')->where('tag_by_name','select')->get()->toArray();
        foreach ($array as $ele) {
            $arr[$ele['id']] = ucwords($ele['name']);
        }
        $arr['mark-as-lineup']='Revert Back To Lineup';
        return $arr;
    }
}


if (!function_exists('getCandidateStatus')) {
    function getCandidateStatus()
    {
        $arr = null;
        $array = CandidateStatus::select('*')->get()->toArray();
        foreach ($array as $ele) {
            $arr[$ele['id']] = ucwords($ele['name']);
        }
        return $arr;
    }
}

if (!function_exists('getCandidateInterviewType')) {
    function getCandidateInterviewType()
    {
        $arr = null;
        $array = CandidateInterviewType::select('*')->get()->toArray();
        foreach ($array as $ele) {
            $arr[$ele['id']] = ucwords($ele['name']);
        }
        return $arr;
    }
}


if (!function_exists('getCandidateDesignation')) {
    function getCandidateDesignation($sourcingId=null)
    {
        $arr = null;
        $user = Auth::user();
        $userId = $user->id;
        $sourcing = null;
        if($sourcingId){
            $sourcing = $sourcingId;
        }else{
            $sourcing = $user->sourcing;
        }
        $array = CandidateDesignation::select('*')->where('sourcing_id',$sourcing)->get()->toArray();
        foreach ($array as $ele) {
            $arr[$ele['id']] = ucwords($ele['name']);
        }
        return $arr;

    }
}


if (!function_exists('getCandidateIndustry')) {
    function getCandidateIndustry()
    {
        $arr = null;
        $array = Industry::select('*')->get()->toArray();
        foreach ($array as $ele) {
            $arr[$ele['id']] = ucwords($ele['name']);
        }
        return $arr;

    }
}

if (!function_exists(('getAllUserCompaniesCitys'))) {
    function getAllUserCompaniesCitys()
    {
        $arr = null;
        $array = UserCompanyCity::select('*')->get()->toArray();
        foreach ($array as $ele) {
            $arr[$ele['id']] = ucwords($ele['name']);
        }
        return $arr;
}
}




if (!function_exists('getUserCompany')) {
    function getUserCompanyCitiesByCompany($company)
    {
        $user = Auth::user();
        $id = $user->id;
        $country = $user->country_id;
        $arr = null;
        $array = UserCompany::select(
            'user_companies.id as id',
            'user_companies.name as company_name',
            'user_companies.city_id as city_id',
            'user_companies.country_id as country_id',
            'user_company_cities.name as city_name'

        )
        ->join('user_company_cities as user_company_cities','user_company_cities.id', '=', 'user_companies.city_id')
        ->where('user_companies.name',$company)
            ->where('user_companies.country_id',$country)
            ->get()
            ->toArray();
        foreach ($array as $ele) {
            $arr[$ele['city_id']] = ucwords($ele['city_name']);
        }

            return $arr;

    }
}


if (!function_exists('getUserCompany')) {
    function getUserCompany()
    {
        $user = Auth::user();
        $id = $user->id;
        $country = $user->country_id;
        $arr = null;
        $array = UserCompany::select('*')
            ->where('country_id',$country)
            ->groupBy('name')
            ->get()
            ->toArray();
        foreach ($array as $ele) {
            $arr[$ele['name']] = ucwords($ele['name']);
        }
        return $arr;

    }
}

if (!function_exists('getCandidateCompany')) {
    function getCandidateCompanyCitiesByCompany($company, $sourcingId = null)
    {
        $user = Auth::user();
        $id = $user->id;
        if ($sourcingId) {
            $sourcing = $sourcingId;
        } else {
            $sourcing = $user->sourcing;
        }
        $arr = null;
        $array = CandidateCompany::select(
            'candidate_companies.id as id',
            'candidate_companies.name as company_name',
            'candidate_companies.sourcing_id as sourcing_id',
            'candidate_company_cities.name as city_name',
            'candidate_companies.city_id as city_id'
        )
            ->join('candidate_company_cities as candidate_company_cities','candidate_company_cities.id', '=', 'candidate_companies.city_id')
            ->where('candidate_companies.name',$company)
            ->where('candidate_companies.sourcing_id',$sourcing)
            ->get()
            ->toArray();
        foreach ($array as $ele) {
            $arr[$ele['city_id']] = ucwords($ele['city_name']);
        }

        return $arr;

    }
}

if (!function_exists('getCandidateCompany')) {
    function getCandidateCompanyCitiesByCompanyAdmin($company)
    {
        $user = Auth::user();
        $id = $user->id;

        $arr = null;
        $array = CandidateCompany::select(
            'candidate_companies.id as id',
            'candidate_companies.name as company_name',
            'candidate_companies.sourcing_id as sourcing_id',
            'candidate_company_cities.name as city_name',
            'candidate_companies.city_id as city_id'
        )
            ->join('candidate_company_cities as candidate_company_cities','candidate_company_cities.id', '=', 'candidate_companies.city_id')
            ->where('candidate_companies.name',$company)

            ->get()
            ->toArray();
        foreach ($array as $ele) {
            $arr[$ele['city_id']] = ucwords($ele['city_name']);
        }

        return $arr;

    }
}

if (!function_exists('getCandidateCompany')) {
    function getCandidateCompany($sourcingId=null)
    {
        $user = Auth::user();
        $id = $user->id;
        if($sourcingId){
            $sourcing = $sourcingId;
        }else{
            $sourcing = $user->sourcing;
        }
        $arr = null;
        $array = CandidateCompany::select('*')
            ->where('sourcing_id',$sourcing)
            ->groupBy('name')
            ->get()
            ->toArray();
        foreach ($array as $ele) {
            $arr[$ele['name']] = ucwords($ele['name']);
        }
        return $arr;

    }
}


if (!function_exists('getCandidateCompanyCity')) {
    function getCandidateCompanyCity()
    {
        $user = Auth::user();
        $id = $user->id;
        $sourcing = $user->sourcing;
        $arr = null;
        $array = CandidateCompanyCity::select('*')
            ->where('sourcing_id',$sourcing)
            ->get()
            ->toArray();
        foreach ($array as $ele) {
            $arr[$ele['id']] = ucwords($ele['name']);
        }
        return $arr;

    }
}


if (!function_exists('getRoles')) {
    function getRoles()
    {
        return $roles = [
            1 => 'candidate',
            2 => 'recruiter',
            3 => 'team_leader',
            4 => 'branch_manager',
            5 => 'manager',
            6 => 'accountant',
            7 => 'admin',
            8 => 'hr',
            9 => 'client'
        ];
    }
}


if (!function_exists('getRolesByRole')) {
    function getRolesByRole()
    {
        return $roles = [
            'candidate' => 'candidate',
            'recruiter' => 'recruiter',
            'team_leader' => 'team_leader',
            'branch_manager' => 'branch_manager',
            'manager' => 'manager',
            'accountant' => 'accountant',
            'admin' => 'admin',
            'hr' => 'hr',
            'client' => 'client'
        ];
    }
}

if (!function_exists('getUserStatus')) {
    function getUserStatus()
    {
        return $roles = [
            'active' => 'active',
            'inactive' => 'inactive',
            'block' => 'block',
        ];
    }
}



if (!function_exists('getGenders')){
    function getGenders()
    {
        return $roles = ['female' => 'female', 'male' => 'male'];
    }
}

if (!function_exists('date_dMY')){
    function date_dMY($date){
        $date = Carbon::createFromFormat('Y-m-d', $date);
        $now = Carbon::now();

        $date_year = $date->year;
        $now_year = $now->year;

        if ($date_year == $now_year) {
            return $date->format('d M');
        } else {
            return $date->format('d M Y');
        }
    }
}

if (!function_exists('setRedirectTo')) {
    function setRedirectTo($user)
    {
        $role = $user['role'];
        $sourcing = $user['sourcing'];
        switch ($role) {
            case 'admin':
                $redirectPath = route('admin.dashboard');
                break;

            case 'accountant':
                $redirectPath = route('accountant.dashboard');
                break;

            case 'hr':
                $redirectPath = route('hr.dashboard');
                break;
            case 'recruiter':
                if ($sourcing == null) {
                    $redirectPath = route('dashboard');
                }else {
                    $redirectPath = route('recruiter.dashboard');
                }
                break;
        }
        return $redirectPath;
    }
}

if (!function_exists('sendMail')){
    function sendMail($data)
    {
        $page = $data['page'];
        Mail::send($page, $data, function ($m) use ($data) {
        $m->from('india.myglit@gmail.com', 'MyGlit');
        $m->to($data['email'])->subject('Interview Details');
    });

        if (Mail::failures()) {
            return false;
        }
        return true;
    }
}

if (!function_exists('candidateCompanies')) {
    function candidateCompanies()
    {

        return CandidateCompany::join('countries', 'countries.id', '=', 'candidate_companies.sourcing_id')
            ->join('candidate_company_cities', 'candidate_company_cities.id', '=', 'candidate_companies.city_id')
            ->select('candidate_companies.*',
                'candidate_companies.name as company_name',
                'countries.id as country_id',
                'countries.name as country_name',
                'candidate_company_cities.id as city_id',
                'candidate_company_cities.name as city_name'
            );
    }
}

if (!function_exists('getCountryById')) {
    function getCountryById($id)
    {
        return Country::find($id);
    }
}

if (!function_exists('getStateById')) {
    function getStateById($id)
    {
        return State::join('countries', 'countries.id', '=', 'states.country_id')
            ->select(
                'states.id as state_id',
                'states.name as state_name',
                'states.country_id as country_id'
            )
            ->where('states.id', $id)
            ->get()->first();
    }
}

if (!function_exists('getCityById')) {
    function getCityById($id)
    {
        return City::join('states', 'states.id', '=', 'cities.state_id')
            ->select(
                'cities.id as id',
                'cities.name as name',
                'states.id as state_id',
                'states.name as state_name',
                'states.country_id as country_id'
            )
            ->where('cities.id', $id)
            ->get()->first();
    }
}

if (!function_exists('getTownById')) {
    function getTownById($id)
    {
        return Town::join('cities', 'cities.id', '=', 'towns.city_id')
            ->select(
                'towns.id as id',
                'towns.name as name',
                'cities.id as state_id',
                'cities.name as state_name',
                'cities.state_id as state_id'
            )
            ->where('cities.id', $id)
            ->get()->first();
    }
}

if (!function_exists('getCandidateCompanyById')) {
    function getCandidateCompanyById($id)
    {
        return CandidateCompany::find($id);
    }
}

if (!function_exists('getUserCompanyById')) {
    function getUserCompanyById($id)
    {
        return CandidateCompany::find($id);
    }
}

if (!function_exists('getUserById')) {
    function getUserById($id)
    {
        return User::find($id);
    }
}

if (!function_exists('getCandidateCityById')) {
    function getCandidateCityById($id)
    {
        return CandidateCompanyCity::find($id);
    }
}

if (!function_exists('getIndustryById')) {
    function getIndustryById($id)
    {
        return Industry::find($id);
    }
}

if (!function_exists('getemprec')) {
    function getemprec()
    {
        $data = [
            '1' =>  'Employee',
            '2' => 'Recruiter',
        ];
        return $data;
    }
}

<?php


use App\Helpers\Robots\SpatieManager;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

if(!function_exists('getMonths')){

    function getMonths($index = null)
    {
        $months = [
            1 => 'Janvier',
            2 => 'Février',
            3 => 'Mars',
            4 => 'Avril',
            5 => 'Mai',
            6 => 'Juin',
            7 => 'Juillet',
            8 => 'Août',
            9 => 'Septembre',
            10 => 'Octobre',
            11 => 'Novembre',
            12 => 'Décembre',
        ];

        return $index ? $months[$index] : $months;
    }

}

if(!function_exists('generateRandomNumber')){

    function generateRandomNumber($length = 10)
    {
        $min = (int)str_pad("1", $length, "0");

        $max = (int)str_pad("", $length, "9");

        return random_int($min, $max);
    }

}
if(!function_exists('__isAdminsOrMasterOrHasRoles')){

    function __isAdminsOrMasterOrHasRoles($user_id = null, ...$roles)
    {
        if(!auth_user()){

            if($user_id) $user = findUser($user_id);

            else return false;

            if(($user->isAdminsOrMaster() || $user->hasRole($roles)))

                return true;

            else
                return false;
        }
        else{

            if($user_id) $user = findUser($user_id);

            else $user = findUser(auth_user_id());

            if(($user->isAdminsOrMaster() || $user->hasRole($roles)))

                return true;

            else
                return false;
        }
    }

}
if(!function_exists('getCurrentMonth')){

    function getCurrentMonth()
    {
        $index = date('n');

        return getMonths($index);
    }

}

if(!function_exists('__isConnectedToInternet')){

    function __isConnectedToInternet()
    {
        try {

           return @fsockopen("www.google.com", 80) !== false;

        } catch (\Exception $e) {

            return false;
        }
    }

}

if(!function_exists('__translateRoleName')){

    function __translateRoleName($role_name)
    {
        return SpatieManager::translateRoleName($role_name);
    }

}

if(!function_exists('__translatePermissionName')){

    function __translatePermissionName($permission_name)
    {
        return SpatieManager::translatePermissionName($permission_name);
    }

}



if(!function_exists('__greatingMessager')){

    function __greatingMessager($name)
    {
        $hour = date('G');
        
        if($hour >= 0 && $hour <= 12){

            $greating = "Bonjour ";
        }
        else{

            $greating = "Bonsoir ";
        }

        return $name  ? $greating . ' ' . $name : $greating;
    }

}
if(!function_exists('__arrayAllTruesValues')){

    function __arrayAllTruesValues($data)
    {
        $is_okay = true;

        foreach ($data as $d) {

            if($d == false){

                $is_okay = false;

            }
        }

        return $is_okay;
    }

}
if(!function_exists('is_image')){

    function is_image($extension)
    {
        $extension = str_replace('.', '', $extension);
        
        if (in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
            
            return true;
        }
        
        return false;
    }

}
if(!function_exists('numberZeroFormattor')){

    function numberZeroFormattor($number, $string = false)
    {
        if(is_array($number)) $number = count($number);

        if($string && $number == 0) return "Aucune donnée"; 
        
        return $number >= 10 ? $number : '0' . $number;
    }

}

if(!function_exists('__zero')){

    function __zero($number, $string = false)
    {
        if(is_array($number)) $number = count($number);

        if($string && $number == 0) return "Aucune donnée"; 
        
        return $number >= 10 ? $number : '0' . $number;
    }

}

if(!function_exists('zero')){

    function zero($number, $string = false)
    {
        if(is_array($number)) $number = count($number);

        if($string && $number == 0) return "Aucune donnée"; 
        
        return $number >= 10 ? $number : '0' . $number;
    }

}

if(!function_exists('__formatNumber3')){

    function __formatNumber3(int $number)
    {
        return $nombre_formate = number_format($number, 0, '', ' ');
    }

}

if(!function_exists('substringer')){

    function substringer($string, $length = 8)
    {

        if(strlen($string) <= $length) return $string;

        else

            return Str::substr($string, 0, $length) . " ...";
    }

}

if(!function_exists('string_cutter')){

    function string_cutter($string, $length = 8)
    {

        if(strlen($string) <= $length) return $string;

        else

            return Str::substr($string, 0, $length) . " ...";
    }

}

if(!function_exists('cutter')){

    function cutter($string, $length = 8)
    {

        if(strlen($string) <= $length) return $string;

        else

            return Str::substr($string, 0, $length) . " ...";
    }

}

if(!function_exists('to_flash')){

    function to_flash($name, $message)
    {
        return session()->flash($name, $message);
    }

}

if(!function_exists('flash')){

    function flash($name, $message)
    {
        return session()->flash($name, $message);
    }

}
if(!function_exists('__isMaster')){

    function __isMaster()
    {
        return User::find(auth_user()->id)->isMaster();
    }

}

if(!function_exists('__isAdminAs')){
    function __isAdminAs(mixed $roles = null)
    {
        if(!auth_user()) return false;
        
        $user = User::find(auth_user()->id);

        if($user){
            
            if($user->id == 1) return true;

            if($roles){

                if(is_array($roles)){

                    if(in_array('admin', $roles)) return $user->hasRole(['master', 'admin-1', 'admin-2', 'admin-3', 'admin-4', 'admin-5']);

                    else return $user->hasRole($roles);
                }

                if(!is_array($roles)){

                    if($roles == 'admin') return $user->hasRole(['master', 'admin-1', 'admin-2', 'admin-3', 'admin-4', 'admin-5']);

                    else return $user->hasRole([$roles]);
                }
            }
            return $user->isAdminsOrMaster();
        }

        return false;
    }

}

if(!function_exists('__flash')){

    function __flash($name, $message)
    {
        return session()->flash($name, $message);
    }

}

if(!function_exists('getYears')){

    function getYears($big_to_small = true, $start = null, $end = null)
    {
        $data = [];

        $first = 1990;

        $last = date('Y');

        if($start) $first = $start;

        if($end && $end > $start) $last = $end;

        for ($i = $first; $i <= $last; $i++) { 
            
            $data[$i] = $i;
        } 

        return $big_to_small ? array_reverse($data) : $data;
    }

}

if(!function_exists('__getSimpleNameFormated')){

    function __getSimpleNameFormated($name)
    {
        if ($name) {

            $card = [];

            $card['name'] = $name;

            $card['idc'] = "";

            if(preg_match_all('/ /', $name)){

                $card['idc'] = explode(' ', $name)[1];
            }

            if (preg_match_all('/Sixi/', $name)) { 

                $card['sup'] = "ème";

                $card['root'] = "6";
            }
            elseif (preg_match_all('/Cinqui/', $name)) {

                $card['sup'] = "ème";

                $card['root'] = "5";
            }
            elseif (preg_match_all('/Quatriem/', $name)) {
                $card['sup'] = "ème";
                $card['root'] = "4";
            }
            elseif (preg_match_all('/Troisie/', $name)) {
                $card['sup'] = "ère";
                $card['root'] = "3";
            }
            elseif (preg_match_all('/Seconde/', $name)) {
                $card['sup'] = "nde";
                $card['root'] = "2";
            }
            elseif (preg_match_all('/Premi/', $name)) {

                $card['sup'] = "ère";

                $card['root'] = "1";
            }
            elseif (preg_match_all('/Terminale/', $name)) {

                $card['sup'] = "le";

                $card['root'] = "T";
                
            }
            else{

                return ['sup' => "", 'idc' => "", 'root' => $name];
            }

            $parts = explode(' ', $name);

            if(count($parts) > 1){

                $idcs = explode('-', $parts[1]);

                if(count($idcs) > 1){

                    $idc = $idcs[0] . '-' . $idcs[1];

                    $card['idc'] = $idc;
                }
                else{

                    $idc = $parts[1];

                    $card['idc'] = $idc;
                }
            }

            return $card;

        }
        else{

            return ['sup' => "", 'idc' => "", 'root' => $name];
        }
    }

}

if(!function_exists('getRand')){

    function getRand($min = 2, $max = 234)
    {
        return rand($min, $max);
    }

}

if(!function_exists('getRandom')){

    function getRandom($min = 2, $max = 234)
    {
        return rand($min, $max);
    }

}

if(!function_exists('randomNumber')){

    function randomNumber($min = 2, $max = 234)
    {
        return rand($min, $max);
    }

}

if(!function_exists('randNumber')){

    function randNumber($min = 2, $max = 234)
    {
        return rand($min, $max);
    }

}




if(!function_exists('auth_user')){

    function auth_user()
    {
        return Auth::user();
    }

}

if(!function_exists('auth_user_id')){

    function auth_user_id()
    {
        return Auth::user() ? Auth::user()->id : null;
    }

}

if(!function_exists('auth_user_full_name')){

    function auth_user_full_name($reverse = false)
    {

        return Auth::user() ? findUser(Auth::user()->id)->getFullName($reverse) : null;

    }

}
if(!function_exists('user_profil_photo')){

    function user_profil_photo($user = null)
    {
        if(!$user) 
        
            if(auth_user()) $user = auth_user();

        else return asset("/images/image1.jpg");

        if($user->profil_photo) 

            return url('storage', $user->profil_photo);

        else

            return asset("/images/image1.jpg");

    }

}
if(!function_exists('school_images')){

    function school_images($school = null)
    {
		$defaults = [
			asset("/images/school1.jpg"),
			asset("/images/school2.jpg"),
			asset("/images/school3.jpg"),
			asset("/images/school6.jpg"),
			asset("/images/school17.jpg"),
			asset("/images/school10.jpg"),
			asset("/images/school20.jpg"),
			asset("/images/school13.jpg"),

		];

        if(!$school) return $defaults;
        
        if($school->images) {

			$images = [];

			foreach($school->images as $image_path){

				$images[] = url('storage', $image_path);

			}

			return $images;


		}
		else{

			return $defaults;
		}



            

        


    }

}


if(!function_exists('auth_user_fullName')){

    function auth_user_fullName($reverse = false, $user = null)
    {
        if($user){

            return $user->getFullName($reverse);

        }
        return Auth::user() ? User::find(Auth::user()->id)->getFullName($reverse) : null;
    }

}


if(!function_exists('getUser')){

    function getUser($value, $column = "id")
    {
        return User::where($column, $value)->first();
    }

}

if(!function_exists('__ensureThatAssistantCan')){

    function __ensureThatAssistantCan($assistant_id, $school_id, ?array $roles = [], $redirect_if_unauthorized = false)
    {
        return SpatieManager::ensureThatAssistantCan($assistant_id, $school_id, $roles, $redirect_if_unauthorized);
    }

}

if(!function_exists('__moneyFormat')){

    function __moneyFormat($amount, $currency = "FCFA")
    {
        if($currency) $value = number_format($amount, 0, ',', ' ') . " " . $currency;

        else $value = number_format($amount, 0, ',', ' ');

        return $value;
    }

}

if(!function_exists('findUser')){

    function findUser($id)
    {
        return User::find($id);
    }

}

if(!function_exists('getUsers')){

    function getUsers()
    {
        return User::all();
    }

}

if(!function_exists('blockedsUsers')){

    function blockedsUsers()
    {
        return User::where('blocked', true)->whereNotNull('blocked_at')->get();
    }

}

if(!function_exists('unconfirmedsAccounts')){

    function unconfirmedsAccounts()
    {
        return User::whereNull('email_verified_at')->get();
    }

}

if(!function_exists('confirmedsAccounts')){

    function confirmedsAccounts()
    {
        return User::whereNotNull('email_verified_at')->get();
    }

}


if(!function_exists('__selfUser')){

    function __selfUser($user)
    {
        return $user->id === auth_user()->id;
    }

}

if(!function_exists('__formatDateAgo')){

    function __formatDateAgo($start, $end = null)
    {
        Carbon::setLocale('fr');

        $start = Carbon::parse($start);

        if(!$end) $end = now();

        $end = Carbon::parse($end);
        
        return $start->diffForHumans($end);
    }

}

if(!function_exists('__ago')){

    function __ago($start, $end = null)
    {
        Carbon::setLocale('fr');

        $start = Carbon::parse($start);

        if(!$end) $end = now();

        $end = Carbon::parse($end);
        
        return $start->diffForHumans($end);
    }

}

if(!function_exists('__asAgo')){

    function __asAgo($start, $end = null)
    {
        Carbon::setLocale('fr');

        $start = Carbon::parse($start);

        if(!$end) $end = now();

        $end = Carbon::parse($end);
        
        return $start->diffForHumans($end);
    }

}

if(!function_exists('__agoFormat')){

    function __agoFormat($start, $end = null)
    {
        Carbon::setLocale('fr');

        $start = Carbon::parse($start);

        if(!$end) $end = now();

        $end = Carbon::parse($end);
        
        return $start->diffForHumans($end);
    }

}

if(!function_exists('__formatDate')){

    function __formatDate($date)
    {
        Carbon::setLocale('fr');

        $formatted = ucfirst(Carbon::parse($date)->translatedFormat('d F Y'));
        
        return $formatted;
    }



}
if(!function_exists('__formatDateDiff')){

    function __formatDateDiff($from, $to = null)
    {
        Carbon::setLocale('fr');

        if(!$to) $date1 = Carbon::today();

        else $date1 = Carbon::parse($to);

        $target = Carbon::parse($from);

        $joursRestants = $date1->diffInDays($target, false);

        if($joursRestants >= 1) :

            return floor($date1->diffInDays($target, true)) . " jours restants";

        else :

            return $date1->diff($target)->format('%d jours, %h h, %i min');
            
        endif;
    }

}

if(!function_exists('__formatDateTime')){

    function __formatDateTime($datetime)
    {
        Carbon::setLocale('fr');

        if(!$datetime) $datetime = Carbon::now();

        $formatted = ucwords(Carbon::parse($datetime)->translatedFormat('l j F Y \à H\h i\m s\s'));

        return $formatted;
    }

}

if(!function_exists('__moneyFormat')){

    function __moneyFormat($amount)
    {
        return number_format($amount, 0, ',', ' ');
    }

}

if(!function_exists('deleteFileIfExists')){

    function deleteFileIfExists($path)
    {
        if(File::exists($path)){

            File::delete($path);
        }
    }

}

if(!function_exists('admin_roles')){

    function admin_roles()
    {
        return Role::all();
    }

}



<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\OtpRequest;
use App\Http\Requests\OtpVerifyRequest;
use App\Jobs\SendOtpCodeJob;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Mockery\Exception;

class OtpAuthController extends Controller
{

    public function otp(OtpRequest $request)
    {
        if (!$this->createUser($request->type, $request->value)) {
            throw new Exception();
        }

        //generate random code
        $code = Str::random(6);

        //save code to cache for 2 min
        Cache::put(
            $request->value,
            ['type' => $request->type, 'code' => $code],
            Carbon::now()->addMinutes(2)
        );


        dispatch(
            new SendOtpCodeJob(
                    $request->type,
                    $request->value,
                $code
            )
        );

        return [
            //            'code' => $code //IMPORTANT code dont return in response in product stage
        ];
    }




    /**
     * @param OtpVerifyRequest $request
     * @return array
     */
    public function stepTwo( OtpVerifyRequest $request) : array
    {
        $cache = Cache::get($request->value);
        if (!$cache) {
            throw new Exception('not valid');
        }
        if($cache['code'] != $request->code) {
            throw new Exception('code not valid');
        }

        $user = User::where($this->getRowFromRequest($cache['type']), $request->value)->first();
        if (!$user) {
            throw new Exception('user not found!');
        }


        return [
            'token' => $user->createToken('authToken')->plainTextToken
        ];



    }




    /**
     * @param string $type
     * @param string $value
     * @return mixed
     */
    private function createUser( string $type, string $value) : User
    {
        return User::firstOrCreate([
           $this->getRowFromRequest($type) => $value
        ]);
    }


    /**
     * @param string $type
     * @return string
     */
    private function getRowFromRequest( string $type) : string
    {
        return match($type) {
            'sms' => 'mobile',
            'email' => 'email',
        };
    }


}
<?php

namespace App\Repository\Eloquent\Mutations;

use JWTAuth;
use App\Models\User;
use Illuminate\Support\Str;
use App\Traits\HandleUpload;
use App\Exceptions\CustomException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Repository\Eloquent\BaseRepository;
use App\Repository\Mutations\UserRepositoryInterface;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    use HandleUpload;

    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function create(array $args)
    {
        $input = collect($args)
            ->except(['directive', 'avatar', 'platform', 'ref_code', 'trip_id', 'payable'])
            ->toArray(); 

        if (array_key_exists('avatar', $args) && $args['avatar']) {
            $url = $this->uploadOneFile($args['avatar'], 'avatars');
            $input['avatar'] = $url;
        }
        
        if (array_key_exists('password', $input)) {
            $password = $input['password'];
        } elseif (array_key_exists('phone', $input)) {
            $password = $input['phone'];
            $input['phone_verified_at'] = date('Y-m-d H:i:s');
        } else {
            throw new CustomException(__('lang.password_phone_not_provided'));
        }
        $input['password'] = Hash::make($password);

        $user = $this->model->create($input);

        $token = null;

        Auth::onceUsingId($user->id);
        $token = JWTAuth::fromUser($user);

        return [
            "access_token" => $token,
            "user" => $user
        ];
    }

    public function createMultipleUsers(array $args)
    {

    }

    public function update(array $args)
    {
        $input = collect($args)->except(['id', 'directive', 'avatar'])->toArray();

        try {
            $user = $this->model->findOrFail($args['id']);
        } catch (ModelNotFoundException $e) {
            throw new CustomException(__('lang.user_not_found'));
        }

        if (array_key_exists('avatar', $args) && $args['avatar']) {
            if ($user->avatar) $this->deleteOneFile($user->avatar, 'avatars');
            $url = $this->uploadOneFile($args['avatar'], 'avatars');
            $input['avatar'] = $url;
        }

        if (array_key_exists('phone', $args) && $args['phone'] && is_null($user->phone)) {
            $input['phone_verified_at'] = date('Y-m-d H:i:s');
        }

        $user->update($input);

        return $user;
    }

    public function login(array $args)
    {

        $emailOrPhone = filter_var($args['emailOrPhone'], FILTER_VALIDATE_EMAIL);
        $credentials = [];

        if ($emailOrPhone) {
            $credentials["email"] = $args['emailOrPhone'];
        } else {
            $credentials["phone"] = $args['emailOrPhone'];
        } 

        $credentials["password"] = $args['password'];  

        if (! $token = auth('user')->attempt($credentials)) {
            throw new CustomException(__('lang.invalid_auth_credentials'));
        }

        $user = auth('user')->user();

        $updateData = [];

        if (array_key_exists('device_id', $args) 
            && $args['device_id'] 
            && $user->device_id != $args['device_id']) 
        {
            $updateData['device_id'] = $args['device_id'];
        }

        if ($updateData) $user->update($updateData);

        return [
            'access_token' => $token,
            'user' => $user
        ];
    } 

    public function socialLogin(array $args)
    {
        
    }

    public function phoneVerification(array $args)
    {
        
    }

    public function updatePassword(array $args)
    {
        try {
            $user = $this->model->findOrFail($args['id']);
        } catch (ModelNotFoundException $e) {
            throw new \Exception(__('lang.user_not_found'));
        }

        if (!(Hash::check($args['current_password'], $user->password))) {
            throw new CustomException(
                __('lang.password_missmatch'),
                'customValidation'
            );
        }

        if (strcmp($args['current_password'], $args['new_password']) == 0) {
            throw new CustomException(
                __('lang.type_new_password'),
                'customValidation'
            );
        }

        $user->password = Hash::make($args['new_password']);
        $user->save();

        return [
            'status' => true,
            'message' => __('lang.password_changed')
        ];

    }

    public function destroy(array $args)
    {
        return $this->model->whereIn('id', $args['id'])->delete();
    }

}

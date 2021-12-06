<?php

namespace App\Repository\Eloquent\Mutations;

use App\Models\Driver;
use App\Traits\HandleUpload;
use App\Exceptions\CustomException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Repository\Eloquent\BaseRepository;
use App\Repository\Mutations\DriverRepositoryInterface;

class DriverRepository extends BaseRepository implements DriverRepositoryInterface
{
    use HandleUpload;

    public function __construct(Driver $model)
    {
        parent::__construct($model);
    }


    public function create(array $args)
    {
        $input = collect($args)->except(['directive', 'avatar'])->toArray();
        $input['password'] = Hash::make($input['phone']);
 
        if (array_key_exists('avatar', $args) && $args['avatar']) {
            $url = $this->uploadOneFile($args['avatar'], 'avatars');
            $input['avatar'] = $url;
        }

        $driver = $this->model->create($input);

        return $driver;
    }

    public function update(array $args)
    {
        $input = collect($args)->except(['id', 'directive', 'avatar'])->toArray();

        try {
            $driver = $this->model->findOrFail($args['id']);
        } catch (ModelNotFoundException $e) {
            throw new CustomException(__('lang.driver_not_found'));
        }

        if (array_key_exists('avatar', $args) && $args['avatar']) {
            if ($driver->avatar) $this->deleteOneFile($driver->avatar, 'avatars');
            $url = $this->uploadOneFile($args['avatar'], 'avatars');
            $input['avatar'] = $url;
        }

        $driver->update($input);

        return $driver;
    }

    public function login(array $args)
    {
        $emailOrPhone = filter_var($args['emailOrPhone'], FILTER_VALIDATE_EMAIL);

        if ($emailOrPhone) {
            $credentials["email"] = $args['emailOrPhone'];
        } else {
            $credentials["phone"] = $args['emailOrPhone'];
        } 

        $credentials["password"] = $args['password'];

        if (!$token = auth('driver')->attempt($credentials)) {
            throw new CustomException(__('lang.invalid_auth_credentials'));
        }

        $driver = auth('driver')->user();

        if (array_key_exists('device_id', $args) 
            && $args['device_id'] 
            && $driver->device_id != $args['device_id']) 
        {
            $driver->update(['device_id' => $args['device_id']]);
        }

        return [
            'access_token' => $token,
            'driver' => $driver
        ];
    }

    public function updatePassword(array $args)
    {
        try {
            $driver = $this->model->findOrFail($args['id']);
        } catch (ModelNotFoundException $e) {
            throw new \Exception(__('lang.driver_not_found'));
        }

        if (!(Hash::check($args['current_password'], $driver->password))) {
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

        $driver->password = Hash::make($args['new_password']);
        $driver->save();

        return [
            'status' => true,
            'message' => __('lang.password_changed')
        ];

    }

    public function assignVehicle(array $args)
    {
        
    }

    public function unassignVehicle(array $args)
    {
        
    }

    public function destroy(array $args)
    {
        return $this->model->whereIn('id', $args['id'])->delete();
    }
}

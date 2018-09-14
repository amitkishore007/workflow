<?php 

namespace App\B2c\Repositories\Transformers;

use App\B2c\Repositories\Models\User;
use League\Fractal\TransformerAbstract;
use App\B2c\Repositories\Contracts\UserInterface;

/**
 * The UserTransformer class transform the response for the API
 * @author Amit kishore <amit.kishore@biz2credit.com>
 */
class UserTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     * @author Amit kishore <amit.kishore@biz2credit.com>
     * 
     * @param App\B2c\Repositories\Models\User $User
     * 
     * @return array
     */
    public function transform(User $User)
    {
        return [
            UserInterface::ID => $User->id,
            UserInterface::NAME=>$User->name,
            UserInterface::EMAIL => $User->email,
            UserInterface::PHONE => $User->phone,
            UserInterface::IS_EMAIL_VERIFIED => $User->is_email_verified ? true : false,
            UserInterface::IS_PHONE_VERIFIED => $User->is_phone_verified ? true : false,
            UserInterface::IS_ACTIVE => $User->is_active ? true : false,
            UserInterface::CREATED_AT => (string) $User->created_at,
            UserInterface::UPDATED_AT => (string) $User->updated_at
        ];
    }
}

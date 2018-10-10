<?php 
namespace App\B2c\Repositories\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use App\B2c\Repositories\Exceptions\CustomException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;

/**
 * @author Amit kishore <amit.kishore@biz2credit.com>
 */
class B2cServiceProvider extends ServiceProvider 
{
	public function register()
	{
		$this->app->bind(
			'App\B2c\Repositories\Contracts\ApiInterface', 
			'App\B2c\Repositories\Entities\Api\ApiRepository'
		);
		$this->app->bind(
			'App\B2c\Repositories\Contracts\UserInterface', 
			'App\B2c\Repositories\Entities\User\UserRepository'
		);
		$this->app->bind(
			'App\B2c\Repositories\Contracts\RedisInterface', 
			'App\B2c\Repositories\Entities\Redis\RedisRepository'
		);
		$this->app->bind(
			'App\B2c\Repositories\Contracts\VerificationHashInterface',
			'App\B2c\Repositories\Entities\User\VerificationHashRepository'
		);
		$this->app->bind(
			'App\B2c\Repositories\Contracts\AppProcessInterface',
			'App\B2c\Repositories\Entities\AppProcess\AppProcessRepository'
		);
		$this->app->bind(
			'App\B2c\Repositories\Contracts\ApplicationInterface',
			'App\B2c\Repositories\Entities\Application\ApplicationRepository'
		);
		$this->app->bind(
			'App\B2c\Repositories\Contracts\ApplicationOwnerInterface',
			'App\B2c\Repositories\Entities\Application\ApplicationOwnerRepository'
		);
		$this->app->bind(
			'App\B2c\Repositories\Contracts\ApplicationLoanInterface',
			'App\B2c\Repositories\Entities\Application\ApplicationLoanRepository'
		);
		$this->app->bind(
			'App\B2c\Repositories\Contracts\ApplicationBasicInfoInterface',
			'App\B2c\Repositories\Entities\Application\ApplicationBasicInfoRepository'
		);
		$this->app->bind(
            'App\B2c\Repositories\Contracts\AppTaskInterface',
            'App\B2c\Repositories\Entities\AppProcess\AppTaskRepository'
		);
		$this->app->bind(
            'App\B2c\Repositories\Contracts\AppTaskFieldInterface',
            'App\B2c\Repositories\Entities\AppProcess\AppTaskFieldRepository'
		);
		$this->app->bind(
            'App\B2c\Repositories\Contracts\ErrorsInterface',
            'App\B2c\Repositories\Entities\AppProcess\ErrorsRepository'
		);
		$this->app->bind(
            'App\B2c\Repositories\Contracts\AppWorkflowInterface',
            'App\B2c\Repositories\Entities\workflow\AppWorkflowRepository'
        );



	}
	
	/**
	 * Load validation rule 'emailorphone' to validate request parameters.
	 * @author Nitesh Kaushik <nitesh.kaushik@biz2credit.com>
	 * 
	 * @return boolean
	 */
	public function boot()
	{
	    Validator::extend('emailorphone', function ($attribute, $value, $parameters, $validator) {
	        if (preg_match('/^[0-9]*$/', $value)) {
	            return preg_match('/^[0-9]*$/', $value) && strlen($value) >= 10;
	        }
	        return filter_var($value, FILTER_VALIDATE_EMAIL) !== false;
		});
		
	}
}
<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Fortify;
use App\Http\Controllers\Auth\UserController;
use Laravel\Fortify\Contracts\RegisterResponse;
use App\Http\Requests\LoginRequest;
use Laravel\Fortify\Http\Requests\LoginRequest as FortifyLoginRequest;
use App\Http\Requests\RegisterRequest;


class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Fortify::createUsersUsing(CreateNewUser::class);

        $this->app->singleton(RegisterResponse::class, function()
        {
            return new class implements RegisterResponse {
                public function toResponse($request)
                {
                    return redirect('/mypage/profile'); 
                }
            };
        });

        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
    

        // RateLimiter::for('login', function (Request $request) {
        //     $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())).'|'.$request->ip());

        //     return Limit::perMinute(5)->by($throttleKey);
        // });

        // RateLimiter::for('two-factor', function (Request $request) {
        //     return Limit::perMinute(5)->by($request->session()->get('login.id'));
        // });

        // 自作登録画面
        Fortify::registerView(function () {
            return view('auth.register');
        });
            
        // 自作ログイン画面
        Fortify::loginView(function () {
            return view('auth.login');
        });
            
        RateLimiter::for('login', function (Request $request) {
            $email = (string) $request->email;
        
            return Limit::perMinute(10)->by($email . $request->ip());
        });

         

        $this->app->singleton(RegisterResponse::class, function () {
            return new class implements RegisterResponse {
                public function toResponse($request)
                {
                return redirect('/mypage/profile'); // 会員登録後のリダイレクト先
                }
            };
        });

    $this->app->bind(FortifyLoginRequest::class,  LoginRequest::class);
    }
}

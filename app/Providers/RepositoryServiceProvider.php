<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\App;


class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            \App\Repositories\Interfaces\UserRepositoryInterface::class, 
            \App\Repositories\UserRepository::class
        );
        $this->app->bind(
            \App\Repositories\Interfaces\ProjectRepositoryInterface::class, 
            \App\Repositories\ProjectRepository::class
        );
        $this->app->bind(
            \App\Repositories\Interfaces\SkillRepositoryInterface::class, 
            \App\Repositories\SkillRepository::class
        );
        $this->app->bind(
            \App\Repositories\Interfaces\TalentRepositoryInterface::class, 
            \App\Repositories\TalentRepository::class
        );
        $this->app->bind(
            \App\Repositories\Interfaces\MilesloneRepositoryInterface::class, 
            \App\Repositories\MilesloneRepository::class
        );

        $this->app->bind(
            \App\Repositories\Interfaces\MessageRepositoryInterface::class, 
            \App\Repositories\MessageRepository::class
        );
        $this->app->bind(
            \App\Repositories\Interfaces\ProjectFileRepositoryInterface::class, 
            \App\Repositories\ProjectFileRepository::class
        );
        $this->app->bind(
            \App\Repositories\Interfaces\NotificationRepositoryInterface::class, 
            \App\Repositories\NotificationRepository::class
        );
        $this->app->bind(
            \App\Repositories\Interfaces\CouponRepositoryInterface::class, 
            \App\Repositories\CouponRepository::class
        );
        $this->app->bind(
            \App\Repositories\Interfaces\TalentDocumentRepositoryInterface::class,
            \App\Repositories\TalentDocumentRepository::class
        );
        $this->app->bind(
            \App\Repositories\Interfaces\TestResultRepositoryInterface::class,
            \App\Repositories\TestResultRepository::class
        );
        $this->app->bind(
            \App\Repositories\Interfaces\MangopayAccountRepositoryInterface::class,
            \App\Repositories\MangopayAccountRepository::class
        );

        $this->app->bind(
            \App\Repositories\Interfaces\AppsCountryRepositoryInterface::class,
            \App\Repositories\AppsCountryRepository::class
        );

        $this->app->bind(
            \App\Repositories\Interfaces\SavedUserCardRepositoryInterface::class,
            \App\Repositories\SavedUserCardRepository::class
        );
        $this->app->bind(
            \App\Repositories\Interfaces\TransactionRepositoryInterface::class,
            \App\Repositories\TransactionRepository::class
        );

        $this->app->bind(
            \App\Repositories\Interfaces\ProjectPaymentRepositoryInterface::class,
            \App\Repositories\ProjectPaymentRepository::class
        );
        $this->app->bind(
            \App\Repositories\Interfaces\JobCategoryRepositoryInterface::class,
            \App\Repositories\JobCategoryRepository::class
        );
        $this->app->bind(
            \App\Repositories\Interfaces\MilestoneTimeLogRepositoryInterface::class,
            \App\Repositories\MilestoneTimeLogRepository::class
        );
        
        $this->app->bind(
            \App\Repositories\Interfaces\TimesheetRepositoryInterface::class,
            \App\Repositories\TimesheetRepository::class
        );
        $this->app->bind(
            \App\Repositories\Interfaces\BankAccountRepositoryInterface::class,
            \App\Repositories\BankAccountRepository::class
        );
        App::singleton('notification-manager',function(){return new \App\Helpers\NotificationManager;});
        
        App::singleton('project-manager',function(){return new \App\Helpers\ProjectManager;});
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}

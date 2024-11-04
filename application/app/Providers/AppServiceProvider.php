<?php

namespace App\Providers;

use App\Models\AdminNotification;
use App\Models\Advertiser;
use App\Models\Deposit;
use App\Models\Frontend;
use App\Models\Language;
use App\Models\Ptc;
use App\Models\SupportTicket;
use App\Models\User;
use App\Models\Withdrawal;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        $general = gs();
        $activeTemplate = activeTemplate();
        $viewShare['general'] = $general;
        $viewShare['activeTemplate'] = $activeTemplate;
        $viewShare['activeTemplateTrue'] = activeTemplate(true);
        $viewShare['language'] = Language::all();
        $viewShare['emptyMessage'] = 'No data';
        view()->share($viewShare);


        view()->composer('admin.components.tabs.user', function ($view) {
            $view->with([
                'bannedUsersCount'           => User::banned()->count(),
                'emailUnverifiedUsersCount' => User::emailUnverified()->count(),
                'mobileUnverifiedUsersCount'   => User::mobileUnverified()->count(),
            ]);
        });

        view()->composer('admin.components.tabs.advertiser', function ($view) {
            $view->with([
                'bannedAdvertiserCount'           => Advertiser::banned()->count(),
                'emailUnverifiedAdvertiserCount' => Advertiser::emailUnverified()->count(),
                'mobileUnverifiedAdvertiserCount'   => Advertiser::mobileUnverified()->count()
            ]);
        });
        view()->composer('admin.components.tabs.deposit', function ($view) {
            $view->with([
                'pendingDepositsCount'    => Deposit::pending()->count(),
            ]);
        });
        view()->composer('admin.components.tabs.withdrawal', function ($view) {
            $view->with([
                'pendingWithdrawCount'    => Withdrawal::pending()->where('user_id','!=',0)->count(),
            ]);
        });
        view()->composer('admin.components.tabs.advertiserWithdrawal', function ($view) {
            $view->with([
                'pendingadvertiserWithdrawCount'    => Withdrawal::pending()->where('advertiser_id','!=',0)->count(),
            ]);
        });
        view()->composer('admin.components.tabs.ticket', function ($view) {
            $view->with([
                'pendingTicketCount'         => SupportTicket::where('user_id', '!=', 0)->where('advertiser_id','=',0)->whereIN('status', [0, 2])->count(),
            ]);
        });

        view()->composer('admin.components.tabs.advertiser_ticket', function ($view) {
            $view->with([
                'pendingTicketCount'    =>  SupportTicket::where('advertiser_id', '!=', 0)->where('user_id','=',0)->whereIN('status', [0, 2])->count(),
            ]);
        });

        view()->composer('admin.components.tabs.ptc', function ($view) {
            $view->with([
                'activePtcCount'         => Ptc::where('status',1)->count(),
                'pendingPtcCount'         => Ptc::where('status',0)->count(),
            ]);
        });

        view()->composer('admin.components.sidenav', function ($view) {
            $view->with([
                'bannedUsersCount'           => User::banned()->count(),
                'emailUnverifiedUsersCount' => User::emailUnverified()->count(),
                'mobileUnverifiedUsersCount'   => User::mobileUnverified()->count(),

                'bannedAdvertisersCount'           => Advertiser::banned()->count(),
                'emailUnverifiedAdvertisersCount' => Advertiser::emailUnverified()->count(),
                'mobileUnverifiedAdvertisersCount'   => Advertiser::mobileUnverified()->count(),

                'pendingTicketCount'         => SupportTicket::where('user_id', '!=', 0)->where('advertiser_id','=',0)->whereIN('status', [0, 2])->count(),
                'advertiserpendingTicketCount'  => SupportTicket::where('advertiser_id', '!=', 0)->where('user_id','=',0)->whereIN('status', [0, 2])->count(),
                'pendingDepositsCount'    => Deposit::pending()->count(),
                'pendingWithdrawCount'    => Withdrawal::pending()->where('user_id','!=',0)->count(),
                'pendingadvertiserWithdrawCount'    => Withdrawal::pending()->where('advertiser_id','!=',0)->count(),
            ]);
        });

        view()->composer('admin.components.topnav', function ($view) {
            $view->with([
                'adminNotifications'=>AdminNotification::where('read_status',0)->with('user')->orderBy('id','desc')->take(10)->get(),
                'adminNotificationCount'=>AdminNotification::where('read_status',0)->count(),
            ]);
        });

        view()->composer('includes.seo', function ($view) {
            $seo = Frontend::where('data_keys', 'seo.data')->first();
            $view->with([
                'seo' => $seo ? $seo->data_values : $seo,
            ]);
        });

        if($general->force_ssl){
            \URL::forceScheme('https');
        }


        Paginator::useBootstrapFour();
    }
}

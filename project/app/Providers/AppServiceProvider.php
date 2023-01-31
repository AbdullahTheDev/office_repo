<?php

namespace App\Providers;

use App\Classes\GeniusMailer;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use App\Models\Category;
use App\Models\Partner;
use App\Models\Menu;
use Carbon\Carbon;
use Session;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use App;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        $admin_lang = \Cache::remember('admin_lang', 6*3600, function() { 
                        return DB::table('admin_languages')->where('is_default','=',1)->first();
                    });
        App::setlocale($admin_lang->name);
        // \Cache::flush();
        // dd("done");
        view()->composer('*',function($settings){
            $settings->with('gs', 
                        \Cache::remember('gs', 6*3600, function() { 
                            return \App\Models\Generalsetting::find(1);
                        }));
            $settings->with('main_menu', 
                        \Cache::remember('main_menu', 6*3600, function() { 
                            return Menu::with("category")->get(); 
                        }));
            $settings->with('footers', 
                        \Cache::remember('footers', 6*3600, function() { 
                            return Category::with("subs")->where('footer_link','=',1)->get();
                        }));
            $settings->with('header_menu', 
                        \Cache::remember('header_menu', 6*3600, function() { 
                            return Category::where('header_link','=',1)->get();
                        }));
            $settings->with('seo', 
                        \Cache::remember('seo', 6*3600, function() { 
                            return DB::table('seotools')->find(1);
                        }));
            $settings->with('categories', 
                        \Cache::remember('categories', 6*3600, function() { 
                            return Category::where('status','=',1)->get();
                        }));   
            $settings->with('brands', 
                        \Cache::remember('brands', 6*3600, function() { 
                            return Partner::limit(4)->get();
                        }));   
            if (Session::has('language')) 
            {
                $data = \Cache::remember('langg', 6*3600, function() { 
                            return DB::table('languages')->find(Session::get('language'));
                        });
                $data_results = file_get_contents(public_path().'/assets/languages/'.$data->file);
                $lang = json_decode($data_results);
                $settings->with('langg', $lang);
            }
            else
            {
                $data = \Cache::remember('langg', 6*3600, function() { 
                            return DB::table('languages')->where('is_default','=',1)->first();
                        });
                $data_results = file_get_contents(public_path().'/assets/languages/'.$data->file);
                $lang = json_decode($data_results);
                $settings->with('langg', $lang);
            }  

            if (!Session::has('popup')) 
            {
                $settings->with('visited', 1);
            }
            Session::put('popup' , 1);
             
        });
        
        Paginator::useBootstrap();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

        Collection::macro('paginate', function($perPage, $total = null, $page = null, $pageName = 'page') {
            $page = $page ?: LengthAwarePaginator::resolveCurrentPage($pageName);
            return new LengthAwarePaginator(
                $this->forPage($page, $perPage),
                $total ?: $this->count(),
                $perPage,
                $page,
                [
                    'path' => LengthAwarePaginator::resolveCurrentPath(),
                    'pageName' => $pageName,
                ]
            );
        });

    }
}

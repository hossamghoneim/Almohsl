<?php

namespace App\Http\Controllers\Dashboard;

use App\Rules\NotUrl;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SettingController extends Controller
{
    public function index()
    {
        $this->authorize('view_settings');

        return view('dashboard.settings');
    }

    public function store( Request $request )
    {
        $this->authorize('update_settings');

        $data = $request->validate([
           'website_name_ar'                                  => [ 'required_if:setting_type,general' ,'nullable' , 'string' , 'max:255'  ],
           'website_name_en'                                  => [ 'required_if:setting_type,general' ,'nullable' , 'string' , 'max:255'  ],
           'facebook_url'                                     => [ 'required_if:setting_type,general' ,'url' ,'nullable' , 'string' , 'max:255'  ],
           'twitter_url'                                      => [ 'required_if:setting_type,general' ,'url' ,'nullable' , 'string' , 'max:255'  ],
           'instagram_url'                                    => [ 'required_if:setting_type,general' ,'url' ,'nullable' , 'string' , 'max:255'  ],
           'youtube_url'                                      => [ 'required_if:setting_type,general' ,'url' ,'nullable' , 'string' , 'max:255'  ],
           'snapchat_url'                                     => [ 'required_if:setting_type,general' ,'url' ,'nullable' , 'string' , 'max:255'  ],
           'email'                                            => [ 'required_if:setting_type,general' ,'nullable' , 'string' , 'max:255'  ],
           'phone'                                            => [ 'required_if:setting_type,general' ,'nullable' , 'string' , 'max:255'  ],
           'whatsapp'                                         => [ 'required_if:setting_type,general' ,'nullable' , 'string' , 'max:255'  ],
           'tax'                                              => [ 'required_if:setting_type,general' ,'nullable' , 'string' , 'max:255'  ],
           'maintenance_mode'                                 => [ 'required_if:setting_type,general' ,'nullable' , 'string' , 'max:255'  ],
           'meta_tag_description_ar'                          => [ 'required_if:setting_type,seo'     ,'nullable' , 'string' , 'max:255'  ],
           'meta_tag_description_en'                          => [ 'required_if:setting_type,seo'     ,'nullable' , 'string' , 'max:255'  ],
           'meta_tag_keyword_ar'                              => [ 'required_if:setting_type,seo'     ,'nullable' , 'string' , 'max:255'  ],
           'meta_tag_keyword_en'                              => [ 'required_if:setting_type,seo'     ,'nullable' , 'string' , 'max:255'  ],
           'privacy_policy_ar'                                => [ 'required_if:setting_type,website' ,'nullable' , 'string' ],
           'privacy_policy_en'                                => [ 'required_if:setting_type,website' ,'nullable' , 'string' ],
           'terms_and_conditions_en'                          => [ 'required_if:setting_type,website' ,'nullable' , 'string' ],
           'terms_and_conditions_ar'                          => [ 'required_if:setting_type,website' ,'nullable' , 'string' ],
           'about_us_ar'                                      => [ 'required_if:setting_type,about-website' ,'nullable' , 'string' ],
           'about_us_en'                                      => [ 'required_if:setting_type,about-website' ,'nullable' , 'string' ],
           'footer_text_ar'                                   => [ 'required_if:setting_type,about-website' ,'nullable' , 'string', 'max:255' ],
           'footer_text_en'                                   => [ 'required_if:setting_type,about-website' ,'nullable' , 'string', 'max:255' ],
        ]);


        $this->validateFiles('logo','general',$request,$data);
        $this->validateFiles('favicon','general',$request,$data);

        foreach ( $data as $key => $value )
        {
            settings()->set( $key , $value);
        }

    }

    private function validateFiles($keyName , $sectionName , Request $request , &$data)
    {
        if(! settings()->get($keyName))
        {
            $request->validate([
                $keyName   => [ 'bail' , "required_if:setting_type,$sectionName", 'image', 'mimes:jpg,png,jpeg,gif,svg', 'max:2048',  'nullable' ],
            ]);
        }


        if($request->hasFile($keyName))
        {
            $request->validate([
                $keyName   => [ 'bail' ,'image', 'mimes:jpeg,jpg,png,gif,svg,webp', 'max:2048' ]
            ]);
            $data[$keyName] = uploadImage( $request->file($keyName) , "Settings");
        }

    }

    public function changeThemeMode(Request $request)
    {
        session()->put('theme_mode', $request->mode);
        return redirect()->back();
    }

    public function changeLanguage(Request $request)
    {
        session()->put('locale', $request->lang);
        return redirect()->back();
    }
}

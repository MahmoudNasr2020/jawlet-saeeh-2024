<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Mail\ContactMail;
use App\Models\About;
use App\Models\Partner;
use App\Models\Service;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;
use Snowfire\Beautymail\Beautymail;
use App\Models\Airport;
use Google\Cloud\Translate\V2\TranslateClient;
use Illuminate\Support\Facades\Storage;
use League\Csv\Reader;
use Throwable;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{

    public function index(){
        //return Airport::get();
       // dd(session()->all());
        $sliders = Slider::all();
        $services = Service::limit(6)->get();
        $about = About::first();
        $partners = Partner::limit(6)->get();
        return view('site.pages.home',compact('sliders','about','partners','services'));
    }

    public function about()
    {
        $about = About::first();
        return view('site.pages.about_us',compact('about'));
    }

    public function services()
    {
        $services = Service::get();
        return view('site.pages.services',compact('services'));
    }

    public function contact()
    {
        //$services = Service::get();
        return view('site.pages.contact_us');
    }

    public function partners()
    {
        $partners = Partner::get();
        return view('site.pages.partners',compact('partners'));
    }

    public function contact_us(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'message' => 'required|string',
        ]);

        try
        {
            $data = $request->all();
            /*Mail::to(settings()->email)->send(new ContactMail($data));*/

            $beautymail = app()->make(Beautymail::class);
            $beautymail->send('mail.contactMail',  ['data' => $data], function($message) use($request)
            {
                $message
                    ->from($request->email)
                    ->to(settings()->email)
                    ->subject('Welcome!');
            });

            Alert::success('Success', 'تم الارسال بنجاح');

            return redirect()->back();


        }
        catch (\Exception $e) {

            Alert::error('error', 'حدث خطأ');

            return redirect()->back();
        }

    }


    public function changeLanguage(Request $request, $language)
    {
        // تعيين اللغة للتطبيق
        app()->setLocale($language);

        // إنشاء كوكي يحتوي على اللغة المختارة. الكوكي صالح لمدة 43200 دقيقة (30 يومًا).
        $localeCookie = Cookie::make('locale', $language, 43200);

        // إعادة توجيه المستخدم إلى الصفحة السابقة مع إرسال الكوكي
        return redirect()->back()->withCookie($localeCookie);
    }


   public function delete_account()
    {
        return view('site.pages.delete-account');
    }

    public function confirm_delete_account(Request $request)
    {


        // التحقق من صحة البيانات المدخلة
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // جلب المستخدم من قاعدة البيانات باستخدام البريد الإلكتروني
        $user = User::where('email', $request->email)->first();

        // التحقق من صحة كلمة المرور
        if ($user && Hash::check($request->input('password'), $user->password)) {
            // حذف المستخدم
            $user->delete();

            Alert::success('Success', 'تم حذف الحساب بنجاح');
            // إعادة التوجيه إلى صفحة التأكيد أو الصفحة الرئيسية مع رسالة نجاح
            return redirect('/');
        }

        Alert::error('error', ' حدث خطأ ما تاكد من البيانات المدخلة');
        // إذا كانت البيانات المدخلة غير صحيحة، إعادة التوجيه مع رسالة خطأ
        return back();
    }
  
  
   public function privacy_policy()
    {
        return view('site.pages.privacy_policy');
    }
  
  
  
  

  
  

   /* public function importAndTranslateAirports()
    {
        $csv = Reader::createFromPath(public_path('airports.csv'), 'r');
        $csv->setHeaderOffset(0);

        //return $csv;
        $translate = new TranslateClient(['key' => 'AIzaSyD3fxCk4AZI4k0Sqekb-4Mv000Ok5PngjY']);

        foreach ($csv->getRecords() as $record) {
            $translatedName = $this->translateAirportName($record['airport'], $translate);

            Airport::create([
                'name_en' => $record['airport'],
                'name_ar' => $translatedName,
                'country_code' => $record['country_code'],
                'region' => $record['region_name'],
                'latitude' => $record['latitude'],
                'longitude' => $record['longitude'],
            ]);
        }
    }*/


   /* public function importAndTranslateAirports()
    {
        $csv = Reader::createFromPath(public_path('airports.csv'), 'r');
        $csv->setHeaderOffset(0);
        $translate = new TranslateClient(['key' => 'AIzaSyD3fxCk4AZI4k0Sqekb-4Mv000Ok5PngjY']);

        $records = collect($csv->getRecords());

        $records->chunk(500)->each(function ($chunk) use ($translate) {
            foreach ($chunk as $record) {
                $translatedName = $this->translateAirportName($record['airport'], $translate);

                Airport::create([
                    'name_en' => $record['airport'],
                    'name_ar' => $translatedName,
                    'country_code' => $record['country_code'],
                    'region' => $record['region_name'],
                    'latitude' => $record['latitude'],
                    'longitude' => $record['longitude'],
                ]);
            }
        });
    }*/



   /* public function importAndTranslateAirports()
    {
        $csv = Reader::createFromPath(public_path('airports.csv'), 'r');
        $csv->setHeaderOffset(0);
        $translate = new TranslateClient(['key' => 'AIzaSyD3fxCk4AZI4k0Sqekb-4Mv000Ok5PngjY']); // تأكد من استبدال YOUR_API_KEY بمفتاح API الخاص بك

        $records = collect($csv->getRecords());

        $records->chunk(500)->each(function ($chunk) use ($translate) {
            try {
                DB::beginTransaction(); // بدء المعاملة

                foreach ($chunk as $record) {
                    try {
                        $translatedName = $this->translateAirportName($record['airport'], $translate);
                    } catch (Throwable $e) {
                        // يمكنك تسجيل الخطأ أو التعامل معه بطريقة محددة
                        $translatedName = '';
                        error_log('Translation failed: ' . $e->getMessage());
                    }

                    Airport::create([
                        'name_en' => $record['airport'],
                        'name_ar' => $translatedName,
                        'country_code' => $record['country_code'],
                        'region' => $record['region_name'],
                        'latitude' => $record['latitude'],
                        'longitude' => $record['longitude'],
                    ]);
                }

                DB::commit(); // تأكيد التغييرات إذا نجح كل شيء
            } catch (Throwable $e) {
                DB::rollBack(); // التراجع عن التغييرات في حالة الخطأ
                error_log('Failed to import data: ' . $e->getMessage());
            }
        });
    }

    private function translateAirportName($name, $translateClient)
    {
        $result = $translateClient->translate($name, ['target' => 'ar']);
        return $result['text'];
    }*/


   /* public function importAndTranslateAirports()
    {
        $csv = Reader::createFromPath(public_path('airports.csv'), 'r');
        $csv->setHeaderOffset(0);
        $translate = new TranslateClient(['key' => 'AIzaSyD3fxCk4AZI4k0Sqekb-4Mv000Ok5PngjY']); // تأكد من استبدال YOUR_API_KEY بمفتاح API الخاص بك

        $records = collect($csv->getRecords());

        $records->chunk(500)->each(function ($chunk) use ($translate) {
            try {
                DB::beginTransaction(); // بدء المعاملة

                foreach ($chunk as $record) {
                    try {
                        $translatedName = $this->translateAirportName($record['airport'], $translate);
                        $translatedRegion = $this->translateAirportName($record['region_name'], $translate);
                    } catch (Throwable $e) {
                        // يمكنك تسجيل الخطأ أو التعامل معه بطريقة محددة
                        $translatedName = $translatedRegion = '';
                        error_log('Translation failed: ' . $e->getMessage());
                    }

                    Airport::create([
                        'name_en' => $record['airport'],
                        'name_ar' => $translatedName,
                        'country_code' => $record['country_code'],
                        'region_en' => $record['region_name'],
                        'region_ar' => $translatedRegion,
                        'latitude' => $record['latitude'],
                        'longitude' => $record['longitude'],
                        // أضف اسم الدولة باللغتين العربية والإنجليزية
                        'country_name_en' => $record['country_name'], // افترض أن هذا الحقل موجود في ملف CSV
                        'country_name_ar' => $this->translateAirportName($record['country_name'], $translate)
                    ]);
                }

                DB::commit(); // تأكيد التغييرات إذا نجح كل شيء
            } catch (Throwable $e) {
                DB::rollBack(); // التراجع عن التغييرات في حالة الخطأ
                error_log('Failed to import data: ' . $e->getMessage());
            }
        });
    }*/


   /* public function importAndTranslateAirports() {

        $csv = Reader::createFromPath(public_path('airports2.csv'), 'r');
        $csv->setHeaderOffset(0);
        $translate = new TranslateClient(['key' => 'AIzaSyD3fxCk4AZI4k0Sqekb-4Mv000Ok5PngjY']);

        $records = collect($csv->getRecords());

        $records->chunk(500)->each(function ($chunk) use ($translate) {
            try {
                foreach ($chunk as $record) {
                    $countryName = $this->getCountryName($record['country_code']);
                    $translatedCountryName = $this->verifyTranslation($countryName, $translate, 'ar');
                    $translatedAirportName = $this->verifyTranslation($record['airport'], $translate, 'ar');
                    $translatedRegion = $this->verifyTranslation($record['region_name'], $translate, 'ar');

                    Airport::create([
                        'name_en' => $record['airport'],
                        'name_ar' => $translatedAirportName,
                        'country_code' => $record['country_code'],
                        'country_name_en' => $countryName,
                        'country_name_ar' => $translatedCountryName,
                        'region_en' => $record['region_name'],
                        'region_ar' => $translatedRegion,
                        'latitude' => $record['latitude'],
                        'longitude' => $record['longitude'],
                    ]);
                }
            } catch (Throwable $e) {
                error_log('Failed to import data: ' . $e->getMessage());
            }
        });
    }

    private function verifyTranslation($text, $translateClient, $targetLanguage) {
        $result = $translateClient->translate($text, ['target' => $targetLanguage]);
        $translatedText = $result['text'];
        return $translatedText;
    }

    private function getCountryName($countryCode) {
        $response = Http::get("https://restcountries.com/v3.1/alpha/$countryCode");

        if ($response->status() == 200) {
            $data = $response->json();
            $countryData = $data[0];
            $countryName = $countryData['name']['common'];

            return $countryName;
        }

        return '';
    }

    private function translateAirportName($name, $translateClient)
    {
        $result = $translateClient->translate($name, ['target' => 'ar']);
        return $result['text'];
    }

    private function translateCountryName($name, $translateClient)
    {
        $result = $translateClient->translate($name, ['target' => 'ar']);
        return $result['text'];
    }

    public function translateEnglishNamedAirports() {
        //return $airports = Airport::where('name_ar', 'REGEXP', '^[A-Za-z0-9 ]+$')->get();
        $translate = new TranslateClient(['key' => 'AIzaSyD3fxCk4AZI4k0Sqekb-4Mv000Ok5PngjY']);

        $airports = Airport::where('name_ar', 'REGEXP', '^[A-Za-z0-9 ]+$')->get();

        foreach ($airports as $airport) {
            $translatedText = $translate->translate($airport->name_ar, [
                'target' => 'ar'
            ]);

            // تحديث السجل بالترجمة الجديدة
            $airport->name_ar = $translatedText['text'];
            $airport->save();
        }

        return 'yes';
    }*/



}

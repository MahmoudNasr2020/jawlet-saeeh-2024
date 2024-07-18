@extends('site.layout.index')

@section('style')
    <style>
        iframe{
            width:100% !important;
        }
    </style>
@stop
@section('content')

    <!-- subheader -->
    <section id="subheader" style="background-image: url('{{ asset('site/background.png') }}')">
        <div class="container-fluid m-5-hor">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="" style="text-align: {{ app()->getLocale() == 'ar' ? 'right' : 'left' }}">
                        {{ __('web.privacy') }}
                    </h1>
                    <p style="text-align: {{ app()->getLocale() == 'ar' ? 'right' : 'left' }}">{{ __('web.privacy') }}</p>
                </div>
            </div>
        </div>
    </section>
    <!-- subheader end -->



    <!-- section contact -->
    <section aria-label="contact" class="whitepage" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
        <div class="container-fluid m-5-hor">
            <div class="row">
                <div dir="rtl">
                <h1>سياسة الخصوصية</h1>
                <p>مرحباً بكم في موقع "جولة سائح". نحن ملتزمون بحماية خصوصيتكم وضمان تجربة آمنة على الإنترنت. توضح سياسة الخصوصية هذه كيفية جمعنا واستخدامنا وحمايتنا للمعلومات الشخصية التي تقدمها لنا.</p>
                <h2>جمع المعلومات</h2>
                <p>نقوم بجمع المعلومات الشخصية عندما تقوم بالتسجيل في موقعنا، أو تقديم طلب، أو الاشتراك في النشرة الإخبارية، أو ملء استمارة. قد تشمل المعلومات التي نجمعها اسمك، وعنوان بريدك الإلكتروني، ورقم هاتفك، ومعلومات الدفع.</p>
                <h2>استخدام المعلومات</h2>
                <p>نستخدم المعلومات التي نجمعها للأغراض التالية:</p>
                <ul>
                    <li>لتخصيص تجربتك وتلبية احتياجاتك الفردية.</li>
                    <li>لتحسين موقعنا.</li>
                    <li>لتحسين خدمة العملاء.</li>
                    <li>لمعالجة المعاملات.</li>
                    <li>لإدارة مسابقة أو ترويج أو استبيان أو ميزة أخرى للموقع.</li>
                    <li>لإرسال رسائل بريد إلكتروني دورية.</li>
                </ul>
                <h2>حماية المعلومات</h2>
                <p>نحن نطبق مجموعة متنوعة من الإجراءات الأمنية للحفاظ على سلامة معلوماتك الشخصية. يتم تخزين معلوماتك الحساسة على خوادم آمنة ويتم نقلها عبر تقنية SSL.</p>
                <h2>الكشف عن المعلومات لأطراف خارجية</h2>
                <p>نحن لا نبيع أو نتاجر أو ننقل معلوماتك الشخصية إلى أطراف خارجية دون إشعار مسبق، باستثناء الجهات التي تساعدنا في تشغيل موقعنا أو إدارة أعمالنا أو تقديم الخدمات لك، طالما وافقت تلك الجهات على الحفاظ على سرية هذه المعلومات.</p>
                <h2>ملفات تعريف الارتباط</h2>
                <p>يستخدم موقعنا "ملفات تعريف الارتباط" لتحسين تجربتك على الموقع. يمكنك اختيار إيقاف تشغيل جميع ملفات تعريف الارتباط من خلال إعدادات المتصفح الخاص بك، ولكن قد يؤثر ذلك على عمل بعض الميزات.</p>
                <h2>التغييرات على سياسة الخصوصية</h2>
                <p>نحتفظ بالحق في تعديل سياسة الخصوصية هذه في أي وقت. سيتم نشر أي تغييرات على هذه الصفحة. ننصحك بمراجعة هذه الصفحة بانتظام للاطلاع على آخر التحديثات.</p>
                <h2>الاتصال بنا</h2>
                </div>
                <hr>

                <h1>Privacy Policy</h1>
                <p>Welcome to "Tourist Journey". We are committed to protecting your privacy and ensuring a safe online experience. This Privacy Policy explains how we collect, use, and protect the personal information you provide to us.</p>
                <h2>Information Collection</h2>
                <p>We collect personal information when you register on our site, place an order, subscribe to our newsletter, or fill out a form. The information we collect may include your name, email address, phone number, and payment information.</p>
                <h2>Information Use</h2>
                <p>The information we collect may be used in the following ways:</p>
                <ul>
                    <li>To personalize your experience and respond to your individual needs.</li>
                    <li>To improve our website.</li>
                    <li>To improve customer service.</li>
                    <li>To process transactions.</li>
                    <li>To administer a contest, promotion, survey, or other site feature.</li>
                    <li>To send periodic emails.</li>
                </ul>
                <h2>Information Protection</h2>
                <p>We implement a variety of security measures to maintain the safety of your personal information. Your sensitive information is stored on secure servers and transmitted via SSL technology.</p>
                <h2>Information Disclosure to Third Parties</h2>
                <p>We do not sell, trade, or otherwise transfer your personal information to outside parties without prior notice, except for parties that assist us in operating our website, conducting our business, or servicing you, as long as those parties agree to keep this information confidential.</p>
                <h2>Cookies</h2>
                <p>Our website uses "cookies" to enhance your experience. You can choose to disable all cookies through your browser settings, but some features may not function properly.</p>
                <h2>Changes to the Privacy Policy</h2>
                <p>We reserve the right to modify this Privacy Policy at any time. Any changes will be posted on this page. We encourage you to review this page periodically for the latest updates.</p>
                <h2>Contact Us</h2>
                </body>

            </div>
        </div>
    </section>
    <!-- section contact end -->

@stop

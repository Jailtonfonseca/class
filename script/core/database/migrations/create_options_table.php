<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('options')) {
            Schema::create('options', function (Blueprint $table) {
                $table->bigIncrements('option_id');
                $table->string('option_name', 191)->nullable()->unique('option_name');
                $table->longText('option_value')->nullable();
            });

            $options = array(
                array('option_id' => '1','option_name' => 'site_title','option_value' => 'Quickad Classified Pro'),
                array('option_id' => '2','option_name' => 'meta_keywords','option_value' => 'Quickad Classified Pro'),
                array('option_id' => '3','option_name' => 'meta_description','option_value' => 'Quickad Classified Pro'),
                array('option_id' => '4','option_name' => 'try_demo_link','option_value' => 'http://localhost/quickad/'),
                array('option_id' => '5','option_name' => 'default_user_plan','option_value' => 'free'),
                array('option_id' => '6','option_name' => 'non_active_msg','option_value' => '1'),
                array('option_id' => '7','option_name' => 'non_active_allow','option_value' => '1'),
                array('option_id' => '8','option_name' => 'userlangsel','option_value' => '1'),
                array('option_id' => '9','option_name' => 'disable_landing_page','option_value' => '0'),
                array('option_id' => '10','option_name' => 'enable_user_registration','option_value' => '1'),
                array('option_id' => '11','option_name' => 'enable_force_ssl','option_value' => '0'),
                array('option_id' => '12','option_name' => 'include_language_code','option_value' => '0'),
                array('option_id' => '13','option_name' => 'enable_faqs','option_value' => '1'),
                array('option_id' => '14','option_name' => 'show_membershipplan_home','option_value' => '1'),
                array('option_id' => '15','option_name' => 'show_partner_logo_home','option_value' => '1'),
                array('option_id' => '16','option_name' => 'termcondition_link','option_value' => 'http://localhost/quickad/'),
                array('option_id' => '17','option_name' => 'privacy_link','option_value' => 'http://localhost/quickad/'),
                array('option_id' => '18','option_name' => 'cookie_consent','option_value' => '1'),
                array('option_id' => '19','option_name' => 'cookie_link','option_value' => 'http://localhost/quickad/'),
                array('option_id' => '20','option_name' => 'developer_credit','option_value' => '1'),
                array('option_id' => '21','option_name' => 'quickad_debug','option_value' => '1'),
                array('option_id' => '22','option_name' => 'theme_color','option_value' => '#03bd62'),
                array('option_id' => '23','option_name' => 'contact_address','option_value' => 'test address'),
                array('option_id' => '24','option_name' => 'contact_email','option_value' => 'test@gmail.com'),
                array('option_id' => '25','option_name' => 'contact_phone','option_value' => '+9876543210'),
                array('option_id' => '26','option_name' => 'facebook_link','option_value' => 'https://facebook.com/bylancer.in'),
                array('option_id' => '27','option_name' => 'twitter_link','option_value' => 'https://x.com/bylancer'),
                array('option_id' => '28','option_name' => 'instagram_link','option_value' => 'https://instagram.com/bylancer'),
                array('option_id' => '29','option_name' => 'linkedin_link','option_value' => 'https://linkedin.com/bylancer'),
                array('option_id' => '30','option_name' => 'pinterest_link','option_value' => 'https://pinterest.com/bylancer'),
                array('option_id' => '31','option_name' => 'youtube_link','option_value' => 'https://www.youtube.com/c/Bylancer'),
                array('option_id' => '32','option_name' => 'site_favicon','option_value' => 'favicon.png'),
                array('option_id' => '33','option_name' => 'site_admin_logo','option_value' => 'adminlogo.png'),
                array('option_id' => '34','option_name' => 'site_logo','option_value' => 'classic-theme_logo.png'),
                array('option_id' => '35','option_name' => 'site_logo_footer','option_value' => 'classic-theme_footer_logo.png'),
                array('option_id' => '36','option_name' => 'social_share_image','option_value' => 'social_share.jpg'),
                array('option_id' => '37','option_name' => 'post_without_login','option_value' => '1'),
                array('option_id' => '38','option_name' => 'max_image_upload','option_value' => '4'),
                array('option_id' => '39','option_name' => 'post_auto_approve','option_value' => '0'),
                array('option_id' => '40','option_name' => 'post_premium_listing','option_value' => '1'),
                array('option_id' => '41','option_name' => 'post_watermark','option_value' => '1'),
                array('option_id' => '42','option_name' => 'post_desc_editor','option_value' => '1'),
                array('option_id' => '43','option_name' => 'post_address_mode','option_value' => '1'),
                array('option_id' => '44','option_name' => 'post_tags_mode','option_value' => '1'),
                array('option_id' => '45','option_name' => 'country_type','option_value' => 'multi'),
                array('option_id' => '46','option_name' => 'specific_country','option_value' => 'US'),
                array('option_id' => '47','option_name' => 'lang','option_value' => 'en'),
                array('option_id' => '48','option_name' => 'timezone','option_value' => 'America/Santo_Domingo'),
                array('option_id' => '49','option_name' => 'currency_code','option_value' => 'USD'),
                array('option_id' => '50','option_name' => 'currency_sign','option_value' => '$'),
                array('option_id' => '51','option_name' => 'currency_pos','option_value' => '1'),
                array('option_id' => '52','option_name' => 'admin_email','option_value' => 'test@gmail.com'),
                array('option_id' => '53','option_name' => 'smtp_from_email','option_value' => 'admin@gmail.com'),
                array('option_id' => '54','option_name' => 'smtp_from_name','option_value' => 'Admin'),
                array('option_id' => '55','option_name' => 'smtp_mailer','option_value' => 'log'),
                array('option_id' => '56','option_name' => 'smtp_host','option_value' => NULL),
                array('option_id' => '57','option_name' => 'smtp_port','option_value' => NULL),
                array('option_id' => '58','option_name' => 'smtp_username','option_value' => 'admin'),
                array('option_id' => '59','option_name' => 'smtp_password','option_value' => 'admin'),
                array('option_id' => '60','option_name' => 'smtp_secure','option_value' => 'tls'),
                array('option_id' => '61','option_name' => 'invoice_nr_prefix','option_value' => 'INV-'),
                array('option_id' => '62','option_name' => 'invoice_admin_name','option_value' => 'Employer'),
                array('option_id' => '63','option_name' => 'invoice_admin_email','option_value' => 'test@gmail.com'),
                array('option_id' => '64','option_name' => 'invoice_admin_phone','option_value' => '+989436578'),
                array('option_id' => '65','option_name' => 'invoice_admin_address','option_value' => '123, new york'),
                array('option_id' => '66','option_name' => 'invoice_admin_city','option_value' => 'New york'),
                array('option_id' => '67','option_name' => 'invoice_admin_state','option_value' => 'New york'),
                array('option_id' => '68','option_name' => 'invoice_admin_zipcode','option_value' => '10013'),
                array('option_id' => '69','option_name' => 'invoice_admin_country','option_value' => 'India'),
                array('option_id' => '70','option_name' => 'invoice_admin_tax_type','option_value' => 'Tax ID'),
                array('option_id' => '71','option_name' => 'invoice_admin_tax_id','option_value' => '123'),
                array('option_id' => '72','option_name' => 'facebook_login','option_value' => '1'),
                array('option_id' => '73','option_name' => 'facebook_app_id','option_value' => NULL),
                array('option_id' => '74','option_name' => 'facebook_app_secret','option_value' => NULL),
                array('option_id' => '75','option_name' => 'google_login','option_value' => '1'),
                array('option_id' => '76','option_name' => 'google_app_id','option_value' => NULL),
                array('option_id' => '77','option_name' => 'google_app_secret','option_value' => NULL),
                array('option_id' => '78','option_name' => 'blog_enable','option_value' => '1'),
                array('option_id' => '79','option_name' => 'show_blog_home','option_value' => '1'),
                array('option_id' => '80','option_name' => 'blog_comment_enable','option_value' => '1'),
                array('option_id' => '81','option_name' => 'blog_banner','option_value' => '1'),
                array('option_id' => '82','option_name' => 'blog_page_limit','option_value' => '8'),
                array('option_id' => '83','option_name' => 'blog_comment_approval','option_value' => '1'),
                array('option_id' => '84','option_name' => 'blog_comment_user','option_value' => '1'),
                array('option_id' => '85','option_name' => 'testimonials_enable','option_value' => '1'),
                array('option_id' => '86','option_name' => 'show_testimonials_home','option_value' => '1'),
                array('option_id' => '87','option_name' => 'show_testimonials_blog','option_value' => '1'),
                array('option_id' => '88','option_name' => 'recaptcha_mode','option_value' => '0'),
                array('option_id' => '89','option_name' => 'recaptcha_public_key','option_value' => '6LdKJ34pAAAAAIEiDekYPu6MCszCkAuxp61yErqG'),
                array('option_id' => '90','option_name' => 'recaptcha_private_key','option_value' => '6LdKJ34pAAAAAO3pE5GMYfhZ5Y3M4Rmw7SbkUSae'),
                array('option_id' => '91','option_name' => 'google_analytics','option_value' => '{"status":"0","measurement_id":null}'),
                array('option_id' => '92','option_name' => 'tawk_to','option_value' => '{"status":"0","chat_link":null}'),
                array('option_id' => '93','option_name' => 'map_type','option_value' => 'openstreet'),
                array('option_id' => '94','option_name' => 'openstreet_access_token','option_value' => 'pk.eyJ1IjoiYnlsYW5jZXIiLCJhIjoiY2tleWVibGRoMDlxMzJxb2NkbGUydTAwciJ9.OAQbjAZPSQz5J4_DwzxK9Q'),
                array('option_id' => '95','option_name' => 'gmap_api_key','option_value' => 'AIzaSyD_3PGILCvtrITX2K1-g51y-HgngM24sAo'),
                array('option_id' => '96','option_name' => 'map_color','option_value' => '#ec5f5f'),
                array('option_id' => '97','option_name' => 'home_map_zoom','option_value' => '6'),
                array('option_id' => '98','option_name' => 'home_map_latitude','option_value' => '28.6139391'),
                array('option_id' => '99','option_name' => 'home_map_longitude','option_value' => '77.2090212'),
                array('option_id' => '100','option_name' => 'contact_latitude','option_value' => '40.7344458'),
                array('option_id' => '101','option_name' => 'contact_longitude','option_value' => '-73.86704922'),
                array('option_id' => '102','option_name' => 'location_track_icon','option_value' => '1'),
                array('option_id' => '103','option_name' => 'auto_detect_location','option_value' => 'yes'),
                array('option_id' => '104','option_name' => 'live_location_api','option_value' => 'ip_api'),
                array('option_id' => '105','option_name' => 'external_code','option_value' => NULL),
                array('option_id' => '106','option_name' => 'email_sub_signup_details','option_value' => '{SITE_TITLE} - Thanks for signing up {USER_FULLNAME}!'),
                array('option_id' => '107','option_name' => 'email_message_signup_details','option_value' => '<p>Dear Valued Thanks for creating an account {SITE_TITLE} ,</p>
<p>Your username: {USERNAME}</p>
<p>Have further questions?</p>
<p>You can start chat with live support team. Sincerely,</p>
<p>{SITE_TITLE} Team!</p>
<p>{SITE_URL}</p>'),
                array('option_id' => '108','option_name' => 'email_sub_signup_confirm','option_value' => '{SITE_TITLE} - Email Confirmation'),
                array('option_id' => '109','option_name' => 'email_message_signup_confirm','option_value' => '<p>Greetings from {SITE_TITLE} Team!</p>
<p>Thanks for registering with {SITE_TITLE}. We are thrilled to have you as a registered member and hope that you find our service beneficial. Before we get you started please activate your account by clicking on the link below</p>
<p>{CONFIRMATION_LINK}</p>
<p>After your Account activation you can access the website. Once you have your Profile filled in you are ready to go.</p>
<p>{SITE_TITLE} Team!</p>
<p>{SITE_URL}</p>'),
                array('option_id' => '110','option_name' => 'email_sub_forgot_pass','option_value' => '{SITE_TITLE} - Forgot Password'),
                array('option_id' => '111','option_name' => 'email_message_forgot_pass','option_value' => '<p>To reset your password please click the link below<br><br>{FORGET_PASSWORD_LINK}</p>
<p>{SITE_TITLE} Team!</p>
<p>{SITE_URL}</p>'),
                array('option_id' => '112','option_name' => 'email_sub_contact','option_value' => 'Website Email: - {CONTACT_SUBJECT} wants to contact you'),
                array('option_id' => '113','option_name' => 'email_message_contact','option_value' => '<p>{NAME} wants to contact you</p>
<p>{SITE_TITLE}:</p>
<p>Name : {NAME}</p>
<p>Email : {EMAIL}</p>
<p>Message : {MESSAGE}</p>
<p>------------------------------------------</p>
<p>This message has been sent automatically by the {SITE_TITLE} system.</p>'),
                array('option_id' => '114','option_name' => 'email_sub_feedback','option_value' => '{FEEDBACK_SUBJECT}'),
                array('option_id' => '115','option_name' => 'email_message_feedback','option_value' => '<p>{NAME} Send a feedback</p>
<p>{SITE_TITLE}:</p>
<p>Name : {NAME}</p>
<p>Email : {EMAIL}</p>
<p>Phone : {PHONE}</p>
<p>Message : {MESSAGE}</p>
<p>------------------------------------------</p>
<p>This message has been sent automatically by the {SITE_TITLE} system.</p>'),
                array('option_id' => '116','option_name' => 'email_sub_report','option_value' => 'Report Violation - {SITE_TITLE}'),
                array('option_id' => '117','option_name' => 'email_message_report','option_value' => '<p>The Following was sent automatically from</p>
<p>{SITE_TITLE}:</p>
<p>Name : {NAME}</p>
<p>Username : {USERNAME}</p>
<p>Email : {EMAIL}</p>
<p>Violation : {VIOLATION}</p>
<p>Violator : {USERNAME2}</p>
<p>Violation</p>
<p>URL: {URL}</p>
<p>{DETAILS}</p>'),
                array('option_id' => '118','option_name' => 'email_sub_contact_seller','option_value' => '{SITE_TITLE} - {SENDER_NAME} {LANG_WANT-TO-CONTACT}'),
                array('option_id' => '119','option_name' => 'email_message_contact_seller','option_value' => '<p>Your Listing&nbsp; : {ADTITLE}</p>
<p>Sender Name&nbsp; &nbsp; : {SENDER_NAME}<br>Sender Email&nbsp; &nbsp;: &nbsp;{SELLER_EMAIL}<br>Sender Phone&nbsp; &nbsp; : {SENDER_PHONE}<br>Message : {MESSAGE}</p>
<p>------------------------------------------</p>
<p>This message has been sent automatically by the {SITE_TITLE} system.</p>'),
                array('option_id' => '120','option_name' => 'email_sub_ad_approve','option_value' => 'Congratulations! {SELLER_NAME} Your ad has been approved'),
                array('option_id' => '121','option_name' => 'email_message_ad_approve','option_value' => '<p>Congratulations! Your ad to {ADTITLE} on {SITE_TITLE} has been approved.</p>
<p>You can view your item here:</p>
<p>{ADLINK}</p>
<p>Thanks for your submission!</p>
<p>Regards,<br>{SITE_TITLE} Team</p>'),
                array('option_id' => '122','option_name' => 'email_sub_listing_rejected','option_value' => 'Sorry! {SELLER_NAME} Your ad has been rejected'),
                array('option_id' => '123','option_name' => 'email_message_listing_rejected','option_value' => '<p>Sorry! Your ad to {ADTITLE} on {SITE_TITLE} has been rejected.</p>
<p>Thanks for your submission!</p>
<p>Regards,<br>{SITE_TITLE} Team</p>'),
                array('option_id' => '124','option_name' => 'free_membership_plan','option_value' => '{"id":"free","status":"1","name":"Free Plan","description":"test","translations":{"en":{"name":"Free Plan","description":"test"},"fr":{"name":"Free Plan","description":"test"},"hi":{"name":"Free Plan","description":"test"}},"settings":{"featured_project_fee":"10","urgent_project_fee":"10","highlight_project_fee":"10","featured_duration":"30","urgent_duration":"30","highlight_duration":"30","top_search_result":"yes","show_on_home":"yes","show_in_home_search":"no","ad_limit":"10","ad_duration":"30","hide_branding":"0","advertisements":"1","custom_features":{}}}'),
                array('option_id' => '125','option_name' => 'trial_membership_plan','option_value' => '{"id":"trial","status":"1","name":"Trial Plan","description":null,"translations":{"en":{"name":"Trial Plan","description":null},"fr":{"name":"Trial Plan","description":null}},"settings":{"featured_project_fee":"10","urgent_project_fee":"10","highlight_project_fee":"10","featured_duration":"30","urgent_duration":"30","highlight_duration":"30","top_search_result":"yes","show_on_home":"yes","show_in_home_search":"no","ad_limit":"10","ad_duration":"30","hide_branding":"0","advertisements":"1","custom_features":{}}}')
            );

            DB::table('options')->insert($options);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('options');
    }
};

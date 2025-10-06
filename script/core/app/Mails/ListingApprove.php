<?php

namespace App\Mails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/* New User Account Details Email */
class ListingApprove extends Mailable
{
    use Queueable, SerializesModels;

    private $data;

    /**
     * Create a new message instance.
     *
     * @param $data
     */
    public function __construct($data)
    {
        $this->data = (object) $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $short_codes = [
            '{SITE_TITLE}' => config('settings.site_title'),
            '{SITE_URL}' => route('home'),
            '{ADTITLE}' => $this->data->post_title,
            '{ADLINK}' => $this->data->post_link,
            '{SELLER_NAME}' => $this->data->seller_name,
            '{SELLER_EMAIL}' => $this->data->seller_email,
        ];

        $this->subject(str_replace(array_keys($short_codes), array_values($short_codes), config('settings.email_sub_ad_approve')));

        return $this->markdown('emails.default', [
            'body' => config('settings.email_message_ad_approve'),
            'short_codes' => $short_codes,
        ]);
    }
}

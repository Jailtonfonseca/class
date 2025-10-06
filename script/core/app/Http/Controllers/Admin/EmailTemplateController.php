<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Option;
use Illuminate\Http\Request;
use Validator;

class EmailTemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $default_shortcodes = [
            [
                'title' => ___('Site Title'),
                'code' => '{SITE_TITLE}'
            ],
            [
                'title' => ___('Site URL'),
                'code' => '{SITE_URL}'
            ]
        ];
        $email_template = [
            [
                'id' => 'signup-details',
                'title' => ___('New User Account Details Email'),
                'subject' => 'email_sub_signup_details',
                'message' => 'email_message_signup_details',
                'shortcodes' => array_merge($default_shortcodes, [
                    [
                        'title' => ___('User ID'),
                        'code' => '{USER_ID}'
                    ],
                    [
                        'title' => ___('Username'),
                        'code' => '{USERNAME}'
                    ],
                    [
                        'title' => ___('User Full Name'),
                        'code' => '{USER_FULLNAME}'
                    ],
                    [
                        'title' => ___('User Email'),
                        'code' => '{EMAIL}'
                    ]
                ]),
            ],
            [
                'id' => 'create-account',
                'title' => ___('New User Confirmation Email'),
                'subject' => 'email_sub_signup_confirm',
                'message' => 'email_message_signup_confirm',
                'shortcodes' => array_merge($default_shortcodes, [
                    [
                        'title' => ___('User ID'),
                        'code' => '{USER_ID}'
                    ],
                    [
                        'title' => ___('Username'),
                        'code' => '{USERNAME}'
                    ],
                    [
                        'title' => ___('User Full Name'),
                        'code' => '{USER_FULLNAME}'
                    ],
                    [
                        'title' => ___('User Email'),
                        'code' => '{EMAIL}'
                    ],
                    [
                        'title' => ___('Confirmation Link'),
                        'code' => '{CONFIRMATION_LINK}'
                    ]
                ]),
            ],
            [
                'id' => 'forgot-pass',
                'title' => ___('Forgot Password Email'),
                'subject' => 'email_sub_forgot_pass',
                'message' => 'email_message_forgot_pass',
                'shortcodes' => array_merge($default_shortcodes, [
                    [
                        'title' => ___('User ID'),
                        'code' => '{USER_ID}'
                    ],
                    [
                        'title' => ___('Username'),
                        'code' => '{USERNAME}'
                    ],
                    [
                        'title' => ___('User Full Name'),
                        'code' => '{USER_FULLNAME}'
                    ],
                    [
                        'title' => ___('User Email'),
                        'code' => '{EMAIL}'
                    ],
                    [
                        'title' => ___('Password Reset Link'),
                        'code' => '{FORGET_PASSWORD_LINK}'
                    ],
                    [
                        'title' => ___('Link Expire Time in Minutes'),
                        'code' => '{EXPIRY_TIME}'
                    ]
                ]),
            ],
            [
                'id' => 'contact_us',
                'title' => ___('Contact Us Email'),
                'subject' => 'email_sub_contact',
                'message' => 'email_message_contact',
                'shortcodes' => array_merge($default_shortcodes, [
                    [
                        'title' => ___('Sender Full Name'),
                        'code' => '{NAME}'
                    ],
                    [
                        'title' => ___('Sender Email'),
                        'code' => '{EMAIL}'
                    ],
                    [
                        'title' => ___('Contact Subject'),
                        'code' => '{CONTACT_SUBJECT}'
                    ],
                    [
                        'title' => ___('Contact Message'),
                        'code' => '{MESSAGE}'
                    ]
                ]),
            ],
            [
                'id' => 'feedback',
                'title' => ___('Feedback Email'),
                'subject' => 'email_sub_feedback',
                'message' => 'email_message_feedback',
                'shortcodes' => array_merge($default_shortcodes, [
                    [
                        'title' => ___('Sender Full Name'),
                        'code' => '{NAME}'
                    ],
                    [
                        'title' => ___('Sender Email'),
                        'code' => '{EMAIL}'
                    ],
                    [
                        'title' => ___('Sender Phone Number'),
                        'code' => '{PHONE}'
                    ],
                    [
                        'title' => ___('Feedback Subject'),
                        'code' => '{FEEDBACK_SUBJECT}'
                    ],
                    [
                        'title' => ___('Feedback Message'),
                        'code' => '{MESSAGE}'
                    ]
                ]),
            ],
            [
                'id' => 'report',
                'title' => ___('Report Email'),
                'subject' => 'email_sub_report',
                'message' => 'email_message_report',
                'shortcodes' => array_merge($default_shortcodes, [
                    [
                        'title' => ___('Sender Full Name'),
                        'code' => '{NAME}'
                    ],
                    [
                        'title' => ___('Sender Email'),
                        'code' => '{EMAIL}'
                    ],
                    [
                        'title' => ___('Sender Username'),
                        'code' => '{USERNAME}'
                    ],
                    [
                        'title' => ___('Violator Username'),
                        'code' => '{USERNAME2}'
                    ],
                    [
                        'title' => ___('Violation subject'),
                        'code' => '{VIOLATION}'
                    ],
                    [
                        'title' => ___('Violation URL'),
                        'code' => '{URL}'
                    ],
                    [
                        'title' => ___('Violation Message'),
                        'code' => '{DETAILS}'
                    ],
                    [
                        'title' => ___('Report Violation'),
                        'code' => '{LANG_REPORTVIO}'
                    ],
                ]),
            ],
            [
                'id' => 'contact_seller',
                'title' => ___('Listing Contact to Seller Email'),
                'subject' => 'email_sub_contact_seller',
                'message' => 'email_message_contact_seller',
                'shortcodes' => array_merge($default_shortcodes, [
                    [
                        'title' => ___('Ad Title'),
                        'code' => '{ADTITLE}'
                    ],
                    [
                        'title' => ___('Ad Link'),
                        'code' => '{ADLINK}'
                    ],
                    [
                        'title' => ___('Seller Full Name'),
                        'code' => '{SELLER_NAME}'
                    ],
                    [
                        'title' => ___('Seller Email'),
                        'code' => '{SELLER_EMAIL}'
                    ],
                    [
                        'title' => ___('Sender Full Name'),
                        'code' => '{SENDER_NAME}'
                    ],
                    [
                        'title' => ___('Sender Email'),
                        'code' => '{SENDER_EMAIL}'
                    ],
                    [
                        'title' => ___('Sender Phone Number'),
                        'code' => '{SENDER_PHONE}'
                    ],
                    [
                        'title' => ___('Sender Message'),
                        'code' => '{MESSAGE}'
                    ]
                ]),
            ],
            [
                'id' => 'ad_approve',
                'title' => ___('Pending Listing Approve Email'),
                'subject' => 'email_sub_ad_approve',
                'message' => 'email_message_ad_approve',
                'shortcodes' => array_merge($default_shortcodes, [
                    [
                        'title' => ___('Listing Title'),
                        'code' => '{ADTITLE}'
                    ],
                    [
                        'title' => ___('Listing Link'),
                        'code' => '{ADLINK}'
                    ],
                    [
                        'title' => ___('Seller Full Name'),
                        'code' => '{SELLER_NAME}'
                    ],
                    [
                        'title' => ___('Seller Email'),
                        'code' => '{SELLER_EMAIL}'
                    ],
                ]),
            ],
            [
                'id' => 'listing_rejected',
                'title' => ___('Pending Listing Rejected Email'),
                'subject' => 'email_sub_listing_rejected',
                'message' => 'email_message_listing_rejected',
                'shortcodes' => array_merge($default_shortcodes, [
                    [
                        'title' => ___('Listing Title'),
                        'code' => '{ADTITLE}'
                    ],
                    [
                        'title' => ___('Listing Link'),
                        'code' => '{ADLINK}'
                    ],
                    [
                        'title' => ___('Seller Full Name'),
                        'code' => '{SELLER_NAME}'
                    ],
                    [
                        'title' => ___('Seller Email'),
                        'code' => '{SELLER_EMAIL}'
                    ],
                ]),
            ],
        ];
        return view('admin.mailtemplates.index',
            compact('default_shortcodes', 'email_template')
        );

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $requestData = $request->except('email_setting', '_token');
        foreach ($requestData as $key => $value) {
            Option::updateOptions($key, $value);
        }

        $result = array('success' => true, 'message' => ___('Updated Successfully'));
        return response()->json($result, 200);
    }
}

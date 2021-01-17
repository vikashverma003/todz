<?php 
return [
    'notification_type'=>[
        'PROJECT_INVITATION'=>1,
        'PROJECT_ACCEPTED'=>2,
        'PROJECT_REJECTED'=>3,
        'PROJECT_HIRED'=>4,
        'PROFILE_SCREENING_APPROVED'=>5,
        'APTITUDE_TEST_MAIL'=>6,
        'APTITUDE_TEST_APPROVED'=>7,
        'TECHNICAL_TEST_MAIL'=>8,
        'TECHNICAL_TEST_APPROVED'=>9,
        'INTERVIEW_APPROVED'=>10,
        'PAYMENT_ADD_TO_WALLET'=>11,
        'PAYMENT_DEBIT_FROM_WALLET'=>12,
        'PROJECT_DELETE_BY_CLIENT'=>13,
        'PROJECT_COMPLETED_BY_CLIENT'=>14,
        'PROJECT_MARK_DISPUTED_BY_CLIENT'=>15,
        'PROJECT_MARK_DISPUTED_BY_TALENT'=>16,
        'TALENT_REQUEST_MARK_COMPLETE_PROJECT'=>17,
        'CLIENT_REQUEST_MARK_COMPLETE_PROJECT'=>18,
        'PROJECT_COMPLETED_BY_TALENT'=>19,
        'TECHNICAL_TEST_FAIL'=>20,
        'PROFILE_SCREENING_FAIL'=>21,
        'INTERVIEW_FAIL'=>22,
        'APTITUDE_TEST_FAIL'=>23,


        
        
    ],
    'notification_message'=>[
        'PROJECT_INVITATION'=> '%s client has sent project invitation',
        'PROJECT_ACCEPTED'=> '%s todder has accepted project invitation',
        'PROJECT_REJECTED'=> '%s todder has rejected project invitation',
        'PROJECT_HIRED'   =>  '%s client has hired you on %s',
        'PROFILE_SCREENING_APPROVED'=> 'Congratulation Admin have approved your profile screening',
        'PROFILE_SCREENING_FAIL'=> 'Sorry, Admin have failed your profile screening',
        'APTITUDE_TEST_MAIL'=>'Aptitude test mail sent to your email address.',
        'APTITUDE_TEST_APPROVED'=> 'Congratulation Admin have approved your aptitude test step',
        'APTITUDE_TEST_FAIL'=> 'Sorry, Admin have failed to you in aptitude test step',
        'TECHNICAL_TEST_MAIL'=>'Technical test mail sent to your email address.',
        'TECHNICAL_TEST_APPROVED'=> 'Congratulation Admin have approved your Technical test step',
        'TECHNICAL_TEST_FAIL'=> 'Sorry, Admin have failed to you in Technical test step',
        'INTERVIEW_APPROVED'=> 'Congratulation Admin have approved your complete profile',
        'INTERVIEW_FAIL'=> 'Sorry, Admin have failed to you in Interview step',
        'PAYMENT_ADD_TO_WALLET'=>'$%d amount has been credited in your wallet for %s project from client',
        'PAYMENT_DEBIT_FROM_WALLET'=>'$%d amount has been sent to talent for %s project',
        'PROJECT_DELETE_BY_CLIENT'=>'%s project has been closed by the client',
        'PROJECT_COMPLETED_BY_CLIENT'=>'%s project has been mark completed by the client',
        'PROJECT_MARK_DISPUTED_BY_CLIENT'=>'%s project has been mark disputed by the client',
        'PROJECT_MARK_DISPUTED_BY_TALENT'=>'%s project has been mark disputed by the todder',
        'TALENT_REQUEST_MARK_COMPLETE_PROJECT'=>'%s project has been requested to mark completed by todder',
        'CLIENT_REQUEST_MARK_COMPLETE_PROJECT'=>'%s project has been requested to mark completed by client',
        'PROJECT_COMPLETED_BY_TALENT'=>'%s project has been completed by the talent',
    ]
];

    

    
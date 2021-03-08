<?php
$notifyEmailsString = getenv('NOTIFY_EMAILS');
$notifyEmails = $notifyEmailsString ? explode(',', $notifyEmailsString) : [];
return [
    'adminEmail' => 'admin@open-genes.com',
    'notifyEmails' => array_merge(['sp.olga.inf@gmail.com'], $notifyEmails),
    'supportEmail' => 'support@example.com',
    'senderEmail' => 'noreply@example.com',
    'senderName' => 'Example.com mailer',
    'user.passwordResetTokenExpire' => 3600,

    'servicesPath' => [

    ]
];

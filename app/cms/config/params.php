<?php
$notifyEmailsString = getenv('NOTIFY_EMAILS');
$notifyEmails = $notifyEmailsString ? explode(',', $notifyEmailsString) : [];
return [
    'adminEmail' => 'admin@open-genes.com',
    'notifyEmails' => array_merge(['sp.olga.inf@gmail.com'], $notifyEmails),
];

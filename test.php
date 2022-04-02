<?php 

ini_set('display_errors',1);
ini_set('display_startup_errors',1);
header('Access-Control-Allow-Headers: Access-Control-Allow-Origin, Content-Type, Authorization');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET,PUT,POST,DELETE,PATCH,OPTIONS');
require 'vendor/autoload.php';
use MailerSend\MailerSend;
use MailerSend\Helpers\Builder\Attachment;
use MailerSend\Helpers\Builder\Recipient;
use MailerSend\Helpers\Builder\EmailParams;
use MailerSend\Helpers\Builder\Variable;

$mailersend = new MailerSend(['api_key' => 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiMDYzMzk5ZWJkYjU3OGZiYjRjMTNhYTkyMzdjOWVjYzBhNjQ4ODhmNmY5Zjg4ZWM2ODNjMmEwOGQ3NTAxYWE5MTc1MzM1NTZkYzQ1ZGM1MjAiLCJpYXQiOjE2NDc1NDY5MDYuNDU3MjcyLCJuYmYiOjE2NDc1NDY5MDYuNDU3Mjc3LCJleHAiOjQ4MDMyMjA1MDYuNDUyMzg3LCJzdWIiOiIxODI1MSIsInNjb3BlcyI6WyJlbWFpbF9mdWxsIiwiZG9tYWluc19mdWxsIiwiYWN0aXZpdHlfZnVsbCIsImFuYWx5dGljc19mdWxsIiwidG9rZW5zX2Z1bGwiLCJ3ZWJob29rc19mdWxsIiwidGVtcGxhdGVzX2Z1bGwiLCJzdXBwcmVzc2lvbnNfZnVsbCJdfQ.Nr2ZcwmziDLNOnBnZSEv8FVpHVK0apfeFkPGiS9QAJgNo0lpOJu8mUAgVULzYbcYx7OYqOaLsfEb-2MoQ3CgwKpa3qFkxOPQUu5qn1UgfmvwYpe7sLeYJgGMsRuqtvRmqQFO5Aq2B8ar0PzVfa010lnEkZrD_9mNQKogC-mGUOmBJNhHjB3X9uTy7iF2kntWyEynQgS0vK2MYrkbmDglcpG6j3Jfu_b0zR2tvi4K9MjywrJ6XBShJqcymZaq3WagM-7crbyVH_6Rh9spgEVWLDeexj1qXJeUrPUidkhDiCoosuWjq9R0NKhZnd3eKyvOE8dYSNjkt316B2-UcyGqED93zYZJdOWpHlciEfP5qoOzIP8SH-XyCmXINfJ6mPcqoUev4P6i6DDYzN5wBoZ6bZDynl8qZ9u9Q4R33lyOP0TddLw2KFrHULNJHhxAhT078pPMX76vebpz56Qbtvdoaw-VNMe5LeQeEGrHuZ3BvE489p8cjDxhMlVOX1klJwSk9ChU01maPhvofXpxyf1N2nAxAVXp-J89E1BbKkMkQdT8gqf9vbrubbugI696plhQDXId0HBfKh5LP4ToBembMzKrB6WY-nvYQXoEtGfVU3vMzK8U0z5jLjtNHKiwMeDZBgA7ib75UyG4RlMmshO28lDKEWZuSstuKe7vuUnTx6U']);

$recipients = [
    new Recipient('ed@artfin.com', 'Edward Honour'),
    new Recipient('jfrontiere@gmail.com', 'Joe Frontiere'),
];

$attachments = [
    new Attachment(file_get_contents('/var/www/html/d/GEORGE_SNOW_SCHOLARSHIP_FUND_2022-04.pdf'), 'GEORGE_SNOW_SCHOLORSHIP_FUND_2022-04.pdf')
];
$variables = [
    new Variable('ed@artfin.com', ['name' => 'GEORGE SNOW SCHOLARSHIP FUND']),
    new Variable('jfrontiere@gmail.com', ['name' => 'GEORGE SNOW SCHOLARSHIP FUND']),
];

$emailParams = (new EmailParams())
    ->setFrom('donotreply@nuaxess.email')
    ->setFromName('NuAxess Billing')
    ->setRecipients($recipients)
    ->setVariables($variables)
    ->setTemplateId('jy7zpl98jyo45vx6')
    ->setSubject('Your NuAxess Invoice for April 2022')
    ->setAttachments($attachments);

$mailersend->email->send($emailParams);
?>

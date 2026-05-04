<?php
require_once('tg.php');

$error = false;
$secret = 'REMOVED_RECAPTCHA_SECRET';

// if (!empty($_POST['g-recaptcha-response'])) {
//     $curl = curl_init('https://www.google.com/recaptcha/api/siteverify');
//     curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
//     curl_setopt($curl, CURLOPT_POST, true);
//     curl_setopt($curl, CURLOPT_POSTFIELDS, 'secret=' . $secret . '&response=' . $_POST['g-recaptcha-response']);
//     $out = curl_exec($curl);
//     curl_close($curl);

//     $out = json_decode($out);
//     if ($out->success == true) {
//         $error = false;
//     }
// }

if ($error) {
    $output = [
        'status' => 0,
        'message' => 'Ошибка проверки captcha!'
    ];
    echo json_encode($output);
    exit();
}

if (empty($_POST['status'])) {
    $output = [
        'status' => 0,
        'message' => 'Неизвестная ошибка. Обновите страницу и попробуйте еще раз.'
    ];
    echo json_encode($output);
    exit();
}

$shifts = $_POST['smena'] ?? [];
$fio = $_POST['fio'] ?? '';
$phone = $_POST['phone'];
$title = $_POST['title'];

if (!$fio || !$phone || !$title || !$shifts) {
    $output = [
        'status' => 0,
        'message' => 'Заполните все поля!'
    ];
    echo json_encode($output);
    exit();
}

$note = '';
foreach ($_POST['smena'] as $key => $value) {
    $note .= "$value\r\n";
}

$dataAlfa = [
    'name' => strval($_POST['fio'] ?? ''),
    'phone' => strval($_POST['phone'] ?? ''),
    'email' => '',
    'source' => 'manual',
    'note' => $note,
    'is_study' => 0,
    'branch_ids' => [1],
    'legal_type' => 1,
    'lead_status_id' => $_POST['status'],
];

$tgMessage = 'Заполнена форма "' . $title . '"' . "\r\n";
$tgMessage .= 'Имя - ' . $fio . "\r\n";
$tgMessage .= 'Телефон - ' . $phone;

send2alfa($dataAlfa);
sendTg($tgMessage);

successMessage();

function successMessage()
{
    $output = [
        'status' => 1,
        'message' => '<div style="padding-top:15px;" class="text-center">Спасибо за заявку! <p>Свяжемся с Вами в ближайшее время.</p></div>'
    ];
    echo json_encode($output);
}

function send2alfa($dataAlfa)
{
    $ch = curl_init();
    $dataA = ['email' => 'info@supermomekb.ru', 'api_key' => 'REMOVED_ALFACRM_API_KEY'];

    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Accept: application/json', 'Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_URL, 'https://supermom.s20.online/v2api/auth/login');
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($dataA));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $resultA = json_decode(curl_exec($ch), true);
    $codeA = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if (curl_errno($ch))
        throw new \Exception('Curl error');

    curl_close($ch);

    if ($codeA !== 200)
        throw new \Exception($resultA['name'] . ' - ' . $resultA['message']);


    $ch = curl_init();
    curl_setopt(
        $ch,
        CURLOPT_URL,
        'https://supermom.s20.online/v2api/1/customer/create'
    );


    $postdataAlfa = json_encode($dataAlfa);

    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['X-ALFACRM-TOKEN:' . $resultA['token'], 'Accept: application/json', 'Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postdataAlfa);
    $outA = curl_exec($ch);

    curl_close($ch);

    error_log("[CRM] " . date('Y-m-d H:i:s') . " - Отправлена заявка: " . json_encode($dataAlfa, JSON_UNESCAPED_UNICODE) . ". Ответ: " . $outA);
}

function sendTg($message)
{

    $bot = new Telegram_Bot();
    $bot->botid('REMOVED_TELEGRAM_TOKEN')
        ->chatid('-4234178871')
        ->operation('sendMessage')
        ->message($message)
        ->execute();

}

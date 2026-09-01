<?php

require_once __DIR__ . '/tg.php';
require_once __DIR__ . '/config.php';

add_action('wp_enqueue_scripts', 'theme_add_scripts');

add_theme_support('custom-logo');
add_theme_support('post-thumbnails');

register_nav_menus([
    'top' => 'Верхнее меню',
    'bottom' => 'Нижнее меню'
]);
register_post_type('article', [
    'labels' => [
        'name' => 'Статьи',
        'add_new' => 'Добавить статью',
        'add_new_item' => 'Добавление статьи',
        'edit_item' => 'Редактирование статьи',
        'new_item' => 'Новая статья',
        'view_item' => 'Смотреть статью',
        'search_items' => 'Искать статью',
        'menu_name' => 'Статьи',
    ],
    'public' => true,
    'show_in_menu' => true,
    'show_in_rest' => true,
    'supports' => ['title', 'editor', 'thumbnail', 'excerpt'],
    'has_archive' => true,
]);
register_post_type('course', [
    'labels' => [
        'name' => 'Этап',
        'add_new' => 'Добавить этап',
        'add_new_item' => 'Добавление этапа',
        'edit_item' => 'Редактирование этапа',
        'new_item' => 'Новый этап',
        'view_item' => 'Смотреть этапы',
        'search_items' => 'Искать этапы',
        'menu_name' => 'Этапы',
    ],
    'public' => true,
    'show_in_menu' => true,
    'show_in_rest' => true,
    'supports' => ['title', 'editor', 'thumbnail'],
    'has_archive' => true,
]);
register_post_type('module', [
    'labels' => [
        'name' => 'Курс',
        'add_new' => 'Добавить курс',
        'add_new_item' => 'Добавление курса',
        'edit_item' => 'Редактирование курса',
        'new_item' => 'Новый курс',
        'view_item' => 'Смотреть курс',
        'search_items' => 'Искать курсы',
        'menu_name' => 'Курсы',
    ],
    'public' => true,
    'show_in_menu' => true,
    'show_in_rest' => true,
    'supports' => ['title', 'editor', 'thumbnail'],
    'has_archive' => true,
]);
register_post_type('tarif', [
    'labels' => [
        'name' => 'Тариф',
        'add_new' => 'Добавить тариф',
        'add_new_item' => 'Добавление тарифа',
        'edit_item' => 'Редактирование тарифа',
        'new_item' => 'Новый тариф',
        'view_item' => 'Смотреть тариф',
        'search_items' => 'Искать тарифы',
        'menu_name' => 'Тарифы',
    ],
    'public' => true,
    'show_in_menu' => true,
    'show_in_rest' => true,
    'supports' => ['title', 'editor', 'thumbnail'],
    'has_archive' => true,
]);
register_post_type('form', [
    'labels' => [
        'name' => 'Форма',
        'add_new' => 'Добавить форму',
        'add_new_item' => 'Добавление формы',
        'edit_item' => 'Редактирование формы',
        'new_item' => 'Новая форма',
        'view_item' => 'Смотреть форму',
        'search_items' => 'Искать формы',
        'menu_name' => 'Формы',
    ],
    'public' => true,
    'show_in_menu' => true,
    'show_in_rest' => true,
    'supports' => ['title'],
    'has_archive' => true,
]);

function theme_add_scripts()
{
    wp_enqueue_style('style-main', assets('styles/main.css'));

    wp_enqueue_script('script-SmoothScroll', assets('libs/SmoothScroll/SmoothScroll.js'));
    wp_enqueue_script('script-moment', assets('libs/moment/moment.js'));
    wp_enqueue_script('script-inputMask', assets('libs/inputMask/inputMask.js'));
}

function assets($path)
{
    return get_template_directory_uri() . '/assets/' . $path;
}

function getOption($key)
{
    return get_field($key, 'option');
}

function getImage(int $imageId, array $size, string $className = ''): string
{
    return wp_get_attachment_image($imageId, $size, false, ['class' => $className]);
}

function buildMenuTree(array $items, int $currentId)
{
    $menuTree = [];
    $lookup = [];

    foreach ($items as $item) {
        $item->childs = [];
        $item->is_active = ($item->object_id == $currentId);
        $lookup[$item->ID] = $item;
    }

    foreach ($items as $item) {
        if ($item->menu_item_parent && isset($lookup[$item->menu_item_parent])) {
            $lookup[$item->menu_item_parent]->childs[] = $item;
        } else {
            $menuTree[] = $item;
        }
    }

    markActiveParents($menuTree);

    return $menuTree;
}

function markActiveParents(array &$items): bool
{
    $hasActive = false;

    foreach ($items as &$item) {
        if (!empty($item->childs)) {
            $childActive = markActiveParents($item->childs);
            if ($childActive) {
                $item->is_active = true;
            }
        }

        if ($item->is_active) {
            $hasActive = true;
        }
    }

    return $hasActive;
}

$options = new Options(
    (int) getOption('logo'),
    getOption('phone'),
    getOption('email'),
    getOption('address'),
    getOption('map'),
    getOption('reqs')
);

class Options
{
    public int $logoImageId;
    public string $logoImageUrl;
    public string $phone;
    public string $phoneNumbers;
    public string $email;
    public string $address;
    public string $map;
    public string $reqs;

    public function __construct(
        $logoImageId,
        $phone,
        $email,
        $address,
        $map,
        $reqs,
    ) {
        $this->logoImageId = $logoImageId;
        $this->phone = $phone;
        $this->email = $email;
        $this->address = $address;
        $this->map = $map;
        $this->reqs = $reqs;

        $this->logoImageUrl = wp_get_attachment_url($this->logoImageId);
        $this->phoneNumbers = preg_replace('/\D+/', '', $this->phone);
    }
}

function kama_excerpt($args = ''): string
{
    global $post;

    if (is_string($args)) {
        parse_str($args, $args);
    }

    $rg = (object) array_merge([
        'maxchar' => 350,
        'text' => '',
        'autop' => true,
        'more_text' => 'Reed more...',
        'ignore_more' => false,
        'save_tags' => '<strong><b><a><em><i><var><code><span>',
        'sanitize_callback' => static function (string $text, object $rg) {
            return strip_tags($text, $rg->save_tags);
        },
    ], $args);

    $rg = apply_filters('kama_excerpt_args', $rg);

    if (!$rg->text) {
        $rg->text = $post->post_excerpt ?: $post->post_content;
    }

    $text = $rg->text;
    // strip content shortcodes: [foo]some data[/foo]. Consider markdown
    $text = preg_replace('~\[([a-z0-9_-]+)[^\]]*\](?!\().*?\[/\1\]~is', '', $text);
    // strip others shortcodes: [singlepic id=3]. Consider markdown
    $text = preg_replace('~\[/?[^\]]*\](?!\()~', '', $text);
    // strip direct URLs
    $text = preg_replace('~(?<=\s)https?://.+\s~', '', $text);
    $text = trim($text);

    // <!--more-->
    if (!$rg->ignore_more && strpos($text, '<!--more-->')) {
        preg_match('/(.*)<!--more-->/s', $text, $mm);
        $text = trim($mm[1]);
        $text_append = sprintf(' <a href="%s#more-%d">%s</a>', get_permalink($post), $post->ID, $rg->more_text);
    }
    // text, excerpt, content
    else {

        $text = call_user_func($rg->sanitize_callback, $text, $rg);
        $has_tags = false !== strpos($text, '<');

        // collect html tags
        if ($has_tags) {
            $tags_collection = [];
            $nn = 0;

            $text = preg_replace_callback('/<[^>]+>/', static function ($match) use (&$tags_collection, &$nn) {
                $nn++;
                $holder = "~$nn";
                $tags_collection[$holder] = $match[0];

                return $holder;
            }, $text);
        }

        // cut text
        $cuted_text = mb_substr($text, 0, $rg->maxchar);
        if ($text !== $cuted_text) {

            // del last word, it not complate in 99%
            $text = preg_replace('/(.*)\s\S*$/s', '\\1...', trim($cuted_text));
        }

        // bring html tags back
        if ($has_tags) {
            $text = strtr($text, $tags_collection);
            $text = force_balance_tags($text);
        }
    }

    if ($rg->autop) {
        $text = preg_replace(
            ["/\r/", "/\n{2,}/", "/\n/"],
            ['', '</p><p>', '<br />'],
            "<p>$text</p>"
        );
    }

    $text = apply_filters('kama_excerpt', $text, $rg);

    if (isset($text_append)) {
        $text .= $text_append;
    }

    return $text;
}

add_action('wp_ajax_send_order', 'sendOrder');
add_action('wp_ajax_send_gift', 'sendGift');

function sendOrder()
{
    $formId = 365;

    $child_name = sanitize_text_field($_POST['child_name'] ?? '');
    $child_birthday = sanitize_text_field($_POST['child_birthday'] ?? '');
    $mother_name = sanitize_text_field($_POST['mother_name'] ?? '');
    $phone = sanitize_text_field($_POST['phone'] ?? '');
    $agree = isset($_POST['agree']) ? true : false;

    $data = [
        'child_name' => $child_name,
        'child_birthday' => $child_birthday,
        'mother_name' => $mother_name,
        'phone' => $phone,
    ];

    $errors = [];

    if (empty($child_name)) {
        $errors['child_name'] = 'Укажите имя ребёнка.';
    }

    if (!preg_match('/^\d{2}\.\d{2}\.\d{4}$/', $child_birthday)) {
        $errors['child_birthday'] = 'Дата рождения ребёнка должна быть в формате ДД.ММ.ГГГГ.';
    }

    if (empty($mother_name)) {
        $errors['mother_name'] = 'Укажите имя матери.';
    }

    if (!preg_match('/^\+7 \(\d{3}\) \d{3}-\d{2}-\d{2}$/', $phone)) {
        $errors['phone'] = 'Телефон должен быть в формате +7 (123) 456-78-90.';
    }

    if (!$agree) {
        $errors['agree'] = 'Вы должны согласиться с обработкой данных.';
    }

    if (!empty($errors)) {
        wp_send_json(['success' => false, 'errors' => $errors], 400);
    }

    $form = new FormContainer($formId, $data);

    $subject = $form->theme;
    $message = $form->body;

    $headers = [
        'Content-Type: text/plain; charset=UTF-8',
        "From: {$form->from}"
    ];

    $dataAlfa = [
        'name' => $mother_name,
        'phone' => $phone,
        'email' => '',
        'source' => 'manual',
        'note' => $message,
        'is_study' => 0,
        'branch_ids' => [1],
        'legal_type' => 1,
        'lead_status_id' => 7
    ];

    try {
        send2alfa($dataAlfa);
    } catch (Exception $ex) {
        error_log("[ERROR] " . date('Y-m-d H:i:s') . " - {$ex->getMessage()}");
    }

    try {
        sendTg($message);
    } catch (Exception $ex) {
        error_log("[ERROR] " . date('Y-m-d H:i:s') . " - {$ex->getMessage()}");
    }

    wp_send_json_success(['message' => 'Заявка успешно отправлена!']);
}

function sendGift()
{
    $formId = 366;

    $child_age = sanitize_text_field($_POST['child_age'] ?? '');
    $gift_name = sanitize_text_field($_POST['gift_name'] ?? '');
    $gift_phone = sanitize_text_field($_POST['gift_phone'] ?? '');

    $data = [
        'child_age' => $child_age,
        'gift_name' => $gift_name,
        'gift_phone' => $gift_phone,
    ];

    $errors = [];

    if (empty($child_age) || !is_numeric($child_age)) {
        $errors['child_age'] = 'Укажите возраст ребенка';
    }

    if (empty($gift_name)) {
        $errors['gift_name'] = 'Укажите имя.';
    }

    if (!preg_match('/^\+7 \(\d{3}\) \d{3}-\d{2}-\d{2}$/', $gift_phone)) {
        $errors['gift_phone'] = 'Телефон должен быть в формате +7 (123) 456-78-90.';
    }

    if (!empty($errors)) {
        wp_send_json(['success' => false, 'errors' => $errors], 400);
    }

    $form = new FormContainer($formId, $data);

    $subject = $form->theme;
    $message = $form->body;

    $headers = [
        'Content-Type: text/plain; charset=UTF-8',
        "From: {$form->from}"
    ];

    $dataAlfa = [
        'name' => $gift_name,
        'phone' => $gift_phone,
        'email' => '',
        'source' => 'manual',
        'note' => $message,
        'is_study' => 0,
        'branch_ids' => [1],
        'legal_type' => 1,
        'lead_status_id' => 7
    ];

    try {
        send2alfa($dataAlfa);
    } catch (Exception $ex) {
        error_log("[ERROR] " . date('Y-m-d H:i:s') . " - {$ex->getMessage()}");
    }

    try {
        sendTg($message);
    } catch (Exception $ex) {
        error_log("[ERROR] " . date('Y-m-d H:i:s') . " - {$ex->getMessage()}");
    }

    wp_send_json_success(['message' => 'Заявка успешно отправлена!']);
}

class FormContainer
{
    private array $globalPlaceholders = ['_site_admin_email' => '', '_site_title' => ''];
    public string $to;
    public string $from;
    public string $theme;
    public string $headers;
    public string $body;

    public function __construct($formId, $data = [])
    {
        $this->initGlobalPlaceholders();

        $to = get_field('to', $formId);
        $from = get_field('from', $formId);
        $theme = get_field('theme', $formId);
        $headers = get_field('headers', $formId);
        $body = get_field('body', $formId);

        $placeholders = array_merge($this->globalPlaceholders, $data);

        $this->to = $this->replacePlaceholders($to, $placeholders);
        $this->from = $this->replacePlaceholders($from, $placeholders);
        $this->theme = $this->replacePlaceholders($theme, $placeholders);
        $this->headers = $this->replacePlaceholders($headers, $placeholders);
        $this->body = $this->replacePlaceholders($body, $placeholders);
    }

    private function initGlobalPlaceholders()
    {
        $this->globalPlaceholders['_site_admin_email'] = get_option('admin_email');
        $this->globalPlaceholders['_site_title'] = get_bloginfo('name');
    }

    private function replacePlaceholders(string &$str, array $placeholders): string
    {
        foreach ($placeholders as $placeholder => $value) {
            $str = str_replace("[$placeholder]", $value, $str);
        }

        return $str;
    }
}

function send2alfa($dataAlfa)
{
    $ch = curl_init();
    $dataA = ['email' => theme_env('ALFACRM_EMAIL'), 'api_key' => theme_env('ALFACRM_API_KEY')];

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
    $bot->botid(theme_env('TELEGRAM_BOT_TOKEN'))
        ->chatid(theme_env('TELEGRAM_CHAT_ID'))
        ->operation('sendMessage')
        ->message($message)
        ->execute();
}

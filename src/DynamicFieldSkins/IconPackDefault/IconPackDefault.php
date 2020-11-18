<?php
namespace Amuz\XePlugin\DynamicFieldExtend\DynamicFieldSkins\IconPackDefault;

use Xpressengine\DynamicField\AbstractSkin;

class IconPackDefault extends AbstractSkin
{

/*
xi-home, xi-home-o, xi-bars, xi-hamburger-back, xi-hamburger-out, xi-apps,
xi-ellipsis-h, xi-ellipsis-v, xi-drag-vertical, xi-drag-handle, xi-arrow-top, xi-arrow-bottom
*/
    public $icon_action = array(
        "xi-home", "xi-home-o", "xi-bars", "xi-hamburger-back", "xi-hamburger-out", "xi-apps",
        "xi-ellipsis-h", "xi-ellipsis-v", "xi-drag-vertical", "xi-drag-handle", "xi-arrow-top", "xi-arrow-bottom",
        "xi-arrow-left", "xi-arrow-right", "xi-arrow-up", "xi-arrow-down", "xi-long-arrow-left", "xi-long-arrow-right",
        "xi-long-arrow-up", "xi-long-arrow-down", "xi-angle-left", "xi-angle-left-min", "xi-angle-left-thin","xi-angle-right",
        "xi-angle-right-min","xi-angle-right-thin", "xi-angle-up", "xi-angle-up-min", "xi-angle-up-thin", "xi-angle-down","xi-angle-down-min",
        "xi-angle-down-thin", "xi-caret-up", "xi-caret-up-min", "xi-caret-down", "xi-caret-down-min", "xi-caret-up-circle", "xi-caret-up-circle-o",
        "xi-caret-down-circle", "xi-caret-down-circle-o", "xi-caret-up-square", "xi-caret-up-square-o", "xi-caret-down-square", "xi-caret-down-square-o",
        "xi-arrows-h", "xi-arrows-v", "xi-expand", "xi-compress", "xi-arrows", "xi-arrows-alt", "xi-compare-arrows",
        "xi-scroll", "xi-dashboard", "xi-dashboard-o", "xi-refresh", "xi-catched", "xi-renew",
        "xi-sync", "xi-eye", "xi-eye-o", "xi-eye-off", "xi-eye-off-o", "xi-lock", "xi-lock-o", "xi-unlock", "xi-unlock-o",
        "xi-trash", "xi-trash-o", "xi-flag", "xi-flag-o", "xi-expand-square", "xi-compress-square", "xi-log-in",
        "xi-log-out", "xi-search", "xi-zoom-in", "xi-zoom-out", "xi-subdirectory", "xi-subdirectory-arrow",
        "xi-external-link", "xi-cog", "xi-view-array", "xi-view-carousel", "xi-view-column", "xi-view-day",
        "xi-view-list", "xi-view-module", "xi-view-stream", "xi-wrench", "xi-filter"
    );

    public $str_content = "xi-plus,xi-plus-min,xi-plus-thin,xi-minus,xi-minus-min,xi-minus-thin,xi-close,xi-close-min,xi-close-thin,
        xi-check,xi-check-min,xi-check-thin,xi-plus-circle,xi-plus-circle-o,xi-minus-circle,xi-minus-circle-o,xi-close-circle,xi-close-circle-o,
        xi-check-circle,xi-check-circle-o,xi-plus-square,xi-plus-square-o,xi-minus-square,xi-minus-square-o,xi-close-square,xi-close-square-o,
        xi-check-square,xi-checkbox-blank,xi-check-square-o,xi-radiobox-blank,xi-radiobox-checked,xi-cut,xi-label,xi-label-o,xi-library-add,
        xi-library-bookmark,xi-save,xi-lightbulb,xi-lightbulb-o,xi-link,xi-package,xi-pen,xi-pen-o,xi-undo,xi-redo,xi-switch-off,xi-switch-on,
        xi-toggle-off,xi-toggle-on,xi-bookmark,xi-bookmark-o,xi-tag,xi-tags";

    public $str_communication = "xi-mail,xi-mail-o,xi-mail-read,xi-mail-read-o,xi-send,xi-reply,xi-reply-all,xi-share,xi-share-alt,xi-share-alt-o,
    xi-call,xi-call-outgoing,xi-call-incoming,xi-call-missed,xi-comment,xi-comment-o,xi-forum,xi-forum-o,xi-video-call,xi-voicemail,xi-note,xi-note-o,
    xi-at,xi-message,xi-message-o,xi-speech,xi-speech-o,xi-user-address,xi-profile,xi-profile-o,xi-user,xi-users,xi-group,xi-user-plus,xi-users-plus,
    xi-user-o,xi-users-o,xi-user-plus-o,xi-star,xi-star-o,xi-heart,xi-heart-o,xi-thumbs-up,xi-thumbs-down,xi-crown,xi-trophy,xi-emoticon-happy,
    xi-emoticon-happy-o,xi-emoticon-smiley,xi-emoticon-smiley-o,xi-emoticon-neutral,xi-emoticon-neutral-o,xi-emoticon-bad,xi-emoticon-bad-o,xi-emoticon-sad,
    xi-emoticon-sad-o,xi-emoticon-devil,xi-emoticon-devil-o,xi-emoticon-cool,xi-emoticon-cool-o";

    public $str_message = "xi-bell,xi-bell-o,xi-bell-off,xi-bell-off-o,xi-alarm,xi-alarm-o,xi-alarm-off,xi-time,xi-time-o,xi-snooze,xi-calendar,
    xi-calendar-add,xi-calendar-remove,xi-calendar-cancle,xi-calendar-check,xi-calendar-list,xi-new,xi-new-o,xi-info,xi-info-o,xi-help,xi-help-o,
    xi-error,xi-error-o,xi-ban,xi-warning,xi-hand-paper,xi-key,xi-security,xi-shield-checked,xi-shield-checked-o";

    public $str_editor = "xi-align-justify,xi-align-left,xi-align-center,xi-align-right,xi-indent,xi-dedent,xi-list-dot,xi-list-square,xi-list-number,
    xi-list,xi-paragraph,xi-bold,xi-italic,xi-strikethrough,xi-underline,xi-caps,xi-text-size,xi-text-type,xi-spellcheck,xi-translate,xi-line-height,
    xi-font,xi-text-format,xi-text-color,xi-color-fill,xi-color-helper,xi-scissors,xi-document,xi-palette,xi-color-dropper,xi-eraser,xi-eraser-o,xi-sort-asc,
    xi-sort-desc,xi-rotate-right,xi-rotate-left,xi-layout,xi-layout-o,xi-layout-full,xi-layout-full-o,xi-layout-snb,xi-layout-snb-o,xi-layout-aside,
    xi-layout-aside-o,xi-layout-column,xi-layout-column-o,xi-crop,xi-border-color,xi-line-style,xi-line-weight,xi-border-all,xi-border-bottom,xi-border-clear,
    xi-border-horizontal,xi-border-inner,xi-border-left,xi-border-outer,xi-border-right,xi-border-style,xi-border-top,xi-border-vertical,xi-valign-top,
    -valign-bottom,xi-valign-center,xi-code,xi-emoticon,xi-link-insert,xi-link-broken,xi-omega,xi-opacity,xi-overscan,xi-paperclip,xi-transform";

    public $str_hardware = "xi-power-off,xi-esc,xi-command,xi-alt,xi-tab,xi-backspace,xi-capslock,xi-watch,xi-mouse,xi-sdcard,xi-usb-drive,xi-diskette,
    xi-print,xi-fax,xi-webcam,xi-projector,xi-presentation,xi-plug,xi-speaker,xi-airplay,xi-alarm-clock,xi-alarm-clock-o,xi-alarm-clock-off,xi-battery,
    xi-battery-o,xi-battery-10,xi-battery-20,xi-battery-30,xi-battery-40,xi-battery-50,xi-battery-60,xi-battery-70,xi-battery-80,xi-battery-90,xi-bluetooth,
    xi-bluetooth-off,xi-bluetooth-on,xi-bluetooth-search,xi-brightness,xi-clock,xi-clock-o,xi-contrast,xi-desktop,xi-laptop,xi-devices,xi-tablet,xi-mobile,
    xi-tv,xi-enter,xi-flashlight,xi-flashlight-off,xi-flight-off,xi-flight-on,xi-gamepad,xi-gps,xi-gps-none,xi-gps-off,xi-hdd,xi-hdmi,xi-keyboard,xi-keyboard-o,
    xi-space-bar,xi-lock-rotation,xi-chip,xi-chip-o,xi-mouse-pointer,xi-router,xi-router-o,xi-signal,xi-signal-1,xi-signal-2,xi-signal-3,xi-signal-4,
    xi-signal-none,xi-touch,xi-usb,xi-wifi,xi-wifi-signal-mid,xi-wifi-signal-min,xi-wifi-signal-off";

    public $str_media = "xi-chart-bar,xi-book,xi-book-o,xi-play,xi-play-circle,xi-play-circle-o,xi-pause-circle,xi-pause-circle-o,xi-pause,xi-stop,
    xi-recording-stop,xi-recording,xi-eject,xi-step-backward,xi-step-forward,xi-backward,xi-forward,xi-fast-backward,xi-fast-forward,xi-camera,
    xi-camera-o,xi-videocam,xi-videocam-o,xi-image,xi-image-o,xi-microphone-o,xi-microphone,xi-microphone-off,xi-volume-mute,xi-volume-down,xi-volume-up,
    xi-volume-off,xi-album,xi-headset,xi-music,xi-chart-pyramid,xi-chart-bar-square,xi-chart-line,xi-chart-pie,xi-chart-pie-o,xi-equalizer,xi-equalizer-thin,
    xi-exposure,xi-flash,xi-flash-off,xi-focus-center,xi-focus-frame,xi-focus-weak,xi-paper,xi-paper-o,xi-library-books,xi-library-books-o,xi-library-image
    ,xi-library-image-o,xi-library-music,xi-library-video,xi-movie,xi-movie-o,xi-pacman,xi-radio,xi-repeat,xi-repeat-one,xi-shuffle,xi-timer,xi-timer-o
    ,xi-timer-off-o,xi-timer-sand,xi-timer-sand-o,xi-trending-flat,xi-trending-down,xi-trending-up,xi-tune";

    public $str_map = "xi-map,xi-map-o,xi-my-location,xi-location-arrow,xi-woman,xi-man,xi-toilet,xi-pregnant-woman,xi-walk,xi-run,xi-wheelchair,xi-glass,
    xi-market,xi-pharmacy,xi-laundry,xi-florist,xi-hlz,xi-park,xi-airplane,xi-all,xi-flight-takeoff,xi-flight-land,xi-bank,xi-beach,xi-bicycle,xi-building,
    xi-bus,xi-business,xi-cafe,xi-cake,xi-car,xi-church,xi-city,xi-compass,xi-compass-o,xi-convenience-store,xi-directions,xi-factory,xi-fitness-center,
    xi-garden,xi-gas-station,xi-golf,xi-hand-pointing,xi-hospital,xi-hotel,xi-library,xi-maker,xi-marker-plus,xi-maker-drop,xi-marker-check,xi-motorcycle,
    xi-navigation,xi-pool,xi-restaurant,xi-school,xi-ship,xi-spa,xi-stroller,xi-subway,xi-taxi,xi-theater,xi-traffic,xi-train";

    public $str_ecommerce = "xi-cart,xi-cart-o,xi-cart-add,xi-cart-remove,xi-basket,xi-box,xi-fragile,xi-coupon,xi-shop,xi-gift,xi-gift-o,xi-exchange,xi-yuan,
    xi-won,xi-yen,xi-pound,xi-euro,xi-rial,xi-dollar,xi-peso,xi-rupee,xi-credit-card,xi-money,xi-piggy-bank,xi-strongbox,xi-briefcase,xi-percent,
    xi-calculator,xi-medicine,xi-receipt,xi-truck,xi-wallet";

    public $str_file  = "xi-file,xi-file-o,xi-file-add,xi-file-add-o,xi-file-remove,xi-file-remove-o,xi-file-text,xi-file-text-o,xi-documents,xi-documents-o,
    xi-file-image,xi-file-image-o,xi-file-video,xi-file-video-o,xi-file-music,xi-file-music-o,xi-file-code,xi-file-code-o,xi-file-zip,xi-file-zip-o,xi-file-upload,
    xi-file-upload-o,xi-file-download,xi-file-download-o,xi-file-check,xi-file-check-o,xi-folder,xi-folder-o,xi-folder-open,xi-folder-shared,xi-folder-zip,
    xi-folder-zip-o,xi-folder-add,xi-folder-add-o,xi-folder-remove,xi-folder-remove-o,xi-folder-check,xi-folder-check-o,xi-folder-upload,xi-folder-upload-o,
    xi-folder-download,xi-folder-download-o,xi-attachment,xi-cloud,xi-cloud-o,xi-cloud-off,xi-cloud-upload,xi-cloud-upload-o,xi-cloud-download,
    xi-cloud-download-o,xi-upload,xi-download";

    public $str_technology = "xi-globus,xi-browser,xi-browser-text,xi-rss-square,xi-central-signal,xi-central-router,xi-antenna,xi-barcode,xi-qr-code,xi-accessibility,
    xi-branch,xi-fork,xi-pull-requests,xi-merge,xi-log,xi-bug,xi-cookie,xi-fingerprint,xi-css3,xi-html5,xi-javascript,xi-csharp,xi-php,xi-python,xi-milestone,
    xi-network-company,xi-network-folder,xi-network-home,xi-network-public,xi-puzzle,xi-rss,xi-server,xi-network-server,xi-sitemap,xi-sitemap-o";

    public $str_spinner = "xi-spinner-1,xi-spinner-2,xi-spinner-3,xi-spinner-4,xi-spinner-5";

    public $str_weather = "xi-full-moon,xi-half-moon,xi-crescent,xi-moon,xi-night,xi-snow-crystal,xi-cloudy,xi-fog,xi-foggy,xi-lightning,xi-partly-cloudy,xi-pouring,
    xi-snowy,xi-sun,xi-sun-o,xi-sunset,xi-sunset-down,xi-sunset-up,xi-thermometer,xi-tint,xi-tint-o,xi-tornado,xi-umbrella,xi-umbrella-o,xi-windy,xi-windy-variant,xi-windsock";

    public $str_license = "xi-cc-cc,xi-cc-by,xi-cc-sa,xi-cc-nd,xi-cc-nc,xi-cc-nc-eu,xi-cc-nc-jp,xi-cc-remix,xi-cc-pd,xi-cc-sampling,xi-cc-zero,xi-cc-share,xi-copyleft,xi-copyright,xi-registered,xi-trademark";

    public $str_brand = "xi-500px,xi-adobe,xi-amazon,xi-android,xi-apple,xi-beats,xi-behance,xi-bing,xi-bitbucket,xi-blackberry,xi-blogger,xi-cc-amex,xi-cc-discover,
    xi-cc-mastercard,xi-cc-paypal,xi-cc-stripe,xi-cc-visa,xi-chrome,xi-codepen,xi-connectdevelop,xi-d2,xi-dashcube,xi-delicious,xi-deviantart,xi-digg,xi-disqus,xi-dribbble,
    xi-dropbox,xi-drupal,xi-edge,xi-evernote,xi-facebook,xi-facebook-messenger,xi-facebook-official,xi-feedly,xi-firefox,xi-flickr,xi-flickr-square,xi-foursquare,xi-ghost,
    xi-git,xi-git-symbol,xi-github,xi-github-alt,xi-gmail,xi-google,xi-google-play,xi-google-plus,xi-google-wallet,xi-gratipay,xi-hangouts,xi-hunie,xi-illustrator,
    xi-illustrator-circle,xi-instagram,xi-internet-explorer,xi-jira,xi-joomla,xi-jsfiddle,xi-kakaostory,xi-kakaotalk,xi-kickstarter,xi-laravel,xi-line,xi-line-messenger,
    xi-linkedin,xi-linkedin-square,xi-linux,xi-magento,xi-maxcdn,xi-medium,xi-naver,xi-naver-square,xi-office,xi-opencart,xi-opera,xi-oscommerce,xi-path,xi-paypal,xi-photoshop,
    xi-photoshop-circle,xi-pinterest,xi-pinterest-p,xi-pocket,xi-qq,xi-quicktime,xi-reddit,xi-renren,xi-safari,xi-sellsy,xi-silverstripe,xi-simplybuilt,xi-sketch,xi-skype,
    xi-slack,xi-slideshare,xi-soundcloud,xi-spotify,xi-stack-exchange,xi-stack-overflow,xi-steam,xi-steam-square,xi-stumbleupon,xi-stumbleupon-circle,xi-telegram,xi-tencent-weibo,
    xi-trello,xi-tumblr,xi-tumblr-square,xi-twich,xi-twitter,xi-ubercart,xi-ubuntu,xi-ubuntu-circle,xi-vimeo,xi-vine,xi-vk,xi-wechat,xi-whatsapp,xi-wikipedia,xi-windows,
    xi-wordpress,xi-wordpress-official,xi-xe,xi-xing,xi-xpressengine,xi-yahoo,xi-yelp,xi-youtube,xi-youtube-play";

    /**
     * get name of skin
     *
     * @return string
     */
    public function name()
    {
        //return 'IconPackDefault fieldSkin';
        return 'Icon pack default ';
    }

    /**
     * get view file directory path
     *
     * @return string
     */
    public function getPath()
    {
        return 'dynamic_field_extend::src.DynamicFieldSkins.IconPackDefault.views';
    }

    /**
     * 다이나믹필스 생성할 때 스킨 설정에 적용될 rule 반환
     *
     * @return array
     */
    public function getSettingsRules()
    {
        return [];
    }


    /**
     * 등록 form 에 추가될 html 코드 반환
     * return html tag string
     *
     * @param array $args arguments
     * @return \Illuminate\View\View
     */
    public function create(array $args)
    {
        $viewFactory = $this->handler->getViewFactory();

        list($data, $key) = $this->filter($args);

        $icon_action = $this->icon_action;
        $icon_content = $this->icon_str_parse($this->str_content);
        $icon_communication = $this->icon_str_parse($this->str_communication);
        $icon_message = $this->icon_str_parse($this->str_message);
        $icon_editor = $this->icon_str_parse($this->str_editor);
        $icon_hardware = $this->icon_str_parse($this->str_hardware);
        $icon_media = $this->icon_str_parse($this->str_media);
        $icon_map = $this->icon_str_parse($this->str_map);
        $icon_ecommerce = $this->icon_str_parse($this->str_ecommerce);
        $icon_file = $this->icon_str_parse($this->str_file);
        $icon_technology = $this->icon_str_parse($this->str_technology);
        $icon_spinner = $this->icon_str_parse($this->str_spinner);
        $icon_weather = $this->icon_str_parse($this->str_weather);
        $icon_license = $this->icon_str_parse($this->str_license);
        $icon_brand = $this->icon_str_parse($this->str_brand);

        return $viewFactory->make($this->getViewPath('create'), [
            'args' => $args,
            'config' => $this->config,
            'data' => array_merge($data, $this->mergeData),
            'key' => $key,
            'icon_action' => $icon_action,
            'icon_content' => $icon_content,
            'icon_communication' => $icon_communication,
            'icon_message' => $icon_message,
            'icon_editor' => $icon_editor,
            'icon_hardware' => $icon_hardware,
            'icon_media' => $icon_media,
            "icon_map" => $icon_map,
            "icon_ecommerce" => $icon_ecommerce,
            "icon_file" => $icon_file,
            "icon_technology" => $icon_technology,
            "icon_spinner" => $icon_spinner,
            "icon_weather" => $icon_weather,
            "icon_license" => $icon_license,
            "icon_brand" => $icon_brand,
        ])->render();
    }

    /**
     * 수정 form 에 추가될 html 코드 반환
     * return html tag string
     *
     * @param array $args arguments
     * @return \Illuminate\View\View
     */
    public function edit(array $args)
    {
        list($data, $key) = $this->filter($args);

        $icon_action = $this->icon_action;
        $icon_content = $this->icon_str_parse($this->str_content);
        $icon_communication = $this->icon_str_parse($this->str_communication);
        $icon_message = $this->icon_str_parse($this->str_message);
        $icon_editor = $this->icon_str_parse($this->str_editor);
        $icon_hardware = $this->icon_str_parse($this->str_hardware);
        $icon_media = $this->icon_str_parse($this->str_media);
        $icon_map = $this->icon_str_parse($this->str_map);
        $icon_ecommerce = $this->icon_str_parse($this->str_ecommerce);
        $icon_file = $this->icon_str_parse($this->str_file);
        $icon_technology = $this->icon_str_parse($this->str_technology);
        $icon_spinner = $this->icon_str_parse($this->str_spinner);
        $icon_weather = $this->icon_str_parse($this->str_weather);
        $icon_license = $this->icon_str_parse($this->str_license);
        $icon_brand = $this->icon_str_parse($this->str_brand);

        $viewFactory = $this->handler->getViewFactory();
        return $viewFactory->make($this->getViewPath('edit'), [
            'args' => $args,
            'config' => $this->config,
            'data' => array_merge($data, $this->mergeData),
            'key' => $key,
            'icon_action' => $icon_action,
            'icon_content' => $icon_content,
            'icon_communication' => $icon_communication,
            'icon_message' => $icon_message,
            'icon_editor' => $icon_editor,
            'icon_hardware' => $icon_hardware,
            'icon_media' => $icon_media,
            "icon_map" => $icon_map,
            "icon_ecommerce" => $icon_ecommerce,
            "icon_file" => $icon_file,
            "icon_technology" => $icon_technology,
            "icon_spinner" => $icon_spinner,
            "icon_weather" => $icon_weather,
            "icon_license" => $icon_license,
            "icon_brand" => $icon_brand,
        ])->render();
    }

    public function icon_str_parse($str){
        $arr = explode(",",  preg_replace("/[^A-Za-z0-9-,]/", "",$str));
        return $arr;
    }
}


//$temp_exp = explode("\n", "");
//
//
//
//$cnt = 0;
//$temp_array = array();
//foreach ($temp_exp as $value){
//    if($cnt%2==1){
//        array_push($temp_array, $value);
//    }
//
//    $cnt++;
//}
//echo implode(",", $temp_array);


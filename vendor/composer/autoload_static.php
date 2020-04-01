<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit19fa51539b965672ee778d7bc1a858b1
{
    public static $prefixLengthsPsr4 = array (
        'A' => 
        array (
            'A3Rev\\WCCompare\\' => 16,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'A3Rev\\WCCompare\\' => 
        array (
            0 => __DIR__ . '/../..' . '/includes',
            1 => __DIR__ . '/../..' . '/classes',
            2 => __DIR__ . '/../..' . '/widgets',
            3 => __DIR__ . '/../..' . '/admin',
        ),
    );

    public static $classMap = array (
        'A3Rev\\WCCompare\\Admin\\Categories' => __DIR__ . '/../..' . '/admin/classes/class-wc-compare-categories.php',
        'A3Rev\\WCCompare\\Admin\\Features_Panel' => __DIR__ . '/../..' . '/admin/classes/class-wc-compare-features-panel.php',
        'A3Rev\\WCCompare\\Admin\\Fields' => __DIR__ . '/../..' . '/admin/classes/class-wc-compare-fields.php',
        'A3Rev\\WCCompare\\Admin\\Products' => __DIR__ . '/../..' . '/admin/classes/class-wc-compare-products.php',
        'A3Rev\\WCCompare\\Data' => __DIR__ . '/../..' . '/classes/data/class-wc-compare-data.php',
        'A3Rev\\WCCompare\\Data\\Categories' => __DIR__ . '/../..' . '/classes/data/class-wc-compare-categories-data.php',
        'A3Rev\\WCCompare\\Data\\Categories_Fields' => __DIR__ . '/../..' . '/classes/data/class-wc-compare-categories-fields-data.php',
        'A3Rev\\WCCompare\\Features_Backend' => __DIR__ . '/../..' . '/classes/class-wc-compare-features.php',
        'A3Rev\\WCCompare\\FrameWork\\Admin_Init' => __DIR__ . '/../..' . '/admin/admin-init.php',
        'A3Rev\\WCCompare\\FrameWork\\Admin_Interface' => __DIR__ . '/../..' . '/admin/admin-interface.php',
        'A3Rev\\WCCompare\\FrameWork\\Admin_UI' => __DIR__ . '/../..' . '/admin/admin-ui.php',
        'A3Rev\\WCCompare\\FrameWork\\Fonts_Face' => __DIR__ . '/../..' . '/admin/includes/fonts_face.php',
        'A3Rev\\WCCompare\\FrameWork\\Less_Sass' => __DIR__ . '/../..' . '/admin/less/sass.php',
        'A3Rev\\WCCompare\\FrameWork\\Pages\\WC_Compare' => __DIR__ . '/../..' . '/admin/admin-pages/admin-product-comparison-page.php',
        'A3Rev\\WCCompare\\FrameWork\\Settings\\Compare_Widget' => __DIR__ . '/../..' . '/admin/settings/widget-style/compare-widget-settings.php',
        'A3Rev\\WCCompare\\FrameWork\\Settings\\Comparison_Page' => __DIR__ . '/../..' . '/admin/settings/comparison-page/global-settings.php',
        'A3Rev\\WCCompare\\FrameWork\\Settings\\Comparison_Page\\Page_Style' => __DIR__ . '/../..' . '/admin/settings/comparison-page/page-style-settings.php',
        'A3Rev\\WCCompare\\FrameWork\\Settings\\Global_Panel' => __DIR__ . '/../..' . '/admin/settings/global-settings.php',
        'A3Rev\\WCCompare\\FrameWork\\Settings\\Grid_View' => __DIR__ . '/../..' . '/admin/settings/gridview-style/global-settings.php',
        'A3Rev\\WCCompare\\FrameWork\\Settings\\Product_Page' => __DIR__ . '/../..' . '/admin/settings/product-page/global-settings.php',
        'A3Rev\\WCCompare\\FrameWork\\Settings\\Product_Page\\Compare_Button' => __DIR__ . '/../..' . '/admin/settings/product-page/compare-button-settings.php',
        'A3Rev\\WCCompare\\FrameWork\\Settings\\Product_Page\\Compare_Tab' => __DIR__ . '/../..' . '/admin/settings/product-page/compare-tab-settings.php',
        'A3Rev\\WCCompare\\FrameWork\\Settings\\Product_Page\\View_Compare_Button' => __DIR__ . '/../..' . '/admin/settings/product-page/view-compare-settings.php',
        'A3Rev\\WCCompare\\FrameWork\\Tabs\\Comparison_Page' => __DIR__ . '/../..' . '/admin/tabs/comparison-page-tab.php',
        'A3Rev\\WCCompare\\FrameWork\\Tabs\\Global_Settings' => __DIR__ . '/../..' . '/admin/tabs/global-tab.php',
        'A3Rev\\WCCompare\\FrameWork\\Tabs\\GridView_Style' => __DIR__ . '/../..' . '/admin/tabs/gridview-style-tab.php',
        'A3Rev\\WCCompare\\FrameWork\\Tabs\\Product_Page' => __DIR__ . '/../..' . '/admin/tabs/product-page-tab.php',
        'A3Rev\\WCCompare\\FrameWork\\Tabs\\Widget_Style' => __DIR__ . '/../..' . '/admin/tabs/widget-style-tab.php',
        'A3Rev\\WCCompare\\FrameWork\\Uploader' => __DIR__ . '/../..' . '/admin/includes/uploader/class-uploader.php',
        'A3Rev\\WCCompare\\Functions' => __DIR__ . '/../..' . '/classes/class-wc-compare-functions.php',
        'A3Rev\\WCCompare\\Hook_Filter' => __DIR__ . '/../..' . '/classes/class-wc-compare-filter.php',
        'A3Rev\\WCCompare\\Install' => __DIR__ . '/../..' . '/includes/class-wc-compare-install.php',
        'A3Rev\\WCCompare\\MetaBox' => __DIR__ . '/../..' . '/classes/class-wc-compare-metabox.php',
        'A3Rev\\WCCompare\\Widget' => __DIR__ . '/../..' . '/widgets/compare_widget.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit19fa51539b965672ee778d7bc1a858b1::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit19fa51539b965672ee778d7bc1a858b1::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit19fa51539b965672ee778d7bc1a858b1::$classMap;

        }, null, ClassLoader::class);
    }
}

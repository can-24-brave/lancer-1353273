<?php

namespace Plugin\DSContents\ServiceProvider;

use Plugin\DSContents\Form\Type\DSContentsConfigType;
use Silex\Application as BaseApplication;
use Silex\ServiceProviderInterface;

class DSContentsServiceProvider implements ServiceProviderInterface
{

    public function register(BaseApplication $app)
    {
        // 独自コントローラ
        // fix コントローラ作成
        $app->match('/'.$app['config']['admin_route'].'/dsc/sp/layout/{id}/edit', 'Plugin\DSContents\Controller\Admin\Content\LayoutController::index')->assert('id', '\d+')->bind('plugin_admin_content_layout_edit');
        $app->match('/'.$app['config']['admin_route'].'/dsc/sp/layout/{id}/preview', 'Plugin\DSContents\Controller\Admin\Content\LayoutController::preview')->assert('id', '\d+')->bind('plugin_content_layout_preview');

        // ログファイル設定
        $app['monolog.logger.dscontents'] = $app->share(function ($app) {
            $config = array(
                'name' => 'dscontents',
                'filename' => 'dscontents',
                'delimiter' => '_',
                'dateformat' => 'Y-m-d',
                'log_level' => 'INFO',
                'action_level' => 'ERROR',
                'passthru_level' => 'INFO',
                'max_files' => '90',
                'log_dateformat' => 'Y-m-d H:i:s,u',
                'log_format' => '[%datetime%] %channel%.%level_name% [%session_id%] [%uid%] [%user_id%] [%class%:%function%:%line%] - %message% %context% %extra% [%method%, %url%, %ip%, %referrer%, %user_agent%]',
            );
            return $app['eccube.monolog.factory']($config);
        });

    }

    public function boot(BaseApplication $app)
    {
    }

}

<?php

use \Monolog\Logger;
use \Monolog\Handler\StreamHandler;

use \Illuminate\Database\Capsule\Manager as CapsuleManager;

use \Slim\Views\{Twig, TwigExtension};
use \Slim\Flash\Messages;

use \Cartalyst\Sentinel\Native\Facades\Sentinel;

use \Symfony\Component\Form\Forms;
use \Symfony\Component\Form\Extension\HttpFoundation\HttpFoundationExtension;

use \Symfony\Bridge\Twig\Extension\{FormExtension, TranslationExtension};
use \Symfony\Bridge\Twig\Form\{TwigRenderer, TwigRendererEngine};
use \Symfony\Component\HttpFoundation\Session\Session;
use \Symfony\Component\Form\Extension\Csrf\CsrfExtension;

use \Symfony\Component\Security\Csrf\TokenStorage\NativeSessionTokenStorage;
use \Symfony\Component\Security\Csrf\TokenGenerator\UriSafeTokenGenerator;
use \Symfony\Component\Security\Csrf\CsrfTokenManager;

use \Symfony\Component\Translation\Translator;
use \Symfony\Component\Translation\Loader\XliffFileLoader;
 

/* Container is made */
    $container = $app->getContainer();

/* Logs: Prepares logs */
    $container['logger'] = function($c) {
        $logger = new Logger('my_logger');
        $file_handler = new StreamHandler("../logs/app.log");
        $logger->pushHandler($file_handler);
        return $logger;
    };

/* Model: Activates Eloquent, an ORM. Prepares database connection */
    $capsule = new CapsuleManager;
    $capsule->addConnection($container->get('settings')['db']);
    $capsule->bootEloquent();

/* View: Prepares Twig for rendering of templates. */

    // the Twig file that holds all the default markup for rendering forms
    $defaultFormTheme = 'form_div_layout.html.twig';

    //Container is prepared for Twig
    $container['view'] = function ($container){
        $view = new Twig(
            ['../app/views', '../vendor/symfony/twig-bridge/Resources/views/Form'], 
            ['cache' => '../storage/cache']);
        $view->addExtension(new TwigExtension(
            $container['router'],
            $container['request']->getUri()
        ));

        return $view;
    };

    $container['form_engine'] = new TwigRendererEngine(array($defaultFormTheme));
    $container->form_engine->setEnvironment($container->view->getEnvironment());

/* User Authentication: Activating Sentinel--Requires Eloquent */
    $container['sentinel'] = (new Sentinel())->getSentinel();

/* Flash Message */
    $container['flash'] = function () {
        return new FlashMessages();
    };

/* CSRF protector */
    // create a Session object from the HttpFoundation component
    $session = new Session();

    $csrfGenerator = new UriSafeTokenGenerator();
    $csrfStorage = new NativeSessionTokenStorage($session);
    $csrfManager = new CsrfTokenManager($csrfGenerator, $csrfStorage);

    $container['form_factory'] = Forms::createFormFactoryBuilder()
        ->addExtension(new HttpFoundationExtension())
        ->addExtension(new CsrfExtension($csrfManager))
        ->getFormFactory();

/* Render HTML forms */

    $container['view']->addExtension(
        new FormExtension(new TwigRenderer($container->form_engine, $csrfManager))
    );

/* Translator */
    // NOTICE: To be edited when translation feature is needed.
    // Removing this snippet shall render the Twig template erroneous

    // create the Translator
    $translator = new Translator('en');
    // add the TranslationExtension (gives us 'trans' and 'transChoice' filters)
    $container->view->addExtension(new TranslationExtension($translator));

/* Needed to render the Menu done by MenuManager */
    
    $container['menu_manager'] = function() use ($container){
            return new \SlimStarter\Menu\MenuManager($container);
    };

    $mainMenu = $container->menu_manager->create('main_sidebar');

        /** The most necessary menu item of the Main Sidebar */
        $dashboard = $mainMenu->createItem('dashboard', array(
            'label' => 'Dashboard',
            'icon'  => 'dashboard',
            'url'   => '/faggot'
        ));

        $mainMenu->addItem('dashboard', $dashboard);
        $mainMenu->setActiveMenu('dashboard');
    
    $container->view->addExtension(new \SlimStarter\TwigExtension\MenuRenderer($container->menu_manager));

    

    

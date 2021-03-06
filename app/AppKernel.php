<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel
{
    public function init()
    {
        date_default_timezone_set( 'Europe/Paris' );
    }

    public function registerBundles()
    {
        $bundles = array(
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Symfony\Bundle\AsseticBundle\AsseticBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Doctrine\Bundle\MongoDBBundle\DoctrineMongoDBBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
            new Braincrafted\Bundle\BootstrapBundle\BraincraftedBootstrapBundle(),
            new Bmatzner\FontAwesomeBundle\BmatznerFontAwesomeBundle(),
            new IsmaAmbrosi\Bundle\GeneratorBundle\IsmaAmbrosiGeneratorBundle(),
            new Pinano\Select2Bundle\PinanoSelect2Bundle(),
            new Stof\DoctrineExtensionsBundle\StofDoctrineExtensionsBundle(),
            new Headoo\HeadooMailjetBundle\HeadooMailjetBundle(),
            new FOS\RestBundle\FOSRestBundle(),
            new JMS\SerializerBundle\JMSSerializerBundle(),
            new Shked0wn\TimelineBundle\TimelineBundle(),
            new Nelmio\ApiDocBundle\NelmioApiDocBundle(),

            new Utils\NotifyMessengerBundle\UtilsNotifyMessengerBundle(),
            new Utils\RatingBundle\UtilsRatingBundle(),

            new Wineot\FrontEnd\HomeBundle\WineotFrontEndHomeBundle(),
            new Wineot\UserBundle\WineotUserBundle(),
            new Wineot\StyleGuideBundle\WineotStyleGuideBundle(),
            new Wineot\DataBundle\WineotDataBundle(),
            new Wineot\FrontEnd\SearchBundle\WineotFrontEndSearchBundle(),
            new Wineot\BackEnd\BackEndBundle\WineotBackEndBackEndBundle(),
            new Wineot\BackEnd\CRUDBundle\WineotBackEndCRUDBundle(),
            new Wineot\FrontEnd\WineBundle\WineotFrontEndWineBundle(),
            new Wineot\FrontEnd\CommentBundle\WineotFrontEndCommentBundle(),
            new Wineot\FrontEnd\WineryBundle\WineotFrontEndWineryBundle(),
            new Wineot\FrontEnd\LandingBundle\WineotFrontEndLandingBundle(),
            new Wineot\RestBundle\WineotRestBundle(),
        );

        if (in_array($this->getEnvironment(), array('dev', 'test'))) {
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
        }

        return $bundles;
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__.'/config/config_'.$this->getEnvironment().'.yml');
    }
}

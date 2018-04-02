<?php

namespace RebelCode\Bookings\WordPress\Module;

use Dhii\Data\Container\ContainerFactoryInterface;
use Dhii\Event\EventFactoryInterface;
use Dhii\Exception\InternalException;
use Dhii\Util\String\StringableInterface as Stringable;
use Psr\Container\ContainerInterface;
use Psr\EventManager\EventManagerInterface;
use RebelCode\Modular\Module\AbstractBaseModule;

/**
 * A module that registers the booking WordPress CPT.
 *
 * @since [*next-version*]
 */
class BookingCptModule extends AbstractBaseModule
{
    /**
     * Constructor.
     *
     * @since [*next-version*]
     *
     * @param string|Stringable              $key              The module key.
     * @param ContainerFactoryInterface|null $containerFactory The container factory, if any.
     * @param EventManagerInterface|null     $eventManager     The event manager, if any.
     * @param EventFactoryInterface|null     $eventFactory     The event factory, if any.
     *
     * @throws InternalException If an error occurred while trying to load the config.
     */
    public function __construct($key, $containerFactory, $eventManager, $eventFactory)
    {
        $this->_initModule($containerFactory, $key, [], $this->_loadPhpConfigFile(RC_WP_BOOKING_CPT_MODULE_CONFIG));
        $this->_initModuleEvents($eventManager, $eventFactory);
    }

    /**
     * {@inheritdoc}
     *
     * @since [*next-version*]
     */
    public function setup()
    {
        return $this->_createContainer();
    }

    /**
     * {@inheritdoc}
     *
     * @since [*next-version*]
     */
    public function run(ContainerInterface $c = null)
    {
        $this->_attach('init', [$this, 'registerCpt']);
        $this->_attach('admin_init', [$this, 'addAdminCapabilities']);
    }

    /**
     * Registers the custom post type.
     *
     * @since [*next-version*]
     */
    public function registerCpt()
    {
        $config = $this->_getConfig();

        register_post_type('booking', $config['booking_cpt_args']);
    }

    /**
     * Grants the admin role the capabilities for bookings.
     *
     * @since [*next-version*]
     */
    function addAdminCapabilities()
    {
        $config = $this->_getConfig();

        foreach ($config['booking_cpt_role_caps'] as $_roleKey => $_capabilities) {
            $_role = get_role($_roleKey);

            foreach ($_capabilities as $_cap) {
                $_role->add_cap($_cap);
            }
        }
    }
}

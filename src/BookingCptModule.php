<?php

namespace RebelCode\Bookings\WordPress\Module;

use Dhii\Data\Container\ContainerFactoryInterface;
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
     * @param ContainerFactoryInterface $containerFactory The container factory.
     */
    public function __construct($containerFactory)
    {
        $this->_initModule($containerFactory, 'booking-cpt', ['wp-events']);
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
        /* @var $eventManager EventManagerInterface */
        $eventManager = $c->get('event-manager');

        $eventManager->attach('init', [$this, 'registerCpt']);
        $eventManager->attach('admin_init', [$this, 'addAdminCapabilities']);
    }

    /**
     * Registers the custom post type.
     *
     * @since [*next-version*]
     */
    public function registerCpt()
    {
        $config = $this->_getConfig();

        register_post_type('booking', $config['booking-cpt-args']);
    }

    /**
     * Grants the admin role the capabilities for bookings.
     *
     * @since [*next-version*]
     */
    function addAdminCapabilities()
    {
        $config = $this->_getConfig();

        foreach ($config['booking-cpt-role-caps'] as $_roleKey => $_capabilities) {
            $_role = get_role($_roleKey);

            foreach ($_capabilities as $_cap) {
                $_role->add_cap($_cap);
            }
        }
    }
}

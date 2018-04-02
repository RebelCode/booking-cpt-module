<?php

use Psr\Container\ContainerInterface;
use RebelCode\Bookings\WordPress\Module\BookingCptModule;

define('RC_WP_BOOKING_CPT_MODULE_DIR', __DIR__);
define('RC_WP_BOOKING_CPT_MODULE_CONFIG', RC_WP_BOOKING_CPT_MODULE_DIR . '/config.php');
define('RC_WP_BOOKING_CPT_MODULE_KEY', 'booking_cpt');

return function(ContainerInterface $c) {
    return new BookingCptModule(
        RC_WP_BOOKING_CPT_MODULE_KEY,
        $c->get('container_factory'),
        $c->get('event_manager'),
        $c->get('event_factory')
    );
};

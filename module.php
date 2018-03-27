<?php

use Psr\Container\ContainerInterface;
use RebelCode\Bookings\WordPress\Module\BookingCptModule;

return function (ContainerInterface $c) {
    return new BookingCptModule($c->get('container-factory'));
};

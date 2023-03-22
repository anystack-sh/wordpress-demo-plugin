<?php
/**
 * @license MIT
 *
 * Modified by Philo Hermans on 21-March-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

if (\PHP_VERSION_ID < 80000 && !interface_exists('ANYSTACK_WP_GUARD_Stringable')) {
    interface ANYSTACK_WP_GUARD_Stringable
    {
        /**
         * @return string
         */
        public function __toString();
    }
}

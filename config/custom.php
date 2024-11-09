<?php
return [
    "ADMIN_DOMAIN" => env("ADMIN_DOMAIN", "sys.localhost"),
    "OTP_LOGIN_EXPIRED_MINUTES" => env("OTP_LOGIN_EXPIRED_MINUTES", 1),
    "PAGINATION_LIMIT" => env("PAGINATION_LIMIT", 10),
];
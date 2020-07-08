<?php

return [
    'task/create' => 'site/create',
    'task/store' => 'site/store',
    'task/update/([0-9]+)' => 'site/update/$1',
    'user/login' => 'user/login',
    'user/logout' => 'user/logout',
    '' => 'site/index',
];
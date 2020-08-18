<?php

return [
    'handlers' => [
        'payByTask' => [
            'comment' => 'Завершение задачи ":title"',
        ],
    ],
    'create'   => [
        'title'  => 'Финансы',
        'thead'  => [
            'member'  => 'Участник',
            'project' => 'Ставка проекта',
            'bet'     => 'Ставка',
        ],
        'bet'    => [
            'placeholder' => '0.00',
            'currency'    => '₽',
        ],
        'submit' => 'Сохранить',
    ],
];

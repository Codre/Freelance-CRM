<?php

return [
    'status_new'      => 'Новая',
    'status_process'  => 'В работе',
    'status_pause'    => 'В ожидание',
    'status_ready'    => 'На проверке',
    'status_finished' => 'Завершена',
    'create'          => [
        'title' => 'Создать задачу',
        'form'  => [
            'title'       => [
                'label'       => 'Тема',
                'placeholder' => 'Кратко опишите задачу',
            ],
            'description' => [
                'label' => 'Описание',
            ],
            'submit'      => 'Создать задачу',
        ],
    ],
    'edit'            => [
        'title' => 'Редактирование задачи',
        'form'  => [
            'title'       => [
                'label'       => 'Тема',
                'placeholder' => 'Кратко опишите задачу',
            ],
            'description' => [
                'label' => 'Описание',
            ],
            'submit'      => 'Сохранить',
        ],
    ],
    'show'            => [
        'change' => 'Редактировать',
        'run' => 'Начать работу над задачей',
        'stop' => 'Завершить работу над задачей',
    ],
    'comments'        => [
        'title' => 'Комментарии',
        'form'  => [
            'text' => [
                'placeholder' => 'Напишите свой комментарий...'
            ],
            'submit' => 'Отправить'
        ],
        'item' => [
            'user' => 'От: ',
        ]
    ],
    'times' => [
        'title' => 'Затраченное время'
    ]
];

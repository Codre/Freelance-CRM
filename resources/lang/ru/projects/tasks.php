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
            'files'       => [
                'label' => 'Прикрепить файлы',
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
        'change'    => 'Редактировать',
        'run'       => 'Начать работу над задачей',
        'stop'      => 'Завершить работу над задачей',
        'ready'     => 'Отправить задачу на проверку',
        'finishing' => 'Завершить задачу',
    ],
    'comments'        => [
        'title' => 'Комментарии',
        'form'  => [
            'text'   => [
                'placeholder' => 'Напишите свой комментарий...',
            ],
            'submit' => 'Отправить',
        ],
        'item'  => [
            'user' => 'От: ',
        ],
    ],
    'times'           => [
        'title' => 'Затраченное время',
    ],
    'files'           => [
        'title' => 'Файлы',
        'thead' => [
            'file' => 'Файл',
            'who'  => 'Загрузил',
            'date' => 'Дата',
        ],
        'item' => [
            'download' => 'Скачать файл',
            'delete' => 'Удалить файл'
        ]
    ],
];

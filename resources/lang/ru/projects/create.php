<?php

return [
  'title' => 'Добавление проекта',
  'form' => [
      'name' => [
          'label' => 'Название проекта',
          'placeholder' => 'Введите название проекта',
      ],
      'validate' => [
          'name' => [
              'required' => 'Название проекта обязательно для заполнения'
          ]
      ]
  ]
];
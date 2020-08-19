<?php

return [
  'title' => 'Редактирование данных сотрудника',
  'form' => [
      'name' => [
          'label' => 'Имя',
          'placeholder' => 'Введите имя',
      ],
      'email' => [
          'label' => 'E-mail',
          'placeholder' => 'Введите e-mail',
      ],
      'group' => [
          'label' => 'Группа',
          'placeholder' => 'Выберите группу',
      ],
      'password' => [
          'label' => 'Новый пароль',
          'placeholder' =>  'Введите новый пароль',
          'old' => [
              'label' => 'Старый пароль',
              'placeholder' => 'Введите старый пароль'
          ],
          'check' => [
              'label' => 'Потор пароля',
              'placeholder' =>  'Введите новый пароль ещё раз',
          ]
      ],
      'submit' => 'Сохранить',
  ]
];

@extends('layouts.app')

@section('content')
<div id="rules">
    <p><small>Редакция от <b>05.03.2018</b></small></p>
    <p>В данном разделе представлены правила работы с сервисом Codre CRM, а также условия оказания услуг компанией Codre development studio.</p>
    <h3 class="text-center">Прайс-лист</h3>
    <table border="1" cellspacing="0" style="margin:0 auto;">
        <thead>
        <tr>
            <th style="padding: 5px">
                Услуга
            </th>
            <th style="padding: 5px">
                Цена
            </th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td style="padding: 5px">
                <b>Разработка/доработка сайтов, CRM-систем, мобильных приложений</b>
            </td>
            <td style="padding: 5px">
                3500р. в час
            </td>
        </tr>
        <tr>
            <td style="padding: 5px">
                <b>Регистрация домена в зоне ru, рф</b>
            </td>
            <td style="padding: 5px">
                700р. в год
            </td>
        </tr>
        <tr>
            <td style="padding: 5px">
                <b>Хостинг 1гб/2гб/5гб</b>
                <br /><small>В стоимость услуги включён ежедневный бэкап</small>
            </td>
            <td style="padding: 5px">
                1500р./2500р./5500р.
            </td>
        </tr>
        <tr>
            <td style="padding: 5px">
                <b>Администрирование VDS -сервера</b>
            </td>
            <td style="padding: 5px">
                От 3500р. в месяц
            </td>
        </tr>
        <tr>
            <td style="padding: 5px">
                <b>Настройка VDS-сервера</b>
            </td>
            <td style="padding: 5px">
                7000р.
            </td>
        </tr>
        <tr>
            <td style="padding: 5px">
                <b>SSL сертификат + установка</b>
            </td>
            <td style="padding: 5px">
                1000р. в год при условии размещения на серверах Codre development studio.<br>2000р. в год при размещении на иных серверах
            </td>
        </tr>
        <tr>
            <td style="padding: 5px">
                <b>Ежедневный бэкап сайта</b>
            </td>
            <td style="padding: 5px">
                8р./Гб/месяц
            </td>
        </tr>
        <tr>
            <td style="padding: 5px">
                <b>Настройка антивируса</b>
            </td>
            <td style="padding: 5px">
                1500р.
            </td>
        </tr>
        <tr>
            <td style="padding: 5px">
                <b>Отслеживание и удаление вредоносных скриптов</b>
            </td>
            <td style="padding: 5px">
                1500р./месяц
            </td>
        </tr>
        <tr>
            <td style="padding: 5px">
                <b>Мониторинг и исправление ошибок php и mysql</b>
            </td>
            <td style="padding: 5px">
                7000р./месяц
            </td>
        </tr>
        <tr>
            <td style="padding: 5px">
                <b>Восстановление резервной копии</b>
            </td>
            <td style="padding: 5px">
                500р.
            </td>
        </tr>
        </tbody>
    </table>
    <p><br></p>
    <p>Codre development studio предоставляет клиентам два метода расчёта оплаты на работы по разработке и доработке сайтов.</p>
    <h3 class="text-center">1 метод – работа по договору.</h3>
    <p>В данном методе клиент предоставляет полное техническое задание на требуемые работы, после оценки клиенту предоставляется расчёт стоимости и сроки реализации тех. задания, договор и счета.</p>
    <p>В случае невозможности составления технического задания, стоимость его составления будет включена в договор.</p>
    <p>После утверждения технического задания и расчёта стоимости, клиенту необходимо внести предоплату в размере 50% и более. Срок начала работ считается от даты поступления предоплаты.</p>
    <p>В случае обнаружения недоработок или технических ошибок после сдачи проекта, они устраняются за счёт исполнителя.</p>
    <p>В случае изменения тех. задания во время работы, стоимость работ увеличивается на сумму дополнительных работ + 10% от их стоимости.</p>
    <h3 class="text-center">2 метод – оплата по факту.</h3>
    <p>В данном методе клиент оплачивает работу по факту выполнения всей работы или её части. Техническое задание в данном методе не обязательно. Клиент может управлять процессом разработки или вносить коррективы в задачи во время разработки. Оплата происходит по желанию клиента, либо до начала работ, либо во время, либо после, любыми долями и способами, удобными для клиента.</p>
    <p>Для контроля долга, у каждого клиента есть персональный баланс в Codre CRM, а также кредитный лимит. Кредитный лимит – это максимальная сумма долга, которая допускается для клиента, данная сумма формируется ответственным за клиента менеджером, в зависимости от его платёжеспособности, своевременности оплаты, срока сотрудничества и др. факторов. В случае достижения долгом кредитного лимита или его превышения, работы по проектам клиента приостанавливаются до погашения минимум 50% долга.</p>
    <p>После завершения проекта клиент обязан выплатить долг в течение 10 рабочих дней, в противном случае на него будут наложены пени в размере 0.5 процента от задолженности в день.</p>
    <h3 class="text-center">Базовые ставки:</h3>
    <table border="1" cellspacing="0" style="margin:0 auto;">
        <thead>
        <tr>
            <th style="padding: 5px">
                Услуга
            </th>
            <th style="padding: 5px">
                Ставка
            </th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td style="padding: 5px">
                <b>Разработка/доработка сайтов, разработанных на Codre CMS или JR CMS,<br />вёрстка макетов, адаптация шаблонов для Codre CMS или JR CMS</b>
            </td>
            <td style="padding: 5px">
                2500р. в час
            </td>
        </tr>
        <tr>
            <td style="padding: 5px">
                <b>Разработка/доработка CRM или других сервисов, разработанных на Codre CMF</b>
            </td>
            <td style="padding: 5px">
                2500р. в час
            </td>
        </tr>
        <tr>
            <td style="padding: 5px">
                <b>Разработка/доработка сайтов на Битрикс CMS</b>
            </td>
            <td style="padding: 5px">
                4000р. в час
                <br /><small>При данной ставке с клиента не взимается комиссия за перевод на безналичный счёт.</small>
            </td>
        </tr>
        <tr>
            <td style="padding: 5px">
                <b>Разработка/доработка сайтов на других CMS</b>
            </td>
            <td style="padding: 5px">
                3500р. в час
                <br /><small>При данной ставке с клиента не взимается комиссия за перевод на безналичный счёт.</small>
            </td>
        </tr>
        </tbody>
    </table>
    <p>Ставка может меняться в меньшую сторону в зависимости от квалификации сотрудника, скидки или других факторов.</p>
    <p>В случае необходимости выполнения срочных работ, их стоимость рассчитывается по двойной ставке.</p>
    <p>В данном методе все найденные ошибки или недоработки устраняются за счёт заказчика.</p>
    <p>Преимущества метода 2:</p>
    <ol>
        <li>В отличие от работы по договору, клиенту не нужно готовить ТЗ. Он может менять направление работ в любой момент и вносить необходимые коррективы.</li>
        <li>Клиенту не нужно вносить предоплату.</li>
        <li>Клиент не платит за услуги оформления договора, технической документации, риски, контроль проекта, тестирования и другие дополнительные платежи, оплата идёт только за работу и только по факту.</li>
    </ol>
    <p>Дополнительные условия читайте в <a href="{{ route('info.offer', $requestParams) }}">договоре оферты</a>.</p>
</div>
@endsection

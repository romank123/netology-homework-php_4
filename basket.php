<?php
declare(strict_types=1);

const OPERATION_EXIT = 0;
const OPERATION_ADD = 1;
const OPERATION_DELETE = 2;
const OPERATION_PRINT = 3;

/**
 * Отображает список покупок на экран
 *
 * @param array $items Текущий список покупок
 * @return void
 */
function displayShoppingList(array $items): void
{
    system('clear');
    // system('cls'); // для Windows

    if (count($items)) {
        echo 'Ваш список покупок: ' . PHP_EOL;
        echo implode(PHP_EOL, $items) . PHP_EOL;
    } else {
        echo 'Ваш список покупок пуст.' . PHP_EOL;
    }
}

/**
 * Выводит список доступных операций и запрашивает у пользователя выбор операции
 *
 * @param array $operations Список доступных операций
 * @param array $items Текущий список покупок
 * @return int Выбранная операция
 */
function getOperation(array $operations, array $items): int
{
    do {
        displayShoppingList($items);

        echo 'Выберите операцию для выполнения: ' . PHP_EOL;
        echo implode(PHP_EOL, $operations) . PHP_EOL . '> ';
        $operationNumber = (int) trim(fgets(STDIN));

        if (!array_key_exists($operationNumber, $operations)) {
            system('clear');
            echo '!!! Неизвестный номер операции, повторите попытку.' . PHP_EOL;
        }
    } while (!array_key_exists($operationNumber, $operations));

    return $operationNumber;
}

/**
 * Добавляет товар в список покупок
 *
 * @param array $items Текущий список покупок
 * @return array Обновленный список покупок
 */
function addItem(array $items): array
{
    echo "Введение название товара для добавления в список: \n> ";
    $itemName = trim(fgets(STDIN));
    $items[] = $itemName;
    return $items;
}

/**
 * Удаляет товар из списка покупок
 *
 * @param array $items Текущий список покупок
 * @return array Обновленный список покупок
 */
function deleteItem(array $items): array
{
    if (empty($items)) {
        echo 'Список покупок пуст. Нечего удалять.' . PHP_EOL;
        echo 'Нажмите enter для продолжения';
        fgets(STDIN);
        return $items;
    }

    echo 'Текущий список покупок:' . PHP_EOL;
    echo implode(PHP_EOL, $items) . PHP_EOL;

    echo 'Введение название товара для удаления из списка:' . PHP_EOL . '> ';
    $itemName = trim(fgets(STDIN));

    if (in_array($itemName, $items, true) !== false) {
        while (($key = array_search($itemName, $items, true)) !== false) {
            unset($items[$key]);
        }
        // Переиндексируем массив после удаления элементов
        $items = array_values($items);
    }

    return $items;
}

/**
 * Отображает подробную информацию о списке покупок
 *
 * @param array $items Текущий список покупок
 * @return void
 */
function printShoppingList(array $items): void
{
    echo 'Ваш список покупок: ' . PHP_EOL;
    if (empty($items)) {
        echo 'Список покупок пуст.' . PHP_EOL;
    } else {
        echo implode(PHP_EOL, $items) . PHP_EOL;
        echo 'Всего ' . count($items) . ' позиций. '. PHP_EOL;
    }

    echo 'Нажмите enter для продолжения';
    fgets(STDIN);
}

// Инициализация переменных
$operations = [
    OPERATION_EXIT => OPERATION_EXIT . '. Завершить программу.',
    OPERATION_ADD => OPERATION_ADD . '. Добавить товар в список покупок.',
    OPERATION_DELETE => OPERATION_DELETE . '. Удалить товар из списка покупок.',
    OPERATION_PRINT => OPERATION_PRINT . '. Отобразить список покупок.',
];

$items = [];

do {
    $operationNumber = getOperation($operations, $items);

    echo 'Выбрана операция: '  . $operations[$operationNumber] . PHP_EOL;

    switch ($operationNumber) {
        case OPERATION_ADD:
            $items = addItem($items);
            break;

        case OPERATION_DELETE:
            $items = deleteItem($items);
            break;

        case OPERATION_PRINT:
            printShoppingList($items);
            break;
    }

    echo "\n ----- \n";
} while ($operationNumber > 0);

echo 'Программа завершена' . PHP_EOL;
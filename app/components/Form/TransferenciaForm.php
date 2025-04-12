<?php
namespace App\Components\Form;

abstract class TransferForm extends BaseForm {
    protected static function createLocationOptions(): array {
        return [
            'sectors' => array_combine(range('A', 'H'), range('A', 'H')),
            'floors' => array_combine(range(1, 5), range(1, 5)),
            'positions' => array_combine(range(1, 12), range(1, 12))
        ];
    }

    protected static function validateLocation(array $location): bool {
        $sectors = range('A', 'H');
        $floors = range(1, 5);
        $positions = range(1, 12);

        return in_array($location['sector'], $sectors) &&
               in_array($location['floor'], $floors) &&
               in_array($location['position'], $positions);
    }

    abstract public static function render(string $action, array $params = []): string;
}
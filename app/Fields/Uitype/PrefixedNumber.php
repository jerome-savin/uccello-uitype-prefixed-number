<?php

namespace JeromeSavin\UccelloUitypePrefixedNumber\Fields\Uitype;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Fluent;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Uccello\Core\Contracts\Field\Uitype;
use Uccello\Core\Fields\Traits\DefaultUitype;
use Uccello\Core\Fields\Traits\UccelloUitype;
use Uccello\Core\Models\Field;
use Uccello\Core\Models\Domain;
use Uccello\Core\Models\Module;

class PrefixedNumber implements Uitype
{
    use DefaultUitype;

    public $package = 'uccello-uitype-prefixed-number';

    /**
     * Returns field type used by Form builder.
     *
     * @return string
     */
    public function getFormType() : string
    {
        return 'number';
    }

    /**
     * Returns options for Form builder.
     *
     * @param mixed $record
     * @param \Uccello\Core\Models\Field $field
     * @param \Uccello\Core\Models\Domain $domain
     * @param \Uccello\Core\Models\Module $module
     * @return array
     */
    public function getFormOptions($record, Field $field, Domain $domain, Module $module) : array
    {
        $class = 'form-control';
        if($field->data->prefix ?? false)
            $class.=' jsdev_input_prefixed';
        if($field->data->suffix ?? false)
            $class.=' jsdev_input_suffixed';
        return [
            'attr' => [
                'min' => $field->data->min ?? null,
                'max' => $field->data->max ?? null,
                'precision' => $field->data->precision ?? 2,
                'step' => $field->data->step ?? 0.01,
                'autocomplete' => 'off',
                'class' => $class
            ],
            'default_value' => request($field->name) ?? $field->data->default ?? 0,
        ];
    }

    /**
     * Return options for Module Designer
     *
     * @return array
     */
    public function getFieldOptions() : array
    {
        return [
            'min' => [
                'type' => 'float',
                'default_value' => null,
            ],
            'max' => [
                'type' => 'float',
                'default_value' => null,
            ],
            'step' => [
                'mandatory' => true,
                'type' => 'float',
                'default_value' => 0.01,
            ],
            'precision' => [
                'mandatory' => true,
                'type' => 'float',
                'default_value' => 2,
            ],
            'prefix' => [
                'type'  => 'string',
                'max'   => '5',
            ],
            'suffix' => [
                'type'  => 'string',
                'max'   => '5',
            ]
        ];
    }

    /**
     * Ask the user some specific options relative to a field
     *
     * @param \StdClass $module
     * @param \StdClass $field
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Input\OutputInterface $output
     * @return void
     */
    public function askFieldOptions(\StdClass &$module, \StdClass &$field, InputInterface $input, OutputInterface $output)
    {
        // Minimum value
        $field->data->min = $output->ask('What is the minimum value?');

        // Maximum value
        $field->data->max = $output->ask('What is the maximum value?');

        // Increment
        $field->data->step = (int)$output->ask('What is the increment?', 0.01);

        // Precision
        $field->data->precision = $output->ask('What is the precision? (e.g: Type 2 for having 0.01)', 2);

        // Prefix
        $field->data->prefix = $output->ask('What is the prefix? (5 chars max.)');

        // Suffix
        $field->data->suffix = $output->ask('What is the suffix? (5 chars max.)');
    }

    /**
     * Create field column in the module table
     *
     * @param \Uccello\Core\Models\Field $field
     * @param \Illuminate\Database\Schema\Blueprint $table
     * @return \Illuminate\Support\Fluent
     */
    public function createFieldColumn(Field $field, Blueprint $table) : Fluent
    {
        $leftPartLength = !empty($field->data->max) ? strlen($field->data->max) : 11;
        $rightPartLength = isset($field->data->precision) && $field->data->precision > 2 ? $field->data->precision : 2; // At leat 2
        $totalLength = $leftPartLength + $rightPartLength;

        return $table->decimal($this->getDefaultDatabaseColumn($field, $totalLength, $rightPartLength));
    }

    /**
     * Get field column creation in string format (for make:module)
     *
     * @param \Uccello\Core\Models\Field $field
     * @return string
     */
    public function createFieldColumnStr(Field $field) : string
    {
        $leftPartLength = !empty($field->data->max) ? strlen($field->data->max) : 11;
        $rightPartLength = isset($field->data->precision) && $field->data->precision > 2 ? $field->data->precision : 2; // At least 2
        $totalLength = $leftPartLength + $rightPartLength;

        $column = $this->getDefaultDatabaseColumn($field);
        return "\$table->decimal('$column', $totalLength, $rightPartLength)";
    }
}
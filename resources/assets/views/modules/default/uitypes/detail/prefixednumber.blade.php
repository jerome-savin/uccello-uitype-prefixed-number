<?php $isLarge = $forceLarge ?? $field->data->large ?? false; ?>
<div class="col m2 s5 field-label">
    <?php $label = uctrans($field->label, $module); ?>
    <b title="{{ $label }}">{{ $label }}</b>
</div>
<div class="col {{ $isLarge ? 's7 m10' : 's7 m4' }}">
    <?php
        $value = '';
        if($field->data->prefix ?? false)
            $value.=$field->data->prefix;
        $value = uitype($field->uitype_id)->getFormattedValueToDisplay($field, $record);
        if($field->data->suffix ?? false)
            $value.=$field->data->suffix;
    ?>
    @if ($value)
        <div class="truncate">
            {{ $value }}
        </div>
    @else
        &nbsp;
    @endif
</div>
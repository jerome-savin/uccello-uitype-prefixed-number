<?php $isLarge = $field->data->large ?? false; ?>
<?php $isError = form_errors($form->{$field->name}) ?? false; ?>

@section('css')
    {{ Html::style(mix('css/app.css', 'vendor/jerome-savin/uccello-uitype-prefixed-number')) }}
@append

<div class="col {{ $isLarge ? 's12' : 's12 m6' }} input-field @if($isError)invalid @endif">

    {{-- Add icon if defined --}}

    @if($field->data->prefix ?? false)
    <i class="jsdev_prefix">{{ $field->data->prefix }}</i>
    @endif
    {!! form_label($form->{$field->name}) !!}
    {!! form_widget($form->{$field->name}) !!}
    @if($field->data->suffix ?? false)
    <i class="suffix"> {{ $field->data->suffix }}</i>
    @endif


    @if ($isError)
        <span class="helper-text red-text">
            {{-- if it is a repeated field display only the first error --}}
            @if($field->data->repeated ?? false)
            {!! form_errors($form->{$field->name}->first) !!}
            @else
            {{-- else display the error normally --}}
            {!! form_errors($form->{$field->name}) !!}
            @endif
        </span>
    {{-- Add help info if defined --}}
    @elseif ($field->data->info ?? false)
        <span class="helper-text">
            {{ uctrans($field->data->info, $module) }}
        </span>
    @endif
</div>
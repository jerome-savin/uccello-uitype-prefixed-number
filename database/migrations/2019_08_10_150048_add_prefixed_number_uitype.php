<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Uccello\Core\Models\Uitype;

class AddPrefixedNumberUitype extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $uitype = new Uitype();
        $uitype->name = 'prefixed_number';
        $uitype->class = 'JeromeSavin\UccelloUitypePrefixedNumber\PrefixedNumber';
        $uitype->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $uitype = Uitype::where('name', 'prefixed_number')->first();
        $uitype->delete();
    }
}

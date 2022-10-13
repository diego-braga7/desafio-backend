<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('venda', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('pdv_id')->unsigned();
            $table->foreign('pdv_id')
                ->references('id')
                ->on('pdv')
                ->onUpdate('cascade');
            $table->float('valor');
            $table->enum('status', ['AGUARDANDO_PAGAMENTO', 'PAGO', 'CANCELADO'])->default('AGUARDANDO_PAGAMENTO');
            $table->boolean('quitado')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('venda');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
            Schema::create('webhook_data', function (Blueprint $table) {
                $table->id();
                $table->string('timestamp');
                $table->string('token');
                $table->string('signature');
                $table->string('mover_id');
                $table->string('name');
                $table->string('email');
                $table->string('telephone');
                $table->date('estimated_move_date');
                $table->decimal('charge', 8, 2);
                $table->string('charge_status');
                $table->integer('rank');
                $table->text('comments');
                $table->string('transaction');
                $table->decimal('quote_discount', 8, 2);
                $table->decimal('quote_vat', 8, 2);
                $table->decimal('quote_total', 8, 2);
                $table->string('sale_post_district');
                $table->text('sale_address');
                $table->decimal('sale_value', 15, 2);
                $table->string('sale_type');
                $table->boolean('sale_is_shared_ownership');
                $table->boolean('sale_has_mortgage');
                $table->boolean('sale_is_flat')->nullable();
                $table->boolean('sale_is_help_to_buy_shared_ownership')->nullable();
                $table->decimal('quote_sale_fees', 8, 2);
                $table->json('quote_sale_fees_breakdown');
                $table->decimal('quote_sale_disbursements', 8, 2);
                $table->json('quote_sale_disbursements_breakdown');
                $table->decimal('quote_sale_total', 8, 2);
                $table->json('headers');
                $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('webhook_data');
    }
};

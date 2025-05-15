<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('advertiser_id')->constrained('users')->onDelete('cascade');
            $table->string('name');
            $table->decimal('cost_per_click', 8, 4);
            $table->text('target_url');
            $table->enum('status', ['active', 'paused', 'inactive'])->default('active');
            $table->json('topics')->nullable();
            $table->timestamps();
        });

        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('offer_id')->constrained('offers')->onDelete('cascade');
            $table->foreignId('webmaster_id')->constrained('users')->onDelete('cascade');
            $table->decimal('custom_cpc', 8, 4);
            $table->string('custom_url')->unique();
            $table->boolean('active')->default(true);
            $table->timestamps();
        });

        Schema::create('click_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subscription_id')->constrained('subscriptions')->onDelete('cascade');
            $table->timestamp('clicked_at')->useCurrent();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('click_logs');
        Schema::dropIfExists('subscriptions');
        Schema::dropIfExists('offers');
        Schema::dropIfExists('users');
    }
};

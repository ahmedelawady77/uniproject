<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductImagesTable extends Migration
{
/**
* Run the migrations.
*
* @return void
*/
public function up()
{
Schema::create('product_images', function (Blueprint $table) {
$table->id();
$table->string('file_name');
$table->string('product_name');
$table->string('created_by')->nullable();
$table->foreignId('product_id')->references('id')->on('products')->onDelete('cascade');
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
       Schema::dropIfExists('product_images');
   }
}
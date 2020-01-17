<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
		
		// Insert data
		DB::table('admins')->insert(
			array(
				'name' => 'Owner678',
				'username' => 'franchise2',
				'email' => 'admin@psof.com',
				'password' => '$2y$10$yFmEPdYU2IZEeCd492.TsuXDZG781qeRgZwgv5z7uZh5U3i.myS2a',
			)
		);
		
		DB::table('admins')->insert(
			array(
				'name' => 'Damir',
				'username' => 'damir2912',
				'email' => 'damir.ibra.986@gmail.com',
				'password' => '$2y$10$7XBreL3HrQwOZug3wszsN.zdQgoLF2HiyvDXoOZmNcr01ytypurIS',
			)
		);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admins');
    }
}

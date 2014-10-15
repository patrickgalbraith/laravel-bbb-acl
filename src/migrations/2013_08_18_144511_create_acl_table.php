<?php

use Illuminate\Database\Migrations\Migration;

class CreateAclTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('acl', function($table)
        {
            $table->integer('user_id')->unsigned();
            $table->integer('subject_id')->unsigned();
            $table->string('subject_type');
            $table->integer('permission')->unsigned();
            
            $table->index('user_id');
            $table->index('subject_id');
            $table->index('subject_type');
            $table->index('permission');
            $table->unique(array('user_id', 'subject_id', 'subject_type', 'permission'));
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('acl');
	}
}
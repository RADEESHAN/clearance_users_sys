<?php

 function up()
{
    Schema::table('_m_a', function (Blueprint $table) {
        $table->string('Clearance_No')->nullable();
        $table->string('Student_Reg_No')->nullable();
    });
}
function down()
{
    Schema::table('_m_a', function (Blueprint $table) {
        $table->dropColumn('Clearance_No');
        $table->dropColumn('Student_Reg_No');
    });
}


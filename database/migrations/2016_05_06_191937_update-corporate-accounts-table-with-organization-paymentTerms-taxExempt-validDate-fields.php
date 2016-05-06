<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateCorporateAccountsTableWithOrganizationPaymentTermsTaxExemptValidDateFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('corporate_accounts', function (Blueprint $table) {
            $table->string('organization')->after('account');
            $table->string('paymentTerms')->after('notes');
            $table->boolean('taxExempt')->after('profileID');
            $table->date('validOn')->after('profileID');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('corporate_accounts', function (Blueprint $table) {
            $table->dropColumn('organization');
            $table->dropColumn('paymentTerms');
            $table->dropColumn('taxExempty');
            $table->dropColumn('validOn');
        });
    }
}

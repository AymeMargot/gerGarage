<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateRostersViews extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
      CREATE VIEW rosters_views AS
      (
        select rosters.*,
bookings.id as book_id,
bookings.`date` as book_date,
bookings.description as book_description,
bookings.diagnosis as book_diagnostic,
bookings.roster_id as book_roster,
bookings.status as book_status,
bookings.vehicle_id as book_vehicle,
vehicles.brand as vehicle_brand,
vehicles.engine as vehicle_engine,
vehicles.id as vehicle_id,
vehicles.license as vehicle_license,
vehicles.name as vehicle_name,
vehicles.vehicleType as vehicle_type_id,
vehicle_types.name as vehicle_type_name,
brands.name as brand_name,
engines.name as engine_name,
users.name as customer,
users.phonenumber as customer_phone,
users.email as customer_email,
concat(staff.name,'  ',staff.lastname) as staff

from rosters
left join staff on rosters.staff_id = staff.id
left join  bookings on  rosters.id = bookings.roster_id
left join users on bookings.user_id = users.id
left join vehicles on bookings.vehicle_id = vehicles.id 
left join  vehicle_types  on vehicle_types.id = vehicles.vehicleType
left join engines on vehicles.engine = engines.id
left join brands on vehicles.brand = brands.id

      )
    ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {    
        DB::statement("DROP VIEW rosters_views");
    }
}

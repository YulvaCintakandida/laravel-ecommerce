<?php
// database/seeders/MembershipPlanSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MembershipPlan;

class MembershipPlanSeeder extends Seeder
{
    public function run()
    {
        MembershipPlan::create([
            'name' => 'VIP Monthly',
            'description' => 'Access to exclusive VIP benefits for 1 month',
            'price' => 50000.00,
            'duration_months' => 1,
            'is_active' => true,
        ]);
        
        MembershipPlan::create([
            'name' => 'VIP Quarterly',
            'description' => 'Access to exclusive VIP benefits for 3 months',
            'price' => 120000.00,
            'duration_months' => 3,
            'is_active' => true,
        ]);
    }
}
<?php
// app/Console/Commands/CheckMembershipExpiration.php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Carbon\Carbon;

class CheckMembershipExpiration extends Command
{
    protected $signature = 'membership:check-expiration';
    protected $description = 'Check and update expired VIP memberships';

    public function handle()
    {
        $expiredUsers = User::where('membership_type', 'vip')
            ->where('membership_expires_at', '<', Carbon::now())
            ->get();
            
        foreach ($expiredUsers as $user) {
            $user->update([
                'membership_type' => 'regular',
            ]);
            
            $this->info("User #{$user->id} {$user->name} membership expired and reverted to regular");
        }
        
        $this->info("Processed {$expiredUsers->count()} expired memberships");
        return 0;
    }
}
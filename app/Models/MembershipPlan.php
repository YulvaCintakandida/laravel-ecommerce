<?php
// app/Models/MembershipPlan.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MembershipPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'duration_months',
        'is_active',
    ];

    public function transactions()
    {
        return $this->hasMany(MembershipTransaction::class);
    }
}
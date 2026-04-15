<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
// use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'email_verified_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function getRoleBadgeAttribute()
    {
        $badges = [
            'admin'       => ['class' => 'bg-purple-100 text-purple-800', 'icon' => 'crown'],
            'cashier'     => ['class' => 'bg-green-100 text-green-800', 'icon' => 'money-bill-wave'],
            'technician'  => ['class' => 'bg-yellow-100 text-yellow-800', 'icon' => 'wrench'],
            'marketing'   => ['class' => 'bg-pink-100 text-pink-800', 'icon' => 'chart-line'],
            'finance'     => ['class' => 'bg-blue-100 text-blue-800', 'icon' => 'coins'],
            'hr/accounts' => ['class' => 'bg-indigo-100 text-indigo-800', 'icon' => 'users'],
        ];

        $role = $this->role;
        $badge = $badges[$role] ?? ['class' => 'bg-gray-100 text-gray-800', 'icon' => 'user'];

        return "<span class=\"px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {$badge['class']}\">
                    <i class=\"fas fa-{$badge['icon']} mr-1\"></i>{$role}
                </span>";
    }

    //  // Helper method to check if user is admin
    // public function isAdmin()
    // {
    //     return $this->role === 'admin';
    // }
    
    // // Helper method to check if user is staff
    // public function isStaff()
    // {
    //     return $this->role === 'staff';
    // }
}

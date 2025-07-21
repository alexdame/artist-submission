<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // Add this line
    ];

    public function payments()
{
    return $this->hasMany(Payment::class);
}

public function hasActivePlan()
{
    return $this->payments()->where('status', 'success')->where('plan_expires_at', '>', now())->exists();
}

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
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

    // New: Helper method to check if the user is an admin
     public function isAdmin()
    {
        // Adjust this logic based on how you identify admins.
        // If you have an 'is_admin' boolean column:
        // return $this->is_admin;

        // If you have a 'role' column:
        // return $this->role === 'admin';

        // For now, if you're using a hardcoded email (for dev convenience):
        return $this->email === 'admin@example.com'; // Replace with your actual admin email
    }

    public function plan()
{
    return $this->belongsTo(Plan::class);
}
}
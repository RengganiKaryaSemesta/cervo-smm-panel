<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles, SoftDeletes, \App\Models\Concern\Auditable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        "name",
        "email",
        "username",
        "phone",
        "otp",
        "otp_verified_at",
        "otp_expired_at",
        "password",
    ];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        "password",
        "remember_token",
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts() : array
    {
        return [
            "email_verified_at" => "datetime",
            "password"          => "hashed",
            "otp_verified_at"   => "datetime",
            "otp_expired_at"    => "datetime",
        ];
    }
    public function scopeSearch($query, $keyword)
    {
        return $query->where(
            "name",
            "LIKE",
            "%" . $keyword . "%")
            ->orWhere(
                "email",
                "LIKE",
                "%" . $keyword . "%")
            ->orWhere(
                "phone",
                "LIKE",
                "%" . $keyword . "%")
            ->orWhere(
                "username",
                "LIKE",
                "%" . $keyword . "%");
    }
    public function scopeCustomFilters(Builder $query, array $filters)
    {
        return $query->when(
            $filters["filters_by_deleted"],
            function ($query) use ($filters) {
                return $filters["filters_by_deleted"] == "deleted"
                    ? $query->whereNotNull("deleted_at")
                    : $query->whereNull("deleted_at");
            })
            ->when(
                isset($filters["filters_by_roles"]) && $filters["filters_by_roles"],
                function ($query) use ($filters) {
                    return $query->whereHas(
                        "roles",
                        function ($query) use ($filters) {
                            $query->where(
                                "id",
                                $filters["filters_by_roles"]);
                        });
                });
    }
}

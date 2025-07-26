<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $table = 'ticket';

    protected $fillable = [
        'user_id',
        'movie_id',
        'jam_tayang',
        'kursi_dipilih',
        'total',
    ];

    protected $casts = [
        'kursi_dipilih' => 'array', // Otomatis convert JSON ke array dan sebaliknya
        'total' => 'decimal:2',
        'jam_tayang' => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function movie()
    {
        return $this->belongsTo(Movie::class);
    }

    public function getJumlahTiketAttribute()
    {
        return is_array($this->kursi_dipilih) ? count($this->kursi_dipilih) : 0;
    }

    public function getKursiStringAttribute()
    {
        return is_array($this->kursi_dipilih) ? implode(', ', $this->kursi_dipilih) : '';
    }

    public function getTotalFormattedAttribute()
    {
        return 'Rp ' . number_format($this->attributes['total'], 0, ',', '.');
    }
    public function scopeForMovieAndTime($query, $movieId, $jamTayang)
    {
        return $query->where('movie_id', $movieId)
                    ->where('jam_tayang', $jamTayang);
    }

    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }
}
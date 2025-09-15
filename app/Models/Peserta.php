<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Pesertum
 *
 * @property string $id
 * @property string|null $nama
 * @property string|null $kodejk
 * @property Carbon|null $tgl_lahir
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Collection|CourseDetail[] $course_details
 *
 * @package App\Models
 */
class Peserta extends Model
{
    protected $table = 'peserta';
    public $incrementing = false;

    protected $casts = [
        'tgl_lahir' => 'datetime'
    ];

    protected $fillable = [
        'id',
        'nama',
        'kodejk',
        'tgl_lahir'
    ];

    public function course_details()
    {
        return $this->hasMany(CourseDetail::class, 'peserta_id');
    }
}

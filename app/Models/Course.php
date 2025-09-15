<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Course
 *
 * @property string $id
 * @property string|null $judul
 * @property string|null $deskripsi
 * @property bool|null $is_active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Collection|CourseDetail[] $course_details
 * @property Collection|Modul[] $moduls
 *
 * @package App\Models
 */
class Course extends Model
{
    use HasUlids;

    protected $table = 'courses';
    public $incrementing = false;

    protected $casts = [
        'is_active' => 'bool'
    ];

    protected $fillable = [
        'judul',
        'deskripsi',
        'is_active'
    ];

    public function course_details()
    {
        return $this->hasMany(CourseDetail::class);
    }

    public function moduls()
    {
        return $this->hasMany(Modul::class);
    }
}

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
 * Class Modul
 *
 * @property string $id
 * @property string|null $course_id
 * @property string|null $judul
 * @property string|null $deskripsi
 * @property int|null $urutan
 * @property bool|null $is_active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Course|null $course
 * @property Collection|ModulDetail[] $modul_details
 *
 * @package App\Models
 */
class Modul extends Model
{
    use HasUlids;

    protected $table = 'modul';
    public $incrementing = false;

    protected $casts = [
        'urutan' => 'int',
        'is_active' => 'bool'
    ];

    protected $fillable = [
        'course_id',
        'judul',
        'deskripsi',
        'urutan',
        'is_active'
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function modul_details()
    {
        return $this->hasMany(ModulDetail::class);
    }
}

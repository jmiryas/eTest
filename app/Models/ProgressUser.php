<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ProgressUser
 *
 * @property string $id
 * @property string|null $peserta_id
 * @property int|null $corrector_id
 * @property string|null $course_id
 * @property string|null $modul_id
 * @property string|null $section_id
 * @property string|null $section_type
 * @property Carbon|null $waktu_submit
 * @property Carbon|null $waktu_koreksi
 * @property bool|null $is_corrected
 * @property float|null $score
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Course|null $course
 * @property ModulDetail|null $modul_detail
 * @property Modul|null $modul
 * @property Pesertum|null $pesertum
 * @property User|null $user
 *
 * @package App\Models
 */
class ProgressUser extends Model
{
    use HasUlids;

    protected $table = 'progress_user';
    public $incrementing = false;

    protected $casts = [
        'corrector_id' => 'int',
        'waktu_submit' => 'datetime',
        'waktu_koreksi' => 'datetime',
        'is_corrected' => 'bool',
        'score' => 'float'
    ];

    protected $fillable = [
        'peserta_id',
        'corrector_id',
        'course_id',
        'modul_id',
        'section_id',
        'section_type',
        'waktu_submit',
        'waktu_koreksi',
        'is_corrected',
        'score'
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function modul_detail()
    {
        return $this->belongsTo(ModulDetail::class, 'section_id');
    }

    public function modul()
    {
        return $this->belongsTo(Modul::class);
    }

    public function peserta()
    {
        return $this->belongsTo(Peserta::class, 'peserta_id');
    }

    public function corrector()
    {
        return $this->belongsTo(User::class, 'corrector_id');
    }
}

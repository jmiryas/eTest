<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CourseDetail
 *
 * @property string $id
 * @property string|null $course_id
 * @property string|null $peserta_id
 * @property int|null $enrolled_by
 * @property Carbon|null $enrolled_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Course|null $course
 * @property Pesertum|null $pesertum
 * @property User|null $user
 *
 * @package App\Models
 */
class CourseDetail extends Model
{
    use HasUlids;

    protected $table = 'course_detail';
    public $incrementing = false;

    protected $casts = [
        'enrolled_by' => 'int',
        'enrolled_at' => 'datetime'
    ];

    protected $fillable = [
        'course_id',
        'peserta_id',
        'enrolled_by',
        'enrolled_at'
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function peserta()
    {
        return $this->belongsTo(Peserta::class, 'peserta_id');
    }

    public function enroller()
    {
        return $this->belongsTo(User::class, 'enrolled_by');
    }
}

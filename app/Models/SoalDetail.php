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
 * Class SoalDetail
 *
 * @property string $id
 * @property string|null $soal_id
 * @property string|null $label
 * @property string|null $konten
 * @property bool|null $is_correct
 * @property int|null $urutan
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Soal|null $soal
 * @property Collection|UserAnswer[] $user_answers
 *
 * @package App\Models
 */
class SoalDetail extends Model
{
    use HasUlids;

    protected $table = 'soal_detail';
    public $incrementing = false;

    protected $casts = [
        'is_correct' => 'bool',
        'urutan' => 'int'
    ];

    protected $fillable = [
        'soal_id',
        'label',
        'isi',
        'is_correct',
        'urutan'
    ];

    public function soal()
    {
        return $this->belongsTo(Soal::class);
    }

    public function user_answers()
    {
        return $this->hasMany(UserAnswer::class);
    }
}

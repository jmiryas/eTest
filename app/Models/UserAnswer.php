<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;

/**
 * Class UserAnswer
 *
 * @property string $id
 * @property string|null $peserta_id
 * @property string|null $soal_id
 * @property int|null $corrector_id
 * @property string|null $soal_tipe
 * @property string|null $soal_text
 * @property string|null $answer_label
 * @property string|null $answer_text
 * @property bool|null $is_correct
 * @property int|null $score
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Pesertum|null $pesertum
 * @property Soal|null $soal
 * @property User|null $user
 *
 * @package App\Models
 */
class UserAnswer extends Model
{
    use HasUlids;

    protected $table = 'user_answer';
    public $incrementing = false;

    protected $casts = [
        'corrector_id' => 'int',
        'is_correct' => 'bool',
        'score' => 'int'
    ];

    protected $fillable = [
        'modul_detail_id',
        'peserta_id',
        'soal_id',
        'corrector_id',
        'soal_tipe',
        'soal_text',
        'answer_label',
        'answer_text',
        'is_correct',
        'score'
    ];

    public function peserta()
    {
        return $this->belongsTo(Peserta::class, 'peserta_id');
    }

    public function soal()
    {
        return $this->belongsTo(Soal::class);
    }

    public function modul_detail()
    {
        return $this->belongsTo(ModulDetail::class);
    }

    public function corrector()
    {
        return $this->belongsTo(User::class, 'corrector_id');
    }
}

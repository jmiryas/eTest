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
 * Class Soal
 *
 * @property string $id
 * @property string|null $modul_detail_id
 * @property string|null $tipe
 * @property string|null $isi
 * @property int|null $poin
 * @property int|null $urutan
 * @property Carbon|null $created_at
 * @property Carbon|null $updatd_at
 *
 * @property ModulDetail|null $modul_detail
 * @property Collection|SoalDetail[] $soal_details
 * @property Collection|UserAnswer[] $user_answers
 *
 * @package App\Models
 */
class Soal extends Model
{
    use HasUlids;

    protected $table = 'soal';
    public $incrementing = false;
    public $timestamps = false;

    protected $casts = [
        'poin' => 'int',
        'urutan' => 'int',
        'updatd_at' => 'datetime'
    ];

    protected $fillable = [
        'modul_detail_id',
        'tipe',
        'isi',
        'poin',
        'tipe_durasi',
        'durasi_original',
        'durasi_detik',
        'urutan',
        'updatd_at'
    ];

    public function modul_detail()
    {
        return $this->belongsTo(ModulDetail::class);
    }

    public function soal_details()
    {
        return $this->hasMany(SoalDetail::class);
    }

    public function user_answers()
    {
        return $this->hasMany(UserAnswer::class);
    }
}

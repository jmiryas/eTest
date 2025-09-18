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
 * Class Banksoal
 *
 * @property string $id
 * @property string|null $group_code
 * @property string|null $tipe
 * @property string|null $isi
 * @property int|null $poin
 * @property string|null $tipe_durasi
 * @property int|null $durasi_original
 * @property int|null $durasi_detik
 * @property int|null $urutan
 * @property Carbon|null $created_at
 * @property Carbon|null $updatd_at
 *
 * @property Collection|BanksoalDetail[] $banksoal_details
 *
 * @package App\Models
 */
class Banksoal extends Model
{
    use HasUlids;

    protected $table = 'banksoal';
    public $incrementing = false;
    public $timestamps = false;

    protected $casts = [
        'poin' => 'int',
        'durasi_original' => 'int',
        'durasi_detik' => 'int',
        'urutan' => 'int',
        'updatd_at' => 'datetime'
    ];

    protected $fillable = [
        'group_code',
        'tipe',
        'isi',
        'poin',
        'tipe_durasi',
        'durasi_original',
        'durasi_detik',
        'urutan',
        'updatd_at'
    ];

    public function banksoal_details()
    {
        return $this->hasMany(BanksoalDetail::class);
    }
}

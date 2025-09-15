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
 * Class ModulDetail
 *
 * @property string $id
 * @property string|null $modul_id
 * @property string|null $moduldetail_section_id
 * @property string|null $judul
 * @property string|null $deskripsi
 * @property Carbon|null $waktu_mulai
 * @property Carbon|null $waktu_selesai
 * @property int|null $durasi_menit
 * @property int|null $urutan
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Modul|null $modul
 * @property ModuldetailSection|null $moduldetail_section
 * @property Collection|Soal[] $soals
 *
 * @package App\Models
 */
class ModulDetail extends Model
{
    use HasUlids;

    protected $table = 'modul_detail';
    public $incrementing = false;

    protected $casts = [
        'waktu_mulai' => 'datetime',
        'waktu_selesai' => 'datetime',
        'durasi_menit' => 'int',
        'urutan' => 'int'
    ];

    protected $fillable = [
        'modul_id',
        'moduldetail_section_id',
        'judul',
        'deskripsi',
        'embedded_video',
        'waktu_mulai',
        'waktu_selesai',
        'durasi_menit',
        'urutan'
    ];

    public function modul()
    {
        return $this->belongsTo(Modul::class);
    }

    public function moduldetail_section()
    {
        return $this->belongsTo(ModuldetailSection::class);
    }

    public function soals()
    {
        return $this->hasMany(Soal::class);
    }
}

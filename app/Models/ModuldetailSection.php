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
 * Class ModuldetailSection
 *
 * @property string $id
 * @property int|null $urutan
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Collection|ModulDetail[] $modul_details
 *
 * @package App\Models
 */
class ModuldetailSection extends Model
{
    protected $table = 'moduldetail_section';
    public $incrementing = false;

    protected $casts = [
        'urutan' => 'int'
    ];

    protected $fillable = [
        'nama',
        'urutan'
    ];

    public function modul_details()
    {
        return $this->hasMany(ModulDetail::class);
    }
}

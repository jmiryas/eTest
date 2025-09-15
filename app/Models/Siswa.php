<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Siswa
 * 
 * @property string $nis
 * @property string|null $no_va
 * @property int|null $idasalsekolah
 * @property int|null $kodejk
 * @property string|null $kodejeniskeringanan
 * @property string|null $nama
 * @property string|null $panggilan
 * @property string|null $tempatlahir
 * @property Carbon|null $tgllahir
 * @property string|null $tahunmasuk
 * @property string|null $namabapak
 * @property string|null $namaibu
 * @property string|null $alamat
 * @property string|null $notelpon
 * @property string|null $namaori
 * @property string|null $templatefinger
 * @property string|null $nokartu
 * @property string|null $kelas_id
 * @property string|null $longit
 * @property string|null $latit
 * @property string|null $adress
 * @property string|null $pin
 * @property string|null $kamar_id
 * @property string|null $profil
 * @property string|null $kamar
 * @property string|null $asrama
 * @property string|null $lokasi_asrama
 * @property string|null $kodeAsrama
 * @property bool|null $status_ketua_kamar
 * @property Carbon|null $tgl_mapping
 * @property string|null $foto
 * @property string|null $nisn
 * 
 * @property Jeniskeringanan|null $jeniskeringanan
 * @property Jeniskelamin|null $jeniskelamin
 * @property Asalsekolah|null $asalsekolah
 * @property Collection|Amaliyah[] $amaliyahs
 * @property Collection|Bimbingankonseling[] $bimbingankonselings
 * @property Collection|Catatankhusu[] $catatankhusus
 * @property Collection|Detailpresensi[] $detailpresensis
 * @property Collection|Historykela[] $historykelas
 * @property Collection|Layananbk[] $layananbks
 * @property Collection|Lp[] $lps
 * @property Collection|OrangtuaSiswa[] $orangtua_siswas
 * @property Collection|Pelanggaran[] $pelanggarans
 * @property Collection|Realisasipenerimaan[] $realisasipenerimaans
 * @property Collection|Tagihan[] $tagihans
 * @property Collection|Targetpenerimaan[] $targetpenerimaans
 * @property Collection|Temptagihan[] $temptagihans
 * @property Collection|Uangsaku[] $uangsakus
 *
 * @package App\Models
 */
class Siswa extends Model
{
	protected $table = 'siswa';
	protected $primaryKey = 'nis';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'idasalsekolah' => 'int',
		'kodejk' => 'int',
		'tgllahir' => 'datetime',
		'status_ketua_kamar' => 'bool',
		'tgl_mapping' => 'datetime'
	];

	protected $fillable = [
		'nis',
		'no_va',
		'idasalsekolah',
		'kodejk',
		'kodejeniskeringanan',
		'nama',
		'panggilan',
		'tempatlahir',
		'tgllahir',
		'tahunmasuk',
		'namabapak',
		'namaibu',
		'alamat',
		'notelpon',
		'namaori',
		'templatefinger',
		'nokartu',
		'kelas_id',
		'longit',
		'latit',
		'adress',
		'pin',
		'kamar_id',
		'profil',
		'kamar',
		'asrama',
		'lokasi_asrama',
		'kodeAsrama',
		'status_ketua_kamar',
		'tgl_mapping',
		'foto',
		'nisn'
	];

	public function historykelas()
	{
		return $this->hasMany(Historykelas::class, 'nis');
	}

	public function tagihans()
	{
		return $this->hasMany(Tagihan::class, 'nis');
	}
}

<?php
declare(strict_types=1);

/**
 * Sesi 3 — PHP tidak punya constructor overloading.
 * Padanannya: default parameter + named constructor (static factory).
 */
class RekeningBank
{
    // TODO 1: ganti angka ajaib berikut menjadi konstanta bernama.
    //   bunga tahunan 0.025 · biaya admin 5000 · batas penarikan 5000000
    private const Bunga_tahunan = 0.025;
    private const administrasi = 5000;
    private const Batas_Penarikan = 5000000;

    // TODO 2: deklarasikan properti statis penghitung jumlah rekening.
    private static int $jumlahRekening = 0 ;
    private float $saldo;

    /**
     * Default parameter menggantikan constructor overloading.
     * TODO 3: lengkapi validasi nomor kosong dan saldo awal negatif.
     * TODO 4: naikkan penghitung jumlah rekening.
     */
    public function __construct(
        private readonly string $nomor,
        private readonly string $pemilik,
        float $saldoAwal = 0,
    ) {
        if (empty($nomor)){
            throw new InvalidArgumentException("Nomor rekening tidak boleh kosong");
        }
        if($saldoAwal <0){
            throw new InvalidArgumentException("Saldo awal tidak boleh kosong");
            
        }
        $this->saldo = $saldoAwal;
        self::$jumlahRekening++;
    }

    /**
     * TODO 5: named constructor — rekening pelajar, saldo awal nol.
     *         Gunakan `new static()`, BUKAN `new self()`.
     *         Alasannya ada di modul teori pertemuan 3 (LateBinding.php).
     */
    public static function rekeningPelajar(string $nomor, string $pemilik):static 
    {
        return new static ($nomor, $pemilik, 0);
    }
    public function setor(float $jumlah): void
    {
        // TODO 6
        if ($jumlah <=0 ){
            throw new InvalidArgumentException("Jumlah setoran tidak boleh negatif ");
        }
        $this->saldo += $jumlah;
    }

    public function tarik(float $jumlah): void
    {
        // TODO 7: tolak <= 0, tolak melebihi saldo, tolak melebihi batas sekali tarik.
        if ($jumlah <= 0){
            throw new InvalidArgumentException("Jumlah tarik harus lebih besar dari @");
        }
        if ($jumlah > $this->saldo) {
        throw new InvalidArgumentException("Jumlah tarik melebihi saldo");
        }
        if ($jumlah > self :: Batas_Penarikan){
            throw new InvalidArgumentException("Jumlah tarik melebihi batas penarikan");
        }
        $this->saldo -= $jumlah;

    }

    /** TODO 8 */
    public function potongBiayaAdmin(): void
    {
        $this->saldo -=self::administrasi;
    }

    /** TODO 9 */
    public static function getJumlahRekening(): int
    {
        return self::$jumlahRekening;   // ganti
    }

    /** TODO 10 */
    public static function bungaSetahun(float $pokok): float
    {
        return $pokok * self::Bunga_tahunan;   // ganti
    }

    public function getSaldo(): float { return $this->saldo; }
    public function getNomor(): string { return $this->nomor; }

    public function __toString(): string
    {
        return sprintf('Rekening[%s] %-14s Rp%s',
            $this->nomor, $this->pemilik, number_format($this->saldo, 2, ',', '.'));
    }
}
<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendEmailLaporan extends Mailable
{
    use Queueable, SerializesModels;

    // Properti untuk menyimpan data yang akan digunakan dalam view email || variabel nya disesuaikan dengan bagian view email di resorces ||View
    public $id_member;
    public $nama;
    public $tanggal;
    public $coach;
    public $informasi;

    /**
     * Create a new message instance.
     */
    public function __construct($data)
    {
        // Assign data ke dalam properti
        $this->id_member = $data['id_member'];
        $this->nama = $data['nama'];
        $this->tanggal = $data['tanggal'];
        $this->coach = $data['coach'];
        $this->informasi = $data['informasi']; // Masukkan alasan ke dalam properti
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // Menggunakan view 'konfirmasi_pesanan' dan mengirimkan data ke dalam view
        return $this->view('emails.informasi_laporan');
    }
}

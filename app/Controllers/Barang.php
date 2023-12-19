<?php

namespace App\Controllers;

use App\Models\BarangModel;
use App\Controllers\BaseController;
use App\Models\KategoriModel;
use Dompdf\Dompdf;
use Dompdf\Options;

class Barang extends BaseController
{
    protected $barangModel;
    protected $kategoriModel;

    public function __construct()
    {
        $this->barangModel = new BarangModel();
        $this->kategoriModel = new KategoriModel();
    }

    public function index()
    {

        $data = [
            'title' => 'Footwears | Barang',
            'judul' => 'Data Barang',
            'barang' => $this->barangModel->getAllBarang(),
            'kategori' => $this->kategoriModel->findAll(),
        ];
        return view('Barang/index', $data);
    }

    public function detailBarang($id)
    {
        $data = [
            'title' => 'Barang',
            'judul' => 'Detail Barang',
            'barang' => $this->barangModel->getBarang($id)
        ];

        if (empty($data['barang'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Barang dengan id : ' . $id .  ' Tidak Ditemukan');
        }

        return view('barang/detail_barang', $data);
    }

    public function tambahBarang()
    {
        $data  = [
            'title' => 'Barang',
            'judul' => 'Form Tambah Barang',
            'kategori' => $this->kategoriModel->findAll()
        ];

        return view('barang/tambah_barang', $data);
    }
    public function simpanBarang()
    {
        $validate = $this->validate([
            'nama_barang' => [
                'label' => 'Nama Barang',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong.',
                ]
            ],
            'id_kategori' => [
                'label' => 'Kategori',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong.'
                ]
            ],
            'gambar' => [
                'label' => 'Gambar',
                'rules' => 'is_image[gambar]|max_size[gambar,2048]|mime_in[gambar,image/jpg,image/png,image/jpeg]',
                'errors' => [
                    'max_size' => 'Ukuran gambar terlalu besar !!!',
                    'is_image' => 'File yang diupload bukan gambar !!!',
                    'mime_in' => 'File yang diupload harus berformat (JPG/JPEG/PNG)'
                ]
            ],
            'warna' => [
                'label' => 'Warna',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Tidak Boleh Kosong.'
                ]
            ],
            'ukuran' => [
                'label' => 'Ukuran',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Tidak Boleh Kosong.'
                ]
            ],
            'jumlah' => [
                'label' => 'Jumlah',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Tidak Boleh Kosong.'
                ]
            ],
        ]);



        if ($validate) {
            $file_gambar = $this->request->getFile('gambar');

            if ($file_gambar->getError() == 4) {
                $nama_gambar = 'default_image.jpg';
            } else {
                if ($file_gambar->isValid()) {
                    $nama_gambar = $file_gambar->getRandomName();
                    $file_gambar->move('img_data', $nama_gambar);
                } else {
                    return redirect()->back()->with('errors', $this->validator->listErrors());
                }
            }
            $this->barangModel->insert([
                'nama_barang' => esc($this->request->getVar('nama_barang')),
                'id_kategori' => esc($this->request->getVar('id_kategori')),
                'gambar' => esc($nama_gambar),
                'ukuran' => esc($this->request->getVar('ukuran')),
                'warna' => esc($this->request->getVar('warna')),
                'jumlah' => esc($this->request->getVar('jumlah')),
                'deskripsi' => esc($this->request->getVar('deskripsi')),
            ]);

            session()->setFlashdata('pesan', 'Data Berhasil Ditambahkan');
            return redirect()->to(base_url('barang'));
        } else {
            session()->setFlashdata('errors', $this->validator->listErrors());
            return redirect()->back()->withInput();
        }
    }

    public function hapusBarang($id)
    {
        $barang = $this->barangModel->find($id);

        if ($barang['gambar'] != 'default_image.jpg') {
            unlink('img_data/' . $barang['gambar']);
        }

        $this->barangModel->delete($id);
        session()->setFlashdata('pesan', 'Data Berhasil Dihapus');
        return redirect()->to(base_url('barang'));
    }

    public function editBarang($id)
    {
        $data = [
            'title' => 'Barang',
            'judul' => 'Form Ubah Barang',
            'barang' => $this->barangModel->getBarang($id),
            'kategori' => $this->kategoriModel->findAll(),
        ];
        return view('barang/edit_barang', $data);
    }

    public function updateBarang($id)
    {
        $validate = $this->validate([
            'nama_barang' => [
                'label' => 'Nama Barang',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong.',
                ]
            ],
            'id_kategori' => [
                'label' => 'Kategori',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong.'
                ]
            ],
            'gambar' => [
                'label' => 'Gambar',
                'rules' => 'is_image[gambar]|max_size[gambar,2048]|mime_in[gambar,image/jpg,image/png,image/jpeg]',
                'errors' => [
                    'max_size' => 'Ukuran gambar terlalu besar !!!',
                    'is_image' => 'File yang diupload bukan gambar !!!',
                    'mime_in' => 'File yang diupload harus berformat (JPG/JPEG/PNG)'
                ]
            ],
            'warna' => [
                'label' => 'Warna',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Tidak Boleh Kosong.'
                ]
            ],
            'ukuran' => [
                'label' => 'Ukuran',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Tidak Boleh Kosong.'
                ]
            ],
            'jumlah' => [
                'label' => 'Jumlah',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Tidak Boleh Kosong.'
                ]
            ],
        ]);

        if ($validate) {
            $file_gambar = $this->request->getFile('gambar');

            if ($file_gambar->getError() == 4) {
                $nama_gambar = 'default_image.jpg';
            } else {
                $nama_gambar = $file_gambar->getRandomName();
                $file_gambar->move('img_data', $nama_gambar);
            }
            $this->barangModel->save([
                'id_barang' => $id,
                'nama_barang' => esc($this->request->getVar('nama_barang')),
                'id_kategori' => esc($this->request->getVar('id_kategori')),
                'gambar' => esc($nama_gambar),
                'ukuran' => esc($this->request->getVar('ukuran')),
                'warna' => esc($this->request->getVar('warna')),
                'jumlah' => esc($this->request->getVar('jumlah')),
                'deskripsi' => esc($this->request->getVar('deskripsi')),
            ]);

            session()->setFlashdata('pesan', 'Data Berhasil Diubah');
            return redirect()->to(base_url('barang'));
        } else {
            session()->setFlashdata('errors', $this->validator->listErrors());
            return redirect()->back()->withInput();
        }
    }

    public function barangHabis()
    {
        $data = [
            'title' => 'Barang Habis',
            'judul' => 'Laporan Barang Habis',
            'habis' => $this->barangModel->getBarangHabis()
        ];

        return view('Barang/barang_habis', $data);
    }


    public function cetakBarangHabis()
    {

        $options = new Options();
        $options->set('enabled', true);
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);

        $dompdf = new Dompdf($options);

        $data['habis'] =  $this->barangModel->getBarangHabis();
        $html = view('barang/rep-barang-habis', $data);

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'potrait');
        $dompdf->render();
        $filename = 'barang-habis_' . date('YmdHis') . '.pdf';
        $dompdf->stream($filename);
    }
}
import { useEffect, useState } from 'react'
import { Button, Container, Row, Col, Table, Form } from 'react-bootstrap'
import { useNavigate } from 'react-router-dom';
import Header from '../Header';
import BerhasilMencari from '../../core/Responses/ResponseBerhasil/Pencarian/BerhasilMencari';
import KategoriPencarian from '../../core/Pencarian/Data/KategoriPencarian';
import CekMemilikiTokenAutentikasi from '../../core/Autentikasi/CekMemilikiTokenAutentikasi';
import RequestCariSoal from '../../core/Pencarian/RequestCariSoal';
import ResponseSoalPencarian from '../../core/Responses/ResponseBerhasil/Pencarian/ResponseSoalPencarian';

function HalamanJelajah() {

  const navigate = useNavigate()

  let [halamanDitampilkan, ] = useState<number>(5)

  let [memilikiToken, setMemilikiToken] = useState<boolean>(false)
  let [arrayHalaman, setArrayHalaman] = useState<number[]>([])

  let [kategoriPencarian, setKategoriPencarian] = useState<KategoriPencarian>({halaman: 1, judul: "", sort_by: "judul", sort_reverse: false})
  let [hasilPencarian, setHasilPencarian] = useState<BerhasilMencari|null>(null)

  const cekMemilikiToken : CekMemilikiTokenAutentikasi = new CekMemilikiTokenAutentikasi()
  const requestCariSoal: RequestCariSoal = new RequestCariSoal()

  function lakukanPencarian() {
    requestCariSoal.execute(kategoriPencarian, (hasil : any) => {
      if (hasil instanceof BerhasilMencari) {

        let batasBawah = Math.max(1, hasil.halaman - Math.trunc(halamanDitampilkan / 2))
        let batasAtas = Math.min(hasil.total_halaman, hasil.halaman + Math.trunc(halamanDitampilkan / 2))

        let arrayHalamanSementara : number[] = []
        for (let i = batasBawah; i <= batasAtas; i++) {
          arrayHalamanSementara.push(i)
        }
        
        setHasilPencarian(hasil)
        setArrayHalaman(arrayHalamanSementara)
      }
    })
  }

  const pindahHalamanMasuk = () => {
    navigate("/")
  }

  const pindahHalamanBuatSoal = () => {
    navigate("/buat-soal")
  }

  const pindahHalamanPengerjaan = (idSoal : string) => {
    navigate(`/soal/${idSoal}/pengerjaan`)
  }

  const setJudulPencarian = (judul : string) => {
    setKategoriPencarian({...kategoriPencarian, judul : judul})
  }

  useEffect(() => {
    if (cekMemilikiToken.cekApakahMemilikiTokenAutentikasi()) {
      setMemilikiToken(true)
    }
    lakukanPencarian()
  }, [])

  return (
    <>
      <Container className='min-vh-100 mw-100 m-0 p-0 d-flex flex-column'>
        <Header />
        <Col className='h-100 justify-content-center'>
          <Row className='m-0 p-0'>
            <p className='text-center m-0 py-3 fs-3 fw-bold mb-3'>
              Jelajah
            </p>
            <Row className='m-0 p-0 d-flex flex-row'>
              <Col xs={12} sm={12} md={12} lg={8} xl={8} className='m-0 p-2'>
                <Row className='m-0 p-0'>
                  <p className='fs-5 fw-bold text-center'>Daftar Soal</p>
                  <Col className='m-0 p-0' xs={12}>
                    <Row className='m-0 p-0 d-flex flex-row'>
                      <Col xs={10}>
                        <Row className='m-0 p-0 d-flex flex-row'>
                          <Col xs={4}>
                            <Form.Control className='my-2 mx-1 p-0 py-1 fs-6 text-center' placeholder='Pencarian dengan judul' value={kategoriPencarian.judul} onChange={(e) => {
                              setJudulPencarian(e.target.value)
                            }}/>
                          </Col>
                        </Row>
                      </Col>
                      <Col xs={2} className='d-flex flex-column justify-content-center'>
                        <Button variant='light' className='border border-dark rounded m-0 p-1' onClick={lakukanPencarian}>
                          Cari
                        </Button>
                      </Col>
                    </Row>
                  </Col>
                  <Row className="m-0 p-0 d-flex flex-row">
                    <Table bordered hover>
                      <thead>
                        <tr>
                          <th className='text-center fs-6 fw-normal col-8' onClick={() => {
                            if (kategoriPencarian.sort_by == "judul") {
                              setKategoriPencarian({...kategoriPencarian, sort_reverse : !kategoriPencarian.sort_reverse})
                            }
                            else {
                              setKategoriPencarian({...kategoriPencarian, halaman: 1, sort_by : "judul", sort_reverse : false})
                            }
                            lakukanPencarian()
                          }}>Judul {kategoriPencarian.sort_by == "judul" ? (kategoriPencarian.sort_reverse ? String.fromCharCode(0x25B3) : String.fromCharCode(0x25BD)) : ""}</th>
                          <th className='text-center fs-6 fw-normal col-1' onClick={() => {
                            if (kategoriPencarian.sort_by == "jumlah_submit") {
                              setKategoriPencarian({...kategoriPencarian, sort_reverse : !kategoriPencarian.sort_reverse})
                            }
                            else {
                              setKategoriPencarian({...kategoriPencarian, halaman: 1, sort_by : "jumlah_submit", sort_reverse : false})
                            }
                            lakukanPencarian()
                          }}>Submit {kategoriPencarian.sort_by == "jumlah_submit" ? (kategoriPencarian.sort_reverse ? String.fromCharCode(0x25B3) : String.fromCharCode(0x25BD)) : ""}</th>
                          <th className='text-center fs-6 fw-normal col-1' onClick={() => {
                            if (kategoriPencarian.sort_by == "jumlah_berhasil") {
                              setKategoriPencarian({...kategoriPencarian, sort_reverse : !kategoriPencarian.sort_reverse})
                            }
                            else {
                              setKategoriPencarian({...kategoriPencarian, halaman: 1, sort_by : "jumlah_berhasil", sort_reverse : false})
                            }
                            lakukanPencarian()
                          }}>Berhasil {kategoriPencarian.sort_by == "jumlah_berhasil" ? (kategoriPencarian.sort_reverse ? String.fromCharCode(0x25B3) : String.fromCharCode(0x25BD)) : ""}</th>
                          <th className='text-center fs-6 fw-normal col-1' onClick={() => {
                            if (kategoriPencarian.sort_by == "persentase_berhasil") {
                              setKategoriPencarian({...kategoriPencarian, sort_reverse : !kategoriPencarian.sort_reverse})
                            }
                            else {
                              setKategoriPencarian({...kategoriPencarian, halaman: 1, sort_by : "persentase_berhasil", sort_reverse : false})
                            }
                            lakukanPencarian()
                          }}>Persentase {kategoriPencarian.sort_by == "persentase_berhasil" ? (kategoriPencarian.sort_reverse ? String.fromCharCode(0x25B3) : String.fromCharCode(0x25BD)) : ""}</th>
                        </tr>
                      </thead>
                      <tbody>
                        {hasilPencarian != null && hasilPencarian.hasil_pencarian.map((value : ResponseSoalPencarian, index: number) =>
                          (<tr key={"soal: " + index} onClick={() => {pindahHalamanPengerjaan(value.id_soal)}}>
                            <td className='fs-6 fw-normal text-start'>{value.judul}</td>
                            <td className='fs-6 fw-normal text-center'>{value.jumlah_berhasil}</td>
                            <td className='fs-6 fw-normal text-center'>{value.jumlah_submit}</td>
                            <td className='fs-6 fw-normal text-center'>{value.persentase_berhasil}</td>
                          </tr>)
                        )}
                      </tbody>
                    </Table>
                  </Row>
                  <Col xs={12} className='m-0 p-0'>
                    <Col xs={12} className='justify-content-center'>
                      <Row className='m-0 p-0 d-flex flex-row justify-content-center'>
                        <Col className='p-0 m-0' xs={1} key="mundur">
                          <Button variant={kategoriPencarian.halaman == 1 ? 'light' : 'dark'} className='border border-dark flex-row' onClick={() => {
                            setKategoriPencarian({...kategoriPencarian, halaman: Math.max(1, kategoriPencarian.halaman - 1)})
                            lakukanPencarian()
                          }}>
                            &#8592;
                          </Button>
                        </Col>
                        {arrayHalaman.map((h : number) => 
                          (<Col className='p-0 m-0' xs={1} key={h}>    
                            <Button variant={h == kategoriPencarian.halaman ? 'light' : 'dark'} className='border border-dark' onClick={() => {
                              let halamanSebelumnya = kategoriPencarian.halaman;
                              setKategoriPencarian({...kategoriPencarian, halaman: h})
                              if (h != halamanSebelumnya) {
                                lakukanPencarian()
                              }
                            }}>
                              {h}
                            </Button>
                          </Col>)
                        )}
                        <Col className='p-0 m-0' xs={1} key="maju">
                          <Button variant={kategoriPencarian.halaman == (hasilPencarian != null ? hasilPencarian.total_halaman : 1)  ? 'light' : 'dark'} className='border border-dark' onClick={() => {
                            setKategoriPencarian({...kategoriPencarian, halaman: Math.min(hasilPencarian != null ? hasilPencarian.total_halaman : 1, kategoriPencarian.halaman + 1)})
                            lakukanPencarian()
                          }}>
                            &#8594;
                          </Button>
                        </Col>
                      </Row>
                    </Col>
                  </Col>
                </Row>
              </Col>
              <Col xs={12} sm={12} md={12} lg={4} xl={4} className='m-0 p-0'>
                <Row className='m-0 p-0 flex-column justify-content-center'>
                  <Col xs={12}>
                    <p className='text-center fs-3 fw-bold'>Kontribusi</p>
                  </Col>
                  <Col xs={12}>
                    <p className='text-left fs-6 p-2'>Ingin ikut berkontribusi sebagai sesama penyuka pemrograman dan algoritma? Bantu kami dalam menambahkan kumpulan soal. Soal-soal yang dibuat akan sangat membantu programmer lain dalam meningkatkan kemampuan mereka. \(^_^)/</p>
                  </Col>
                  <Col xs={12} className='d-flex flex-row justify-content-center'>
                    {memilikiToken ? (
                      <Button variant='dark' className='px-4 rounded-pill' onClick={pindahHalamanBuatSoal}>
                        Buat Soal
                      </Button>
                      ) : (
                      <Row className='m-0 p-0 flex-column justify-content-center'>
                        <Col xs={12} className='m-0 p-0'>
                          <p className='m-0 my-2 p-0 text-center fs-6'>
                            Harus masuk untuk membuat soal
                          </p>
                        </Col>
                        <Col xs={12} className='m-0 p-0 d-flex flex-row justify-content-center'>
                          <Button variant='dark' className='px-4 rounded-pill' onClick={pindahHalamanMasuk}>
                            Masuk
                          </Button>
                        </Col>
                      </Row>
                      ) 
                    }
                  </Col>
                </Row>
              </Col>
            </Row>
          </Row>
        </Col>
      </Container>
    </>
  )
}

export default HalamanJelajah

import { useEffect, useState } from 'react'
import { Button, Container, Row, Col, Table, Form } from 'react-bootstrap'
import { useNavigate } from 'react-router-dom';
import InterfaceCekMemilikiTokenAutentikasi from '../core/Autentikasi/Interface/InterfaceCekMemilikiTokenAutentikasi';
import CekMemilikiTokenAutentikasi from '../core/Autentikasi/CekMemilikiTokenAutentikasi';
import Header from './Header';
import DaftarSoal from '../core/Data/DaftarSoal';
import InterfacePencarianSoal from '../core/Pencarian/Interface/InterfacePencarianSoal';
import PencarianSoal from '../core/Pencarian/PencarianSoal';
import KategoriPencarian from '../core/Data/KategoriPencarian';
import HasilPencarian from '../core/Data/HasilPencarian';

function HalamanJelajah() {

  const navigate = useNavigate()

  let [halamanDitampilkan, ] = useState<number>(5)

  let [memilikiToken, setMemilikiToken] = useState<boolean>(false)
  let [halaman, setHalaman] = useState<number>(1)
  let [totalHalaman, setTotalHalaman] = useState<number>(1)
  let [arrayHalaman, setArrayHalaman] = useState<number[]>([])
  
  let [judulPencarian, setJudulPencarian] = useState<string>("")
  let [kategoriPencarian, setKategoriPencarian] = useState<KategoriPencarian>(new KategoriPencarian("", "id_soal", false))
  
  let [daftarSoal, setDaftarSoal] = useState<DaftarSoal[]>([])

  const cekMemilikiToken : InterfaceCekMemilikiTokenAutentikasi = new CekMemilikiTokenAutentikasi()
  const pencarianSoal : InterfacePencarianSoal = new PencarianSoal()

  function lakukanPencarian() {
    pencarianSoal.cariSoal(kategoriPencarian, halaman, (hasil : any) => {
      if (hasil instanceof HasilPencarian) {

        let batasBawah = Math.max(1, hasil.halaman - Math.trunc(halamanDitampilkan / 2))
        let batasAtas = Math.min(hasil.totalHalaman, hasil.halaman + Math.trunc(halamanDitampilkan / 2))

        let arrayHalamanSementara : number[] = []
        for (let i = batasBawah; i <= batasAtas; i++) {
          arrayHalamanSementara.push(i)
        }
        
        setDaftarSoal(hasil.daftarSoal)
        setTotalHalaman(hasil.totalHalaman)
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

  const pindahHalamanPengerjaan = (idSoal : number) => {
    navigate(`/soal/${idSoal}/pengerjaan`)
  }

  const simpanJudul = () => {
    setKategoriPencarian({...kategoriPencarian, judul : judulPencarian})
  }

  useEffect(() => {
    if (cekMemilikiToken.cekApakahMemilikiTokenAutentikasi()) {
      setMemilikiToken(true)
    }
    lakukanPencarian()
  }, [])

  useEffect(() => {
    lakukanPencarian()
  }, [kategoriPencarian, halaman])

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
                            <Form.Control className='my-2 mx-1 p-0 py-1 fs-6 text-center' placeholder='Pencarian dengan judul' value={judulPencarian} onChange={(e) => {
                              setJudulPencarian(e.target.value)
                            }}/>
                          </Col>
                        </Row>
                      </Col>
                      <Col xs={2} className='d-flex flex-column justify-content-center'>
                        <Button variant='light' className='border border-dark rounded m-0 p-1' onClick={simpanJudul}>
                          Cari
                        </Button>
                      </Col>
                    </Row>
                  </Col>
                  <Row className="m-0 p-0 d-flex flex-row">
                    <Table bordered hover>
                      <thead>
                        <tr>
                          <th className='text-center fs-6 fw-normal col-1' onClick={() => {
                            if (kategoriPencarian.sortby == "id_soal") {
                              setKategoriPencarian({...kategoriPencarian, sortbyReverse : !kategoriPencarian.sortbyReverse})
                            }
                            else {
                              setKategoriPencarian({...kategoriPencarian, sortby : "id_soal", sortbyReverse : false})
                              setHalaman(1)
                            }
                          }}>ID {kategoriPencarian.sortby == "id_soal" ? (kategoriPencarian.sortbyReverse ? String.fromCharCode(0x25B3) : String.fromCharCode(0x25BD)) : ""}</th>
                          <th className='text-center fs-6 fw-normal col-8' onClick={() => {
                            if (kategoriPencarian.sortby == "judul") {
                              setKategoriPencarian({...kategoriPencarian, sortbyReverse : !kategoriPencarian.sortbyReverse})
                            }
                            else {
                              setKategoriPencarian({...kategoriPencarian, sortby : "judul", sortbyReverse : false})
                              setHalaman(1)
                            }
                          }}>Judul {kategoriPencarian.sortby == "judul" ? (kategoriPencarian.sortbyReverse ? String.fromCharCode(0x25B3) : String.fromCharCode(0x25BD)) : ""}</th>
                          <th className='text-center fs-6 fw-normal col-1' onClick={() => {
                            if (kategoriPencarian.sortby == "jumlah_submit") {
                              setKategoriPencarian({...kategoriPencarian, sortbyReverse : !kategoriPencarian.sortbyReverse})
                            }
                            else {
                              setKategoriPencarian({...kategoriPencarian, sortby : "jumlah_submit", sortbyReverse : false})
                              setHalaman(1)
                            }
                          }}>Submit {kategoriPencarian.sortby == "jumlah_submit" ? (kategoriPencarian.sortbyReverse ? String.fromCharCode(0x25B3) : String.fromCharCode(0x25BD)) : ""}</th>
                          <th className='text-center fs-6 fw-normal col-1' onClick={() => {
                            if (kategoriPencarian.sortby == "jumlah_berhasil") {
                              setKategoriPencarian({...kategoriPencarian, sortbyReverse : !kategoriPencarian.sortbyReverse})
                            }
                            else {
                              setKategoriPencarian({...kategoriPencarian, sortby : "jumlah_berhasil", sortbyReverse : false})
                              setHalaman(1)
                            }
                          }}>Berhasil {kategoriPencarian.sortby == "jumlah_berhasil" ? (kategoriPencarian.sortbyReverse ? String.fromCharCode(0x25B3) : String.fromCharCode(0x25BD)) : ""}</th>
                          <th className='text-center fs-6 fw-normal col-1' onClick={() => {
                            if (kategoriPencarian.sortby == "persentase_berhasil") {
                              setKategoriPencarian({...kategoriPencarian, sortbyReverse : !kategoriPencarian.sortbyReverse})
                            }
                            else {
                              setKategoriPencarian({...kategoriPencarian, sortby : "persentase_berhasil", sortbyReverse : false})
                              setHalaman(1)
                            }
                          }}>Persentase {kategoriPencarian.sortby == "persentase_berhasil" ? (kategoriPencarian.sortbyReverse ? String.fromCharCode(0x25B3) : String.fromCharCode(0x25BD)) : ""}</th>
                        </tr>
                      </thead>
                      <tbody>
                        {daftarSoal.map((value: DaftarSoal, index: number) =>
                          (<tr key={"soal: " + index} onClick={() => {pindahHalamanPengerjaan(value.idSoal.id)}}>
                            <td className='fs-6 fw-normal text-center'>{value.idSoal.id}</td>
                            <td className='fs-6 fw-normal text-start'>{value.judul}</td>
                            <td className='fs-6 fw-normal text-center'>{value.jumlahSubmit}</td>
                            <td className='fs-6 fw-normal text-center'>{value.berhasilSubmit}</td>
                            <td className='fs-6 fw-normal text-center'>{value.persentaseBerhasil}</td>
                          </tr>)
                        )}
                      </tbody>
                    </Table>
                  </Row>
                  <Col xs={12} className='m-0 p-0'>
                    <Col xs={12} className='justify-content-center'>
                      <Row className='m-0 p-0 d-flex flex-row justify-content-center'>
                        <Col className='p-0 m-0' xs={1} key="mundur">
                          <Button variant={halaman == 1 ? 'light' : 'dark'} className='border border-dark flex-row' onClick={() => {
                            setHalaman(Math.max(1, halaman - 1))
                          }}>
                            &#8592;
                          </Button>
                        </Col>
                        {arrayHalaman.map((h : number) => 
                          (<Col className='p-0 m-0' xs={1} key={h}>    
                            <Button variant={h == halaman ? 'light' : 'dark'} className='border border-dark' onClick={() => {
                              setHalaman(h)
                            }}>
                              {h}
                            </Button>
                          </Col>)
                        )}
                        <Col className='p-0 m-0' xs={1} key="maju">
                          <Button variant={halaman == totalHalaman ? 'light' : 'dark'} className='border border-dark' onClick={() => {
                            setHalaman(Math.min(totalHalaman, halaman + 1))
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
